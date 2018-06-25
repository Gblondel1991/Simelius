<?php
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
        u.experience,
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

function getCategories(PDO $pdo) {
    $sql = 'SELECT category_id, name FROM category ORDER BY name;';
    $stmt = $pdo->prepare($sql);

    $categories = [];
    if($stmt->execute()) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $categories;
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
    $stmt->execute($dataComment);
}

