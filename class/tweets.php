<?php

class Tweet {
    
    private $id;
    private $userId;
    private $tweet;
    private $CreationDate;
    private $type;
    
    public function __construct() {

        $this->id = -1;
        $this->userId = "";
        $this->tweet = "";
        $this->CreationDate = date("Y-m-d G:i:s");
        $this->type = "";
        
    }
    
    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            $sql = "INSERT INTO Tweets(userId, tweet, CreationDate, type)
            VALUES ('$this->userId', '$this->tweet', '$this->CreationDate', "
                    . "'$this->type')";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Tweets SET tweet = '" . $this->tweet .
                    "', CreationDate = '" . date("d F Y, G:i").
                    "', type = '" . $this->type. "'
                    WHERE id = " . $this->id;

            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    static public function loadTweetById(mysqli $connection, $id) {
        $sql = "SELECT Tweets.id, Tweets.userId, Tweets.tweet, Tweets.CreationDate, Users.username  FROM "
                . "Tweets JOIN Users ON Tweets.userId=Users.id WHERE Tweets.id=$id";
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->tweet = $row['tweet'];
            $loadedTweet->CreationDate = $row['CreationDate'];
            $loadedTweet->username = $row['username'];
            return $loadedTweet;
        }
        return null;
    }

    static public function loadAllTweets(mysqli $connection) {
        $sql ="SELECT Tweets.tweet, Tweets.id as twId, Tweets.userId, "
                . "Tweets.CreationDate, Tweets.type, Users.username FROM"
                . " Tweets JOIN Users ON Tweets.userId=Users.id ORDER BY Tweets.CreationDate DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['twId'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->CreationDate = $row['CreationDate'];
                $loadedTweet->type = $row['type'];
                $loadedTweet->username=$row['username'];
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }
    
     static public function loadAllPublicTweets(mysqli $connection) {
        $sql = "SELECT * FROM Tweets JOIN Users ON Tweets.userId=Users.id WHERE"
                . " Tweets.type='public' ORDER BY Tweets.CreationDate DESC LIMIT 5";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->CreationDate = $row['CreationDate'];
                $loadedTweet->type = $row['type'];
                $loadedTweet->username=$row['username'];
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }
    
    static public function loadAllTweetsByUserId($connection, $id){
        $sql = "SELECT Tweets.tweet, Tweets.id as twId, Tweets.userId, "
                . "Tweets.CreationDate, Tweets.type, Users.username FROM Tweets JOIN Users ON Tweets.userId=Users.id WHERE"
                . " Tweets.userId=$id";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['twId'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->CreationDate = $row['CreationDate'];
                $loadedTweet->type = $row['type'];
                $loadedTweet->username=$row['username'];
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }
    
    static public function loadAllCommentaedTweetsByUser($connection, $id) {
        $sql = "SELECT Comments.userId, Comments.id, Comments.tweetId, Comments.comment, 
            Comments.CreationDate,Tweets.id as twId, Tweets.tweet, Users.username FROM Comments JOIN Tweets 
            ON Comments.tweetId = Tweets.id JOIN Users On Comments.userId = Users.id WHERE 
            Users.id=$id ORDER BY Comments.CreationDate DESC";
        
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['twId'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->CreationDate = $row['CreationDate'];
                $loadedTweet->username=$row['username'];
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }
            
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getTweet() {
        return $this->tweet;
    }

    function getCreationDate() {
        return $this->CreationDate;
    }

    function getType() {
        return $this->type;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setTweet($tweet) {
        $this->tweet = $tweet;
    }

    function setType($type) {
        $this->type = $type;
    }


    
}

