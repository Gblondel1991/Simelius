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
        u.lastname,
        u.firstname,
        u.email,
        p.profession_id,
        p.name
        FROM article as a
        JOIN user as u
        ON a.user_id = u.user_id
        JOIN profession as p
        ON p.profession_id = u.profession_id
        WHERE p.profession_id = ? AND A.`status`=1;';

    $stmt =$pdo->prepare($sql);
    $articles = [];
    if ($stmt->execute(array($profession_id))) {
        $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    return $articles;
}