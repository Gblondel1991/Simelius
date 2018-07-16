<?php
/////////////////////////////////articles///////////////////////////////////
function getArticles ($pdo, $profession_id) {

    $sql = 'SELECT
		a.article_id,
        a.user_id,
        a.title,
        a.content,
        a.created_at,
        a.updated_at,
        a.`status`,
        ac.category_id,
        c.name,
        u.lastname,
        u.firstname,
        u.email,
        u.society,
        u.experience,
        u.profile_picture,
        p.profession_id,
		GROUP_CONCAT(c.name) as categories
        FROM article as a
        LEFT JOIN article_has_category as ac
		ON ac.article_id = a.article_id
        LEFT JOIN category as c
		ON ac.category_id = c.category_id
        JOIN user as u
        ON a.user_id = u.user_id
        JOIN profession as p
        ON p.profession_id = u.profession_id
        WHERE p.profession_id = ? AND A.`status`=1
        GROUP BY a.article_id
		ORDER BY a.created_at DESC;';

    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($profession_id))) {
        $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    return $articles;
}

function getUserArticles ($pdo, $user_id) {
    $sql = 'SELECT
		a.article_id,
        a.user_id,
        a.title,
        a.content,
        a.created_at,
        a.updated_at,
        a.`status`,
        ac.category_id,
        c.name,
        u.lastname,
        u.firstname,
        u.email,
        u.society,
        u.experience,
        u.profile_picture,
        p.profession_id,
		GROUP_CONCAT(c.name) as categories
        FROM article as a
        LEFT JOIN article_has_category as ac
		ON ac.article_id = a.article_id
        LEFT JOIN category as c
		ON ac.category_id = c.category_id
        JOIN user as u
        ON a.user_id = u.user_id
        JOIN profession as p
        ON p.profession_id = u.profession_id
        WHERE u.user_id = ? AND A.`status`=1
        GROUP BY a.article_id
		ORDER BY a.created_at DESC;';

    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($user_id))) {
        $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    return $articles;
}

function addArticle(PDO $pdo, $newArticle) {
    $sql = 'INSERT INTO article VALUES(
               NULL,
               :user_id,
               :title,
               :content,
               NOW(),
               NULL,
               1
                )';
    $sqlCat= 'INSERT INTO article_has_category VALUES (
                ?,
                ?
                )';

    $dataArticle=array(
        'user_id' => $newArticle['user_id'],
        'title' => $newArticle['title'],
        'content' => $newArticle['content']
    );

    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($dataArticle);

        $article_id = $pdo->lastInsertId();
        $stmt = $pdo -> prepare($sqlCat);

        foreach ($newArticle['category'] as $category_id) {
            $stmt->execute(array($article_id, $category_id));
        }

        $pdo->commit();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
    return 0;
}

function deleteArticle($pdo, $article_id) {
    $sql = 'DELETE FROM article WHERE article_id = ?';
    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($article_id))) {
        return $articles;
}}

function updateArticle($pdo, $updatedArticle) {
    $sql = 'UPDATE article SET
                content = ?,
                updated_at = NOW()
                WHERE article_id  = ?;';

    $stmt =$pdo->prepare($sql);

    $dataArticle = array(
        $updatedArticle['content'],
        $updatedArticle['article_id']
    );

    if ($stmt->execute($dataArticle)) {
    return true;
    }

    return false;
}



///////////////////////////////////////Comments//////////////////////////////////////////
///
function getComments ($pdo, $article_id) {
    $sql = 'SELECT
            co.comment_id,
            co.user_id,
            co.article_id,
            co.content,
            co.created_at,
            co.updated_at,
            co.is_activated,
            u.firstname,
            u.lastname,
            u.society,
            u.experience,
            u.profile_picture
            FROM comment as co
            JOIN user as u
            ON co.user_id = u.user_id
            WHERE article_id = ?
            ORDER BY created_at DESC;
		;';

    $stmt =$pdo->prepare($sql);
    $comments = [];
    if ($stmt->execute(array($article_id))) {
        $comments = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    return $comments;
}

function getUserComments($pdo, $user_id) {
    $sql = 'SELECT 
        a.article_id,
        a.user_id,
        a.title,
        a.content,
        a.created_at,
        a.updated_at,
        a.`status`,
        c.`name`,
        u.lastname,
        u.firstname,
        u.email,
        u.society,
        u.experience,
        u.profile_picture,
		GROUP_CONCAT(c.name) as categories
		from article as a 
		RIGHT JOIN comment as co 
		ON a.article_id = co.article_id
        LEFT JOIN article_has_category as ac
		ON ac.article_id = a.article_id
		LEFT JOIN category as c
		ON ac.category_id = c.category_id
		JOIN user as u
        ON a.user_id = u.user_id
		WHERE co.user_id = ?
        GROUP BY a.article_id
		ORDER BY a.created_at DESC;';

    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($user_id))) {
        $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    return $articles;
}

