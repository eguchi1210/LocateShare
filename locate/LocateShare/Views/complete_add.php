<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if(parse_url($referer, PHP_URL_PATH) != '/confirm_locate.php') {
  header('Location:index.php');
}

$Locate = new LocateController;
$msg = $Locate->post_complete();

?>

<h2><?=$msg; ?></h2>
<a href='/index.php'>マイページに戻る</a>
