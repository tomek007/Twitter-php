<?php

/**
 * Description of messages
 *
 * @author radmal
 */
class message {

    private $id;
    private $text;
    private $senderId;
    private $reciverId;
    private $wasRead;
    private $deletedBySender;
    private $deletedByReciver;
    private $dateCreation;

    public function __construct() {

        $this->id = -1;
        $this->text = "";
        $this->senderId = "";
        $this->reciverId = "";
        $this->wasRead = "";
        $this->deletedByReciver = "";
        $this->deletedBySender = "";
        $this->dateCreation = date("Y-m-d G:i:s");
    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            $sql = "INSERT INTO Messages(text, senderId, reciverId, dateCreation)
            VALUES ('$this->text', '$this->senderId', '$this->reciverId','$this->dateCreation')";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;
                return true;
            }

            return false;
        }
    }
    
    static function loadMessagesReciverId(mysqli $connection, $reciverId){
       $sql = "SELECT LEFT(Messages.text,30), Messages.dateCreation,Messages.wasRead, "
               . "Users.username, sender.username as senderName, Messages.senderId FROM "
               . "Messages JOIN Users ON Messages.reciverId = Users.id JOIN Users "
               . "sender ON Messages.senderId = sender.id WHERE Messages.reciverId ="
               . " $reciverId ORDER BY Messages.dateCreation DESC";
            $ret = [];

         $result = $connection->query($sql);

        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new message();
                $loadedMessage->text = $row['LEFT(Messages.text,30)'] . "...";
                $loadedMessage->senderName = $row['senderName'];
                $loadedMessage->dateCreation = $row['dateCreation'];
                $loadedMessage->senderId = $row['senderId'];
                $loadedMessage->wasRead = $row['wasRead'];
                $ret[]=$loadedMessage;
            }
        }
        return $ret;
    }
    
    static function loadMessagesSenderId(mysqli $connection, $senderId){
       $sql = "SELECT LEFT(Messages.text,30), Messages.dateCreation, Messages.reciverId, Messages.wasRead,"
               . "Users.username, reciver.username as reciverName FROM "
               . "Messages JOIN Users ON Messages.reciverId = Users.id JOIN Users "
               . "reciver ON Messages.reciverId = reciver.id WHERE Messages.senderId ="
               . " $senderId ORDER BY Messages.dateCreation DESC";
            $ret = [];

         $result = $connection->query($sql);

        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new message();
                $loadedMessage->text = $row['LEFT(Messages.text,30)'] . "...";
                $loadedMessage->reciverName = $row['reciverName'];
                $loadedMessage->dateCreation = $row['dateCreation'];
                $loadedMessage->reciverId = $row['reciverId'];
                $loadedMessage->wasRead = $row['wasRead'];
                $ret[]=$loadedMessage;
            }
        }
        return $ret;
    }
    
    static function countNewMessages(mysqli $connection, $reciverId){
       $sql = "SELECT * FROM Messages WHERE wasRead = 0 AND reciverId = $reciverId ";

         $result = $connection->query($sql);
         return  $result->num_rows;
    }
    
    static function countInboxMessages(mysqli $connection, $reciverId){
       $sql = "SELECT * FROM Messages WHERE reciverId = $reciverId";

         $result = $connection->query($sql);
         return  $result->num_rows;
    }

    function getId() {
        return $this->id;
    }

    function getText() {
        return $this->text;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReciverId() {
        return $this->reciverId;
    }

    function getWasRead() {
        return $this->wasRead;
    }

    function getDeletedBySender() {
        return $this->deletedBySender;
    }

    function getDeletedByReciver() {
        return $this->deletedByReciver;
    }

  
    

    function setText($text) {
        $this->text = $text;
    }

    function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function setReciverId($reciverId) {
        $this->reciverId = $reciverId;
    }

    function setWasRead($wasRead) {
        $this->wasRead = $wasRead;
    }

    function setDeletedBySender($deletedBySender) {
        $this->deletedBySender = $deletedBySender;
    }

    function setDeletedByReciver($deletedByReciver) {
        $this->deletedByReciver = $deletedByReciver;
    }


    function getDateCreation() {
        return $this->dateCreation;
    }

    function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }



}
