<?php

require 'user.php';
require 'tweets.php';
require 'comments.php';
require  __DIR__ .'/../config.php';

$user=  User::loadUserById($conn, 1);
$user->setHashedPassword(12345);
$user->saveToDB($conn);