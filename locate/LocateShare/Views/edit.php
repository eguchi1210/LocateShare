<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Locate = new LocateController;
$arr = $Locate->detail();
$res = $Locate->category_array();
$params = $Locate->location_post();
// imageがなければno imageを表示
$img_path = $arr['image'] ? $arr['image'] : 'img/noimage.png';
//データが存在しなければindexに返す
if(empty($arr)) {
  header('Location:/index.php');
}
if(isset($_POST['submit'])) {
  $valid = $params['valid'];
  if(!empty($_FILES['image']['name'])) {
    $img_path = $Locate->img_disp();
  }
  if(empty($valid)) {
    $_SESSION['result'] = [
      'post' => $params['post'],
      'path' => $img_path,
      'id' => $_GET['id']
    ];
    header('Location:/confirm_locate.php');
  }
}
?>

<h2>Location 詳細</h2>

<div class='main_column'>
  <div class='img_column'>
    <img src='<?=$img_path; ?>' class='detail_img'>
  </div>
  <div class='main'>
    <form action='' method='post' enctype="multipart/form-data">
      <table>
        <tr>
          <th><label for='name'>名前</label></th>
          <th><input type='text' name='name' value='<?=$arr['name']?>'></th>
        <tr>
          <th><label for='category'>カテゴリ</label></th>
            <th><select name='category'>
              <option value=''></option>
              <?php foreach ($res as $key =>$row): ?>
                <?php $selected = $arr['category_id'] == $key ? 'selected' : ''; ?>
                  <option value='<?=$key;?>' <?=$selected; ?>><?=$row;?></option>
                <?php endforeach ?>
            　</select>
          </th>
        </tr>
        <tr>
          <th><label for='post_num'>郵便番号</label></th>
          <th><input type='text' name='post_num' onkeyup="AjaxZip3.zip2addr(this,'','address','address');" value='<?=$arr['post_num']?>'></th>
        </tr>
        <tr>
          <th><label for='address'>住所</label></th>
          <th><input type='text' name='address' size='30' value='<?=$arr['address']?>'></th>
        </tr>
        <tr>
          <th><label for='comment'>コメント</label></th>
          <th><textarea name='comment'><?=$arr['comment']?></textarea></th>
        </tr>
        <tr>
          <th><label for='image'>画像
            <p style='font-size: 9px;'>(変更する場合)<p></label></th>
          <th><input type='file' name='image' accept='image/*'></th>
        </tr>
      </table>
      <input type='submit' name='submit' value='投稿' class='submit_button'><br>
      <a href='detail_locate.php?id=<?=$arr['id']?>'>戻る</a>
    </form>
  </div>
</div>