function addComment($pdo, $comment) {
    $sql = 'INSERT INTO comment VALUES (
            NULL,
            :user_id,
            :article_id,
            :content,
            NOW(),
            NULL,
            1
            )';

    $dataComment = array(
        'user_id' => $comment['user_id'],
        'article_id' => $comment['article_id'],
        'content' => $comment['content']
    );

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($dataComment));

    return $comment;
}

function deleteComment($pdo, $comment_id) {
    $sql = 'DELETE FROM comment WHERE comment_id = ?';
    $stmt =$pdo->prepare($sql);
    $comments = [];
    if ($stmt->execute(array($comment_id))) {
        return $comments;
    }}

function updateComment($pdo, $updateComment) {
    $sql = 'UPDATE comment SET
                content = ?,
                updated_at = NOW()
                WHERE comment_id = ?;';

    $stmt =$pdo->prepare($sql);

    $dataComment = array(
        $updateComment['content'],
        $updateComment['comment_id']
    );

    if ($stmt->execute($dataComment)) {
        return true;
    }
    return false;
}

/////////////////////////////////////Relevance/////////////////////////////////////
function getRelevance($pdo, $comment_id) {
    $sql="SELECT * FROM revelant_answer WHERE comment_id = ?";
    $stmt =$pdo->prepare($sql);
    $relevance = [];
    if ($stmt->execute(array($comment_id))) {
        $relevance = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $relevance;
}

function getCommentRelevance($pdo, $comment_id) {
    $sql = 'SELECT count(*) FROM revelant_answer WHERE comment_id = ?';

    $stmt =$pdo->prepare($sql);
    $commentRelevance = [];
    if ($stmt->execute(array($comment_id))) {
        $commentRelevance = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $commentRelevance;
}

function getArticleRelevance($pdo, $article_id) {
    $sql = 'SELECT count(*) FROM revelant_answer as ra JOIN comment as c ON ra.comment_id = c.comment_id WHERE article_id = ?;';

    $stmt=$pdo->prepare($sql);
    $articleRelevance = [];
    if ($stmt->execute(array($article_id))) {
        $articleRelevance = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $articleRelevance;
}

function addRelevance($pdo, $relevance) {
    $sql = 'INSERT INTO revelant_answer VALUES (
            :user_id,
            :comment_id
)';

    $data = array(
        'user_id' => $relevance['user_id'],
        'comment_id' => $relevance['comment_id'],
    );

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($data)) {
    }

    return $relevance;
}

function deleteRelevance($pdo, $relevance)
{
    $sql = 'DELETE FROM revelant_answer WHERE user_id = :user_id AND comment_id = :comment_id; ';
    $data = array(
        'user_id' => $relevance['user_id'],
        'comment_id' => $relevance['comment_id'],
    );

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($data)) {
    }
    return $relevance;
}

function getUserRelevances($pdo, $user_id) {
    $sql = 'SELECT 
		ra.user_id,
		ra.comment_id,
		a.article_id,
        a.title,
        a.content,
        a.created_at,
        a.updated_at,
        a.`status`,
        ac.category_id,
        c.name,
        u.lastname,
        u.firstname,
        u.email,
        u.society,
        u.profile_picture,
        u.experience,
        GROUP_CONCAT(c.name) as categories
		FROM revelant_answer as ra
        JOIN comment as co
        ON ra.comment_id = co.comment_id
        JOIN article as a
        ON co.article_id = a.article_id
        LEFT JOIN article_has_category as ac
		ON ac.article_id = a.article_id
		LEFT JOIN category as c
		ON ac.category_id = c.category_id
		JOIN user as u
        ON a.user_id = u.user_id
		where ra.user_id = ?
        GROUP BY a.article_id
		ORDER BY a.created_at DESC;';

    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($user_id))) {
        $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    return $articles;
}

/////////////////////////////////////////////Categories/////////////////////////////////////////////
function getCategories(PDO $pdo) {
    $sql = 'SELECT category_id, name FROM category ORDER BY name;';
    $stmt = $pdo->prepare($sql);

    $categories = [];
    if($stmt->execute()) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $categories;
}

//////////////////////////////////STATS///////////////////////////////
function getProfessionArticlesCount($pdo, $user_id) {
    $sql = 'SELECT count(*) FROM article as A JOIN user as u WHERE u.profession_id = ?';

    $stmt =$pdo->prepare($sql);
    $professionArticlesCount = [];
    if ($stmt->execute(array($user_id))) {
        $professionArticlesCount = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $professionArticlesCount;
}