<?php

class Comments {
    
    private $id;
    private $userId;
    private $tweetId;
    private $CreationDate;
    private $comment;
    
    public function __construct() {

        $this->id = -1;
        $this->userId = "";
        $this->tweetId = "";
        $this->CreationDate = date("Y-m-d G:i:s");
        $this->comment = "";
        
    }
    
     public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            $sql = "INSERT INTO Comments(userId, tweetId, comment, CreationDate)
            VALUES ('$this->userId', '$this->tweetId', '$this->comment','$this->CreationDate')";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Comments SET userId = '" . $this->userId .
                    "', tweetId = '" . $this->tweetId .
                    "', comment = '" . $this->comment . "'
                    WHERE id = " . $this->id;

            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }
    
    static function loadCommentById(mysqli $connection, $id){
        $sql="SELECT * FROM Comments WHERE id=$id";
           
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedComment = new Comments();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['userId'];
            $loadedComment->tweetId = $row['tweetId'];
            $loadedComment->CreationDate = $row['CreationDate'];
            $loadedComment->comment = $row['comment'];
            return $loadedComment;
        }
        return null;
    }
    
    static function loadAllCommentsByTweetId(mysqli $connection, $tweetId){
       $sql = "SELECT Comments.userId, Comments.id, Comments.tweetId, Comments.comment, "
               . "Comments.CreationDate, Tweets.tweet, "
               . "Users.username FROM Comments JOIN Tweets ON Comments.tweetId"
               . " = Tweets.id JOIN Users On Comments.userId = Users.id WHERE "
               . "Comments.tweetId=$tweetId ORDER BY Comments.CreationDate DESC";
            $ret = [];

         $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comments();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->tweetId = $row['tweetId'];
                $loadedComment->username = $row['username'];
                $loadedComment->tweet = $row['tweet'];
                $loadedComment->CreationDate = $row['CreationDate'];
                $loadedComment->comment = $row['comment'];
                $ret[]=$loadedComment;
            }
        }
        return $ret;
    }
    
    static function loadAllCommentsByUserId(mysqli $connection, $userId){
       $sql = "SELECT Comments.userId, Comments.id, Comments.tweetId, Comments.comment, "
               . "Comments.CreationDate, Tweets.tweet, "
               . "Users.username FROM Comments JOIN Tweets ON Comments.tweetId"
               . " = Tweets.id JOIN Users On Comments.userId = Users.id WHERE "
               . "Comments.userId=$userId ORDER BY Comments.CreationDate DESC";
            $ret = [];

         $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comments();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->tweetId = $row['tweetId'];
                $loadedComment->username = $row['username'];
                $loadedComment->tweet = $row['tweet'];
                $loadedComment->CreationDate = $row['CreationDate'];
                $loadedComment->comment = $row['comment'];
                $ret[]=$loadedComment;
            }
        }
        return $ret;
    }
    
   
            
            
    function getUserId() {
        return $this->userId;
    }

    function getTweetId() {
        return $this->tweetId;
    }

    function getCreationDate() {
        return $this->CreationDate;
    }

    function getComment() {
        return $this->comment;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    function setCreationDate($CreationDate) {
        $this->CreationDate = $CreationDate;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function getId() {
        return $this->id;
    }


    
}
