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
                echo "<p class='loggedName'>"."<a href='main_logged.php'>" .$loggedUser->getUsername().'</a></p>' ;

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
            <div class='newPass'>
                <form action="" method="POST">
                    <ul>
                        <li class="newPassLi">if new Name will be set up page logut</li>
                        <li class="newPassLi"><input type="text" name="newPassword" pattern=".{5,16}" placeholder="new name 5-16 char. "></li>
                        <li class="newPassLi"><input type="text" name="confirm" pattern=".{5,16}" placeholder="confirm name"></li>
                        <li class="newPassLi"><input type="submit" value="send" name="send"></li>
                    </ul>
                </form>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['send']) && !empty($_POST['newPassword']) && !empty($_POST['confirm'])){
                $newPassword =$_POST['newPassword'];
                $Confirmation=$_POST['confirm'];
                if ($newPassword == $Confirmation){
                    $user = User::loadUserById($conn, $_SESSION['id']);
                    $user->setUsername($newPassword);
                    var_dump($user);
                    $user->saveToDB($conn);
                 $_SESSION['auth'] = 0;
                    header("location:main.php");
                }
                else {
                    echo "<p class='errorInfo'>confirmation invalid</p>";
                }
            }
            ?>
        </div>
    </body>
</html>
