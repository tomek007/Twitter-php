<div class="loginPanel">
    <div class="login-info">
        <img src="gravatar-grey.jpg">
    </div>
    <div class="login-info">
        <?php
        $loggedUser = User::loadUserByEmail($conn, $_SESSION['login']);
        echo "<p class='logout'>logged as:</p>";
        echo "<p class='loggedName'>" . $loggedUser->getUsername() . '</p>';

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