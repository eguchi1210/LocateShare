<?php
session_start();
$_SESSION = [];
session_unset();
header('Location:login.php') ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Locate Share</title>
    <link rel="styleseet" type="text/css" href="/css/style.css">
  </head>

  <body>
    <h2>ログアウトしました</h2>
