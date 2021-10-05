<?php
require_once(ROOT_PATH .'/Controllers/AdminController.php');
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

if($_SESSION['user']['role'] != 1) {
  header('Location:index.php');
}

$Admin = new AdminController;
$res = $Admin->reporters();
//同一ユーザーへの多数報告＆詳細へのリンク？報告した投稿へ飛べるようにする？
?>
<h2>報告者一覧</h2>
  <table>
    <tr>
      <th>ユーザー名</th><th>報告件数</th><th>ユーザー投稿</th>
    </tr>
    <?php if(empty($res)):?>
      <p>該当するユーザーが存在しません</p>
    <?php else:?>
    <?php foreach($res as $row): ?>
      <tr>
        <td><?=$row['name']; ?></td>
        <td><?=$row['c']; ?></td>
        <td><a href='/user_locate.php?user_id=<?=$row['id'];?>'>詳細</a></td>
      </tr>
    <?php endforeach ?>
    <?php endif ?>
  </table>
