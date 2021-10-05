<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

if(!isset($_SESSION['user'])) {
  header('Location:/login.php');
  //管理者ロールに該当した場合、管理者ページに遷移
} elseif($_SESSION['user']['role'] == 1) {
  header('Location:/index_admin.php');
}

$Locate = new LocateController;
$params = $Locate->category_array();
$arr = $Locate->index();
$res = $Locate->index_posts($_SESSION['user']['id']);

?>
<div class='serch'>
  <h2>投稿検索</h2>

  <form action='find_locate.php' method='get'>
    <table>
      <tr>
        <th>名前</th><th>カテゴリ</th><th colspan="2">住所</th>
      </tr>
      <tr>
        <th><input type='text' name='name'></input></th>
        <th><select name='category'>
          <option value=''></option>
          <?php foreach ($params as $key => $value): ?>
            <option value='<?=$key; ?>'><?=$value; ?></option>
          <?php endforeach ?>
        </select>
        </th>
        <th><input type='text' name='address' colspan='2' size=35></input></th>
        <input type='hidden' name='page' value='0'></input>
        <td><input type='submit' value='検索'></td>
      </tr>
    </table>
  </form>
</div>

<h2>新着投稿</h2>
<?php if(!empty($res)): ?>
  <a href='follow_locate.php' class='viewmore'>View More>>></a>
<?php else: ?>
  <p>該当する投稿がありません</p>
<?php endif ?>
<div class='arrival'>
  <?php foreach($res as $key =>$value): ?>
    <div class='arrival_box'>
      <a href='detail_locate.php?id=<?=$value['id']?>' class='arrival_img'>
        <img src='<?=$value['image'] ?>' style='width:100%'>
      </a>
      <p>名前: <?=$value['name']?></p>
      <?php if($value['category_id']): ?>
        <p>カテゴリ: <?=$params[$value['category_id']]?></p>
      <?php else: ?>
        <p>カテゴリ: 登録なし</p>
      <?php endif ?>
      <p>投稿者:
        <a href='/user_locate.php?user_id=<?=$value['user_id'];?>'>
          <?=$value['u_name']?>
        </a>
      </p>
      <p><?='お気に入り: '.$Locate->favorite_number($value['id']).'件';?></p>
    </div>
  <?php endforeach ?>
</div>
<h2>過去投稿一覧</h2>
  <table>
    <tr>
      <th>名前</th><th>都道府県</th><th>コメント</th><th>お気に入り</th><th></th>
    </tr>
  <?php if(!empty($arr)): ?>
    <?php foreach($arr as $row): ?>
      <tr>
        <td><?=$row['name']; ?></td>
        <td>
          <?php preg_match("/東京都|北海道|(?:京都|大阪)府|.{6,9}県/",($row['address']), $matches);
              echo $matches[0];?></td>
        <td class='comment'><?=$row['comment']; ?></td>
        <td><?=$Locate->favorite_number($row['id']).'件'?></td>
        <td><a href='/detail_locate.php?id=<?=$row['id'];?>'>詳細</a></td>
      </tr>
    <?php endforeach ?>
  <?php else: ?>
  </table>
    <p>該当する項目がありません</p>
  <?php endif ?>
