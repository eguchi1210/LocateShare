<?php
require_once(ROOT_PATH .'/Controllers/AdminController.php');
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

if($_SESSION['user']['role'] != 1) {
  header('Location:index.php');
}

$Admin = new AdminController;
$res = $Admin->report_arr();
//件数
$rep_count = $res['count'];
//カテゴリごとの報告件数:array
$rep_category_count = $res['category'];

$Locate = new LocateController;
//投稿内容取得
$arr = $Locate->detail();
$params = $Locate->category_array();
$rep = $Locate->report_category();

// imageがなければno imageを表示
$path = $arr['image'] ? $arr['image'] : 'img/noimage.png';

//データが存在しなければ(idが不正)indexに返す
if(empty($arr)) {
  header('Location:/index.php');
}

?>
<h2>違反報告内容 詳細</h2>
 <table>
   <tr>
     <td colspan="2">総数</td><td><?=$rep_count?></td>
   </tr>
  <?php foreach($rep_category_count as $row): ?>
   <tr>
     <td>内訳</td><td><?=$rep[$row['rep_category']];?></td><td><?=$row['c']; ?></td>
   </tr>
   <?php endforeach?>
 </table>

<h2>Location 詳細</h2>

<div class='main_column'>
  <div class='img_column'>
    <div id="map"></div>
    <?php require_once('../gmap.php'); ?>
    <img src='<?=$path ?>'>
  </div>
  <div class='main'>
    <table>
      <tr>
        <th>名前</th><th><?=$arr['name']; ?></th>
      </tr>
      <tr>
        <th>カテゴリ</th><th><?=$params[$arr['category_id']]; ?></th>
      </tr>
      <tr>
        <th>郵便番号</th><th><?=$arr['post_num']; ?></th>
      </tr>
      <tr>
        <th>住所</th><th id='address'><?=$arr['address']; ?></th>
      </tr>
      <tr>
        <th class='comment'>コメント</th><th><?=$arr['comment']; ?></th>
      </tr>
      <tr>
        <th>投稿者</th>
        <th>
          <a href='/user_locate.php?user_id=<?=$arr['user_id'];?>'><?=$arr['u_name']; ?>
        </th>
      </tr>
      <tr>
        <th>最終更新</th><th><?=$arr['updated_at'] ?></th>
    </table>
     <a href='/delete.php?id=<?=$arr['id']?>' onclick="return confirm('削除しますか？')">投稿削除</a>
  </div>
</div>
