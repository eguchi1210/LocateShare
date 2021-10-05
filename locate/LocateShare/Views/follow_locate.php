<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Locate = new LocateController;
$result = $Locate->follow_list($_SESSION['user']['id']);
$params = $Locate->category_array();

?>
<h2>フォロー投稿一覧</h2>
  <table>
    <tr>
      <th>名前</th><th>都道府県</th><th>コメント</th><th>投稿者</th><th>お気に入り</th><th></th>
    </tr>
    <?php if(empty($result)):?>
      <p>該当の投稿がありません</p>
    <?php else:?>
    <?php foreach($result as $row): ?>
      <tr>
        <td><?=$row['name']; ?></td>
        <td>
          <?php preg_match("/東京都|北海道|(?:京都|大阪)府|.{6,9}県/",($row['address']), $matches);
              echo $matches[0];?></td>
        <td class='comment'><?=$row['comment']; ?></td>
        <td><a href='/user_locate.php?user_id=<?=$row['user_id']?>'><?=$row['u_name']; ?></td>
        <td><?=$Locate->favorite_number($row['id']).'件'?></td>
        <td><a href='/detail_locate.php?id=<?=$row['id'];?>'>詳細</a></td>
      </tr>
    <?php endforeach ?>
    <?php endif ?>
  </table>
