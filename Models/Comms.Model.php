<?php
require_once './Models/Model.php';

class Comments {
    public $commentid;
    public $fileid;
    public $userid;
    public $content;
    public $createdat;
    private static $table = "comments";

    public static function getCommsById($commentid) {
        $results = Model::find(self::$table, ['comment_id' => $commentid]);

        $comments = [];

        foreach ($results as $result) {
            $comment = new self();
            $comment->commentid = $result["comment_id"];
            $comment->fileid = $result["file_id"];
            $comment->userid = $result["user_id"];
            $comment->content = $result["content"];
            $comment->createdat = $result["created_at"];
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public static function getCommsByFileId($fileid) {
        $results = Model::find(self::$table, ['file_id' => $fileid]);

        $comments = [];

        foreach ($results as $result) {
            $comment = new self();
            $comment->commentid = $result["comment_id"];
            $comment->fileid = $result["file_id"];
            $comment->userid = $result["user_id"];
            $comment->content = $result["content"];
            $comment->createdat = $result["created_at"];
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public static function getCommsByUserId($userid) {
        $results = Model::find(self::$table, ['user_id' => $userid]);

        $comments = [];

        foreach ($results as $result) {
            $comment = new self();
            $comment->commentid = $result["comment_id"];
            $comment->fileid = $result["file_id"];
            $comment->userid = $result["user_id"];
            $comment->content = $result["content"];
            $comment->createdat = $result["created_at"];
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public static function createComment($fileid, $userid, $content){
        $result = Model::insert(self::$table, ["file_id" => $fileid, "user_id" => $userid, "content" => $content]);
        
        $comment = new self();
        $comment->commentid = $result["comment_id"];
        $comment->fileid = $result["file_id"];
        $comment->userid = $result["user_id"];
        $comment->content = $result["content"];
        $comment->createdat = $result["created_at"];

        return $comment;
    }

    public static function updateComment($commentid, $content) {
        $result = Model::update(
            self::$table,
            array_merge(
                ["content" => $content]
            ),
            ["comment_id" => $commentid]
        );

        $comment = new self();
        $comment->commentid = $result["comment_id"];
        $comment->fileid = $result["file_id"];
        $comment->userid = $result["user_id"];
        $comment->content = $result["content"];
        $comment->createdat = $result["created_at"];

        return $comment;
    }

    public static function deleteComment($commentid){
        $result = Model::delete(self::$table, ["comment_id"=> $commentid]);
        
        $comment = new self();
        $comment->commentid = $result["comment_id"];
        $comment->fileid = $result["file_id"];
        $comment->userid = $result["user_id"];
        $comment->content = $result["content"];
        $comment->createdat = $result["created_at"];
        
        return $comment;
    }
}
?>

