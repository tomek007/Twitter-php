<?php

if (isset($_POST['logEmail']) && isset($_POST['logPassword']) && isset($_POST['loginbutton'])) {
    if (!empty($_POST['logEmail']) && !empty($_POST['logPassword'])) {


        $login = ($_POST['logEmail']);
        $sql = "SELECT id, email FROM Users WHERE email='$login'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            echo "<span class='alert alert-danger'>there is no User $login</span>";
        } else {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $us = User::loadUserById($conn, $id);
            if (password_verify($_POST['logPassword'], $us->getHashedPassword())) {
                $valid = 1;
            } else {
                $valid = 0;
                echo "<span class='alert alert-danger'>Invalid password</span>";
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

?>