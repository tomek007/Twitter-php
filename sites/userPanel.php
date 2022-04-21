


<div class="UserPanel">
    <h3 class="userPanelinfo">profile</h3>
    <ul class="userPanellist">
        <li class="userLi"><a href="myTweets.php">my tweets</a>
        </li>
        <li class="userLi"><a href="myCommentedTweets.php">commented tweets </a></li>
        <li class="userLi">
<?php 
$amountNew = message::countNewMessages($conn, $_SESSION['id']); 
$amountAll = message::countInboxMessages($conn, $_SESSION['id']);
if ($amountNew != 0){
    echo "<a href='inbox.php'>messages inbox (<strong>$amountNew</strong>/$amountAll)</a>";
}
else {
   echo "<a href='inbox.php'>messages inbox ($amountNew/$amountAll)</a>";
}
?>
                </li>
        <li class="userLi"><a href="outbox.php">messages outbox</a></li>
    </ul>
    <h3 class="userPanelinfo">settings</h3>
    <ul class="userPanellist">
        <li class="userLi"><a href="newPassword.php">set new password</a></li>
        <li class="userLi"><a href="newName.php">set new name</a></li>
        <li class="userLi"><a href="newEmail.php">set new email</a></li>
        <li class="userLi"><a href="delete.php">delete account</a></li>
    </ul>
</div>