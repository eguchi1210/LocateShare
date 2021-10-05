<?php
require_once(ROOT_PATH .'/Controllers/AdminController.php');
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

if($_SESSION['user']['role'] != 1) {
  header('Location:index.php');
}

$Admin = new AdminController;
$arr = $Admin->rep_count_locate();
$Locate = new LocateController;
$params = $Locate->category_array();

?>

<h2>報告投稿一覧</h2>
  <table>
    <tr>
      <th>名前</th><th>カテゴリ</th><th>コメント</th><th>報告件数</th><th></th>
    </tr>
  <?php if(!empty($arr)): ?>
    <?php foreach($arr as $row): ?>
      <tr>
        <td><?=$row['name']; ?></td>
        <?php if($row['category_id']): ?>
          <td>カテゴリ: <?=$params[$row['category_id']]?></td>
        <?php else: ?>
          <td>カテゴリ: 登録なし</td>
        <?php endif ?>
        <td class='comment'><?=$row['comment']; ?></td>
        <td><?=$row['c']?>件</td>
        <td><a href='/admin_detail_locate.php?id=<?=$row['id'];?>'>詳細</a></td>
      </tr>
    <?php endforeach ?>
  <?php else: ?>
  </table>
    <p>該当する項目がありません</p>
  <?php endif ?>
