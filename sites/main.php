<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION)){
    $_SESSION['auth'] = 0;
}
if ($_SESSION['auth'] == 1) {
    header("location:main_logged.php");
    die;
}

require __DIR__ . '/../class/user.php';
require __DIR__ . '/../class/tweets.php';
require __DIR__ . '/../class/comments.php';
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
            <div class="login-form">
                <form method="POST" action="">
                    <input class="logininput,  top" type="email" placeholder="email" name="logEmail">
                    <input class="logininput" type="password" placeholder="Password" name="logPassword">
                    <input type="submit" class="loginbutton" name="loginbutton" value="sign in"></button>
                </form>
                <?php
                //--------------------------------------logowanie-----------------------------------------------------

                if (isset($_POST['logEmail']) && isset($_POST['logPassword']) && isset($_POST['loginbutton'])) {
                    if (!empty($_POST['logEmail']) && !empty($_POST['logPassword'])) {

                        
                        $login = ($_POST['logEmail']);
                        $sql = "SELECT id, email FROM Users WHERE email='$login'";
                        $result = $conn->query($sql);
                        if ($result->num_rows == 0) {
                            echo "<p class='errorInfo'>there is no User $login</p>";
                        } else {
                            $row = $result->fetch_assoc();
                            $id = $row['id'];
                            $us = User::loadUserById($conn, $id);
                            if (password_verify($_POST['logPassword'], $us->getHashedPassword())) {
                                $valid = 1;
                            } else {
                                $valid = 0;
                                echo "<p class='errorInfo'>Invalid password</p>";
                            }

                            if ($valid == 1) {
                                $_SESSION['login'] = $login;
                                $_SESSION['id'] = $id;
                                $_SESSION['auth'] = 1;
                                echo '<meta http-equiv="refresh" content="1; URL=main_logged.php">';
                                //echo '<p style="padding-top:10px;"><strong>Proszę czekać...</strong><br>trwa logowanie i wczytywanie danych<p></p>';
                            }
                        }
                    }
                }


                //--------------------------------------logowanie-----------------------------------------------------
                ?>
            </div>
        </div>
        <div class="mainPanel">
            <div class="registerPanel">
                <form class="register-form" action="" method="POST">
                    <p class="register-info">New on Twitter? Sign up<p>
                        <input class="logininput" type="text" pattern=".{5,16}" placeholder="name 5-16 char." name="username"/>
                        <input class="logininput" type="password" pattern=".{5,16}" placeholder="password 5-16 char." name="userpassword"/>
                        <input class="logininput" type="email" placeholder="email address" name="emailaddress"/>
                        <button class="registerbutton" name="signup">Sign up</button>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] = 'POST') {
                    if (isset($_POST['signup']) && !empty($_POST['username']) && !empty($_POST['userpassword']) && !empty($_POST['emailaddress'])) {
                        $name = $_POST['username'];
                        $password = $_POST['userpassword'];
                        $email = $_POST['emailaddress'];
                        $loaduser = User::loadAllUsers($conn);
                        $users = [];
                        foreach ($loaduser as $row) {
                            $users[] = $row->getUsername();
                            $users[] = $row->getEmail();
                        }
                        $addUser = [];
                        $addUser['password'] = $password;
                        if (in_array($name, $users)) {
                            echo "<p class='errorInfo'>the name is alredy taken</p>";
                        } else {
                            $addUser['name'] = $name;
                        }
                        if (in_array($email, $users)) {
                            echo "<p class='errorInfo'>the email address is alredy taken</p>";
                        } else {
                            $addUser['email'] = $email;
                        }
                        if (count($addUser) == 3) {
                            $newUser = new User();
                            $newUser->setEmail($email);
                            $newUser->setUsername($name);
                            $newUser->setHashedPassword($password);
                            $newUser->saveToDB($conn);
                            echo "<p class='register-info'> Welcome on Twitter. Now U can Sign in</p>";
                        }
                    }
                }
                ?>
            </div>
            <div class='tweets'>
                <h2 class="info">RECENT PUBLIC TWEETS</h2>
                <h6 class="info">more tweet only for logged users</h6>
                <table>
                    <?php
                    $PublicTweets = Tweet::loadAllPublicTweets($conn);
                    foreach ($PublicTweets as $row) {
                        echo '<tr>';
                        echo "<td class='user'>" . $row->username . '</td>';
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
                            echo '</tr></td>';
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
