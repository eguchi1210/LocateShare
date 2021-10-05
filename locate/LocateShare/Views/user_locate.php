<?php
require_once(ROOT_PATH .'/Controllers/AdminController.php');
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Admin = new AdminController;
$Locate = new LocateController;

$result = $Locate->user_locate();
$params = $Locate->category_array();
$name = $Locate->user_name();

//機能切り分け
$th = '';
if($_SESSION['user']['role'] == 1) {
  $th = '違反報告';
} else {
  $th = 'お気に入り';
}
?>
<?php if($_SESSION['user']['role'] == 1): ?>
  <details>
    <summary>アカウント無効化</summary>
    <a href='delete_account.php?id=<?=$result[0]['user_id']?>'>削除</a>
  </details>
<?php endif ?>
<h2><?=$name['name']?>さんの投稿一覧</h2>
  <table>
    <tr>
      <th>名前</th><th>カテゴリ</th><th>コメント</th><th><?=$th?></th><th></th>
    </tr>
    <?php foreach($result as $row): ?>
      <tr>
        <td><?=$row['name']; ?></td>
        <?php if($row['category_id']): ?>
          <td>カテゴリ: <?=$params[$row['category_id']]?></td>
        <?php else: ?>
          <td>カテゴリ: 登録なし</td>
        <?php endif ?>
        <td class='comment'><?=$row['comment']; ?></td>
        <?php if($_SESSION['user']['role'] == 1): ?>
        <td><?=$Admin->count_by_post($row['id'])['c'].'件'?></td>
      <?php else: ?>
        <td><?=$Locate->favorite_number($row['id']).'件' ?></td>
        <?php endif ?>
        <td><a href='/detail_locate.php?id=<?=$row['id'];?>'>詳細</a></td>
      </tr>
    <?php endforeach ?>
  </table>
