<?php
require_once './Models/Model.php';

class Comments {
    private $id;
    private $fileid;
    private $userid;
    private $content;
    private static $table = "COMMENTS";

    public static function getCommsById($id) {
        $result = Model::find(self::$table, ['comment_id' => $id], 1);

        $comment = new self();
        $comment->id = $result[0]["comment_id"];
        $comment->fileid = $result[0]["file_id"];
        $comment->userid = $result[0]["user_id"];
        $comment->content = $result[0]["content"];

        return $comment;
    }

    public static function getCommsByFileId($fileid) {
        $result = Model::find(self::$table, ['file_id' => $fileid], 1);

        $comment = new self();
        $comment->id = $result[0]["comment_id"];
        $comment->fileid = $result[0]["file_id"];
        $comment->userid = $result[0]["user_id"];
        $comment->content = $result[0]["content"];

        return $comment;
    }

    public static function getCommsByUserId($userid) {
        $result = Model::find(self::$table, ['user_id' => $userid], 1);

        $comment = new self();
        $comment->id = $result[0]["comment_id"];
        $comment->fileid = $result[0]["file_id"];
        $comment->userid = $result[0]["user_id"];
        $comment->content = $result[0]["content"];

        return $comment;
    }

    public static function createComment($fileid, $userid, $content){
        $result = Model::insert(self::$table, ["file_id" => $fileid, "user_id" => $userid, "content" => $content]);
        return $result;
    }

    public static function updateComment($id, $content) {
        $result = Model::update(
            array_merge(
                $content ? ["content" => $content] : []
            ),
            ["comment_id" => $id]
        );
        return $result;
    }

    public static function deleteComment($id){
        $result = Model::delete(self::$table, ["comment_id"=> $id]);
        return $result;
    }
}