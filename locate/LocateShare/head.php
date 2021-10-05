<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>Locate Share</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyDaHql2rBljc157mV2Xdf-W8cc60fbcgeg">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    </head>
<body>
  <?php if($_SESSION['user']['role'] == 1):?>
  <header>
    <div class='logo'>
      <a href='/index_admin.php' class='index'>Locate Share</a>
    </div>
    <div class='menus'>
      <div class='links'><a href='index_admin.php'>Violation<a></div>
      <div class='links'><a href='reported_user.php'>Reported</a></div>
      <div class='links'><a href='reporter.php'>Reporters</a></div>
    </div>
    <div class='logout'><a href='logout.php'>ログアウト</a></div>
  </header>
<?php else:?>
<header>
  <div class='logo'>
    <a href='/index.php' class='index'>Locate Share</a>
  </div>
  <div class='menus'>
    <div class='links'><a href='index.php'>My Page<a></div>
    <div class='links'><a href='add_locate.php'>Add Location</a></div>
    <div class='links'><a href='favorite.php'>Favorite</a></div>
    <div class='links'><a href='follow_locate.php'>Follows</a></div>
  </div>
  <div class='logout'><a href='logout.php'>ログアウト</a></div>
</header>
<?php endif ?>
