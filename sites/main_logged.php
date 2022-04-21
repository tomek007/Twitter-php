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
        <?php
        include 'loginPanel.php';
        ?>
        <div class="mainPanel">
            <?php
            include 'userPanel.php';
            ?>
            <div class='tweets'>
                <h2 class="info">write something</h2> 
                <form class="tweetForm" method="POST" action="">
                    <input class="tweetForm" pattern=".{1,60}" name="tweet" placeholder="tweet...">
                    <br>
                    <input class="tweetType" type="radio" value="public" name="tweetType" checked="checked"> public
                    <input class="tweetType" type="radio" value="private" name="tweetType"> private 
                    <input class="tweetSend" type="submit" name="publicate" value="send">
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publicate'])) {
                    if (!empty($_POST['tweet'])) {
                        $textTweet = $_POST['tweet'];
                        $newTweet = new Tweet();
                        $newTweet->setUserId($loggedUser->getId());
                        $newTweet->setTweet($textTweet);
                        $newTweet->setType($_POST['tweetType']);
                        $newTweet->saveToDB($conn);
                        echo '</td></tr>';
                        "<meta http-equiv='refresh' content='0'>";
                    }
                }
                ?>
                <table>
                    <?php
                    $Tweets = Tweet::loadAllTweets($conn);
                    foreach ($Tweets as $row) {
                        $TweetId = $row->getId();
                        echo '<tr>';
                        if($row->getUserId()!=$_SESSION['id']){
                        echo "<td class='user'>" . '<a href=userpagina.php?identify=' . $row->getUserId() . '>' . $row->username . '</a></td>';
                        }
                        else {
                             echo "<td class='user'>" . '<a href=main.php>' . $row->username . '</a></td>';
                        }
                        echo '</tr>';
                        echo '<tr>';
                        echo "<td class='tweet'>" . $row->getTweet() . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo "<td class='date'>";
                        $old_date = $row->getCreationDate();
                        $old_date_timestamp = strtotime($old_date);
                        echo $new_date = date('d F Y, G:i', $old_date_timestamp) . '<br>';
                        echo '</td>';
                        echo '</tr>';
                        $comment = Comments:: loadAllCommentsByTweetId($conn, $row->getId());
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
