<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');
require_once('../zoomimg.php');

$Locate = new LocateController;
//refererからリンク先,表示内容指定
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
$link = '';
$msg = '';
$h = '';
if(parse_url($referer, PHP_URL_PATH) == '/edit.php') {
  $link = '/complete_upd.php';
  $msg = '更新';
  $h = '更新内容確認';
} elseif($referer == null) {
  header('Location:index.php');
} else {
  $link = '/complete_add.php';
  $msg = '投稿';
  $h = '投稿内容確認';
}

$params = $Locate->category_array();
//画像登録がなければno image画像を表示
$path = $_SESSION['result']['path'] ? $_SESSION['result']['path'] : 'img/noimage.png';
//カテゴリidからカテゴリ名表示　登録なければ"登録なし"表示
$category = $_SESSION['result']['post']['category'] ? $params[$_SESSION['result']['post']['category']] : '登録なし';

?>

<h2><?=$h; ?></h2>
<div class='main_column'>
  <div class='img_column'>
    <div id="map"></div>
    <img src='<?=$path ?>' class='detail_img'>
    <div id="graydisplay"></div>
  </div>
  <div class='main'>
    <table>
      <tr>
        <th>名前</th><th><?=$_SESSION['result']['post']['name']; ?></th>
      </tr>
      <tr>
        <th>カテゴリ</th><th><?=$category ?></th>
      </tr>
      <tr>
        <th>郵便番号</th><th><?=$_SESSION['result']['post']['post_num'] ?></th>
      </tr>
      <tr>
        <th>住所</th><th id='address'><?=$_SESSION['result']['post']['address'] ?></th>
      </tr>
      <tr>
        <th class='comment'>コメント</th><th><?=$_SESSION['result']['post']['comment'] ?></th>
      </tr>
    </table>
      <a href='#' onclick="history.back();">戻る</a>
    <a href='<?=$link; ?>'><?=$msg; ?></a>
  </div>
</div>
<?php require_once('../gmap.php'); ?>
