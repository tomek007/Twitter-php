<!DOCTYPE html>
<?php
session_start();
if (!$_SESSION['auth']) {
    header("location:main.php");
    die;
}
require __DIR__ . '/../class/user.php';
require __DIR__ . '/../class/tweets.php';
require __DIR__ . '/../class/comments.php';
require __DIR__ . '/../class/messages.php';
require __DIR__ . '/../config.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <script src="java.js" type="textjavascript"></script>
        <div class="loginPanel">
            <div class="login-info">
                <img src="gravatar-grey.jpg">
            </div>
            <div class="login-info">
                <?php
                $loggedUser = User::loadUserByEmail($conn, $_SESSION['login']);
                echo "<p class='logout'>logged as:</p>";
                echo "<p class='loggedName'>" . "<a href='main_logged.php'>" . $loggedUser->getUsername() . '</a></p>';

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
                    $_SESSION['auth'] = 0;
                    header("location:main.php");
                }
                ?>
            </div>
            <div class="login-info">   
                <form method="POST" action="">
                    <input class="logoutButton" type="submit" name="logout" value="logout">
                </form>
            </div>
        </div>
        <div class="mainPanel">
            <?php
            include 'userPanel.php';
            ?>

            <div class='messages'>   
                <div class='priv'>
                    <div class="inbox">inbox</div>
                    <?php
                    $messages = message::loadMessagesReciverId($conn, $_SESSION['id']);
                    //var_dump($messages);
                    for ($i = 0; $i < count($messages); $i++) {
                    if($messages[$i]->getWasRead() == 0){
                        if ($i % 2 === 0) {

                            echo "<div class='msgName black'><div style='width: 20px; height: 2px; background-color:red;'></div><p class='sendername'>" .
                            '<a href=userpagina.php?identify=' . $messages[$i]->getSenderId() . '>' .
                            $messages[$i]->senderName . "</a></p></div>";
                            echo "<div class='msgText black'>" . $messages[$i]->getText() . "<a href=''><br><sub><b>*read more</a></b></sub></div>";
                            echo "<div class='msgDate black'><p class='datemessage'>" . $messages[$i]->getDateCreation() . "</p></div>";
                        } else {
                            echo "<div class='msgName yellow'><p class='sendername2'>" .
                            '<a href=userpagina.php?identify=' . $messages[$i]->getSenderId() . '>' .
                            $messages[$i]->senderName . "</a></p></div>";
                            echo "<div class='msgText yellow'>" . $messages[$i]->getText() . "<a href=''><br><sub><b>*read more</a></b></sub></div>";
                            echo "<div class='msgDate yellow'><p class='datemessage2'>" . $messages[$i]->getDateCreation() . "</p></div>";
                        }
                    }
 else {
     if ($i % 2 === 0) {

                            echo "<div class='msgName black'><p class='sendername'>" .
                            '<a href=userpagina.php?identify=' . $messages[$i]->getSenderId() . '>' .
                            $messages[$i]->senderName . "</a></p></div>";
                            echo "<div class='msgText black'>" . $messages[$i]->getText() . "<a href=''><br><sub><b>*read more</a></b></sub></div>";
                            echo "<div class='msgDate black'><p class='datemessage'>" . $messages[$i]->getDateCreation() . "</p></div>";
                        } else {
                            echo "<div class='msgName yellow'><p class='sendername2'>" .
                            '<a href=userpagina.php?identify=' . $messages[$i]->getSenderId() . '>' .
                            $messages[$i]->senderName . "</a></p></div>";
                            echo "<div class='msgText yellow'>" . $messages[$i]->getText() . "<a href=''><br><sub><b>*read more</a></b></sub></div>";
                            echo "<div class='msgDate yellow'><p class='datemessage2'>" . $messages[$i]->getDateCreation() . "</p></div>";
                        }
 }
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
