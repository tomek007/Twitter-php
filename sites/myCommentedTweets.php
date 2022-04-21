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
            <div class='tweets'>  
                <h2 class="info">commented tweets</h2>
                <table>
                    <?php
                    $comments = Comments::loadAllCommentsByUserId($conn, $_SESSION['id']);
                    $ret = [];
                    foreach ($comments as $value) {
                        $twee = Tweet::loadTweetById($conn, $value->getTweetId());
                        $ret[] = $value->getTweetId();
                    }
                    $commentedTweets = array_unique($ret);
                    foreach ($commentedTweets as $value) {
                        $commentedTweet = Tweet::loadTweetById($conn, $value);
                        $TweetId = $commentedTweet->getId();
                        echo '<tr>';
                        if ($commentedTweet->getUserId() != $_SESSION['id']) {
                            echo "<td class='user'>" . '<a href=userpagina.php?identify=' . $commentedTweet->getUserId() . '>' . $commentedTweet->username . '</td>';
                        } else {
                            echo "<td class='user'>" . '<a href=main.php>' . $commentedTweet->username . '</td>';
                        }
                        echo '</tr>';
                        echo '<tr>';
                        echo "<td class='tweet'>" . $commentedTweet->getTweet() . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo "<td class='date'>";
                        $old_date = $commentedTweet->getCreationDate();
                        $old_date_timestamp = strtotime($old_date);
                        echo $new_date = date('d F Y, G:i', $old_date_timestamp) . '<br>';
                        echo '</td>';
                        echo '</tr>';
                        $comment = Comments:: loadAllCommentsByTweetId($conn, $commentedTweet->getId());
                        foreach ($comment as $row1) {
                            echo '<tr><td>';
                            $old_date = $row1->getCreationDate();
                            $old_date_timestamp = strtotime($old_date);
                            $new_date = date('d.m.y G:i', $old_date_timestamp);
                            echo '<ul>';
                            echo "<li class='comment'>";
                            echo ' at ' . $new_date . ', ' . $row1->username . ' says: ' . $row1->getComment();
                            echo '</li>';
                            echo '</ul>';
                            echo '</td></tr>';
                        }
                        ?>
                        <tr><td>
                                <form class="commentForm" method="POST" action="" >
                                    <input class="commentText" type="text" class="" placeholder="comment..." name="textComment">
                                    <input class="commentButton" type="submit" value="comment" name=<?php echo $TweetId; ?>>
                                </form>
                            </td></tr>
                        <tr><td>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$TweetId])) {
        if (!empty($_POST['textComment'])) {
            $textComment = $_POST['textComment'];
            $comment = new Comments();
            $comment->setUserId($loggedUser->getId());
            $comment->setTweetId($TweetId);
            $comment->setComment($textComment);
            $comment->saveToDB($conn);
            echo '</td></tr>';
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }
}
?>
                </table>
            </div>
        </div>
    </body>
</html>
