<?php

namespace SC19DEV\Blog\Model;
require_once("model/Manager.php");
require_once("model/CommentManager.php");

class PostManager extends Manager
{
    public function getPostsId()
    {
        $sql = 'SELECT id, chapnumber, title, content, DATE_FORMAT(creation_date, \'%e %M %Y\')
                                    AS creation_date_fr,
                                    DAY(creation_date) AS JOUR,
                                    MONTH(creation_date) AS MOIS,
                                    YEAR(creation_date) AS ANNEE, edit_date, online
                                    FROM posts ORDER BY creation_date DESC';
        $req = $this->executeStatement($sql, []);

        $idPostList = array();
        while ($data = $req->fetch()) {
            array_push($idPostList, $data['id']);
        }
        return $idPostList;
    }

    public function setNbrComments($postId, $nbrComments)
    {
        $sql = 'UPDATE posts SET comment_number = ? WHERE id=?';
        $req = $this->executeStatement($sql, [$nbrComments, $postId]);

    }

    public function getPosts($online, $sort, $order)
    {
        $isOnline = 0;

        if ($online == true) {
            $isOnline = 1;
        }

        $order = strtoupper($order);

        switch ($sort) {
            case 'date':
                $critsort = 'creation_date';
                break;
            case 'postid':
                $critsort = 'id';
                break;
        }

        $sql = 'SELECT id, chapnumber, title, content, comment_number, DATE_FORMAT(creation_date, \'%e %M %Y\') AS creation_date_fr, DAY(creation_date) AS JOUR, MONTH(creation_date) AS MOIS,  YEAR(creation_date) AS ANNEE, edit_date, online
                                    FROM posts
                                    WHERE online >= ' . $isOnline . '
                                    ORDER BY ' . $critsort . '
                                    ' . $order;
        $posts = $this->getAll($sql, []);
        return $posts;

    }

    public function getnbrPosts()
    {
        $sql = 'SELECT COUNT(*) FROM posts';
        $nbr = $this->getColumn($sql, []);
        return $nbr;
    }

    public function getPost($postId)
    {
        $sql = 'SELECT id, chapnumber, title, content, DATE_FORMAT(creation_date, \'%D %M %Y\')
                AS creation_date_fr, edit_date, online
                FROM posts WHERE id = ?';
        $post = $this->getOne($sql, [$postId]);
        return $post;
    }

    public function CreatePost($title, $content, $chapnumber, $action)
    {
        if (htmlspecialchars($action) == 'Publier') {
            $status = 1;
        } else {
            $status = 0;
        }

        $sql = 'INSERT INTO posts(title, content, chapnumber, creation_date, edit_date,comment_number,online)
                                        VALUES(?, ?, ?, NOW(),NOW(),0,?)';
        $affectedLines = $this->executeStatement($sql, [$title, $content, $chapnumber, $status]);
        return $affectedLines;

    }

    public function ModifyPost($title, $id, $chapnumber, $content, $action)
    {
        if (htmlspecialchars($action) == 'Publier') {
            $status = 1;
        } else {
            $status = 0;
        }

        $sql = 'UPDATE posts SET title=?, content=?, chapnumber=?, edit_date=NOW(), online=? WHERE id=?';
        $affectedLines = $this->executeStatement($sql, [$title, $content, $chapnumber, $status, $id]);
        return $affectedLines;
    }

    public function setStatusPost($id)
    {
        $sql = 'SELECT online FROM posts WHERE  id=?';
        $status = $this->getColumn($sql, [$id]);

        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $sql = 'UPDATE posts SET online = ? WHERE  id= ? ';
        $rep = $this->executeStatement($sql, [$status, $id]);
        return $rep;

    }

    public function deletePost($id)
    {
        $sql = 'DELETE FROM posts WHERE id= ?';
        $res = $this->executeStatement($sql, [$id]);
//        return $res;
    }
}