<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Locate = new LocateController;
$params = $Locate->category_array();
$arr = $_GET ? $_GET : '';
$result = $Locate ->serch($arr);
$res = $result['result'];
$msg = empty($res) ? '該当する投稿がありません' : '';
$url_arr = explode('&page=', $_SERVER['REQUEST_URI']);
$url = $url_arr[0];
?>

<h2>投稿検索</h2>

<form action='find_locate.php' method='get'>
  <table>
    <tr>
      <th>名前</th><th>カテゴリ</th><th colspan="2">住所</th>
    </tr>
    <tr>
      <th><input type='text' name='name' value='<?=$_GET['name'];?>'></input></th>
      <th><select name='category'>
        <option value=''></option>
        <?php foreach ($params as $key => $value): ?>
          <option value='<?=$key; ?>'><?=$value; ?></option>
        <?php endforeach ?>
      </select>
      </th>
      <th>
        <input type='text' name='address' colspan='2' size=35 value='<?=$_GET['address'];?>'></input>
      </th>
      <input type='hidden' name='page' value='0'></input>
      <th><input type='submit' value='検索'></th>
    </tr>
  </table>
</form>
<h2>過去投稿一覧</h2>
  <?php if (empty($msg)): ?>
    <table>
      <tr>
        <th>名前</th><th>都道府県</th><th>コメント</th><th>投稿者</td><th>お気に入り</th><th></th>
      </tr>
      <?php foreach($res as $row): ?>
        <tr>
          <td><?=$row['name']; ?></td>
          <td>
            <?php preg_match("/東京都|北海道|(?:京都|大阪)府|.{6,9}県/",($row['address']), $matches);
                  echo $matches[0];?></td>
          <td class='comment'><?=$row['comment']; ?></td>
          <td><a href='/user_locate.php?user_id=<?=$row['u_id'];?>'>
            <?=$row['u_name']; ?></a>
          </td>
          <td><?=$Locate->favorite_number($row['id']).'件'?></td>
          <td><a href='/detail_locate.php?id=<?=$row['id'];?>'>詳細</a></td>
        </tr>
      <?php endforeach ?>
    </table>
  <?php else: ?>
    <p><?=$msg; ?></p>
  <?php endif; ?>

  <div class = 'paginator'>
    <?php
    for($i = 0; $i <= $result['count']; $i++) {
      if(isset($_GET['page']) and $_GET['page'] == $i) {
        echo $i+1;
      } else {
        echo "<a href='{$url}&page=".$i."'>".($i+1)."</a>";
      }
    } ?>
  </div>
