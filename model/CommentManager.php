<?php

namespace SC19DEV\Blog\Model;
require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getNbrComments($postId)
    {
        $sql = 'SELECT COUNT(*) FROM comments WHERE post_id = ?';
        $nbrComments = $this->getColumn($sql, [$postId]);
        return $nbrComments;


    }

    public function getComments($postId)
    {
        $sql = 'SELECT id, post_id, author, comment, visible, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') 
                AS comment_date_fr,reported 
                FROM comments 
                WHERE post_id = ? 
                ORDER BY comment_date DESC';
        $comments = $this->getAll($sql, [$postId]);

        return $comments;

    }

    public function getAllComments($reported, $sort, $order)
    {
        $reported = filter_var($reported, FILTER_VALIDATE_BOOLEAN);
        $order = strtoupper($order);

        switch ($sort) {
            case 'date':
                $critsort = 'comment_date';
                break;
            case 'post':
                $critsort = 'post_id';
                break;
            case 'id':
                $critsort = 'id';
                break;
        }

        if ($reported == FALSE) {
            $sql = 'SELECT id, post_id, author, comment, comment_date, reported, visible 
                                        FROM comments
                                        ORDER BY '.$critsort.'
                                        '.$order;
        } else {
            $sql = 'SELECT id, post_id, author, comment, comment_date, reported, visible 
                                        FROM comments 
                                        WHERE reported > 0 
                                        ORDER BY '.$critsort.' 
                                        '.$order;
        }

        $comments = $this->getAll($sql, []);

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $sql = 'INSERT INTO comments(post_id, author, comment, comment_date, reported, visible) 
                VALUES(?, ?, ?, NOW(),0,1)';

        $affectedLines = $this->executeStatement($sql, [$postId, $author, $comment]);

        return $affectedLines;
    }


    public function delComment($id)
    {
        $sql = 'DELETE FROM comments WHERE id=' . $id . '';
        $del = $this->executeStatement($sql, [$id]);

        return $del;
    }

    public function reportComment($id)
    {
        $sql = 'UPDATE comments SET reported = reported + 1 WHERE id=' . $id . '';
        $req = $this->executeStatement($sql, [$id]);

        return $req;
    }

    public function setVisibilityComment($id)
    {
        $sql = 'SELECT visible FROM comments WHERE  id=' . $id . '';
        $visibleStatus = $this->getColumn($sql, [$id]);

        if ($visibleStatus == 1) {
            $visibleStatus = 0;
        } else {
            $visibleStatus = 1;
        }

        $sql = 'UPDATE comments SET visible = ? WHERE  id=' . $id . '';
        $req = $this->executeStatement($sql, [$visibleStatus]);
        return $req;
    }
}