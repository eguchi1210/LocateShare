<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Locate = new LocateController;
$params = $Locate->location_post();
$category = $Locate->category_array();

if(isset($_POST['submit'])) {
  $path = $Locate->img_disp();
  $valid = $params['valid'];
  if(empty($valid)) {
    $_SESSION['result'] = [
      'post' => $params['post'],
      'path' => $path
    ];
    header('Location:/confirm_locate.php');
  }
}
?>

<h2>新規投稿</h2>
<div class='add_form'>
  <form action='' method='post' enctype="multipart/form-data">
    <table>
      <tr>
        <th><label for='name'>名前</label></th>
        <th>
          <?php if(isset($valid['name'])):?>
            <span class='in_th'><?=$valid['name'] ?><br></span>
          <?php endif ?>
          <input type='text' name='name' class='text_input'></th>
      <tr>
        <th><label for='category'>カテゴリ</label></th>
          <th><select name='category'>
            <option value=''></option>
            <?php foreach ($category as $key =>$row): ?>
              <option value='<?=$key;?>'><?=$row;?></option>
            <?php endforeach ?>
          </select></th>
      </tr>
      <tr>
        <th><label for='post_num'>郵便番号</label></th>
        <th>
          <?php if(isset($valid['post_num'])):?>
            <span><?=$valid['post_num'] ?><br></span>
          <?php endif ?>
        <input type='text' name='post_num' onkeyup="AjaxZip3.zip2addr(this,'','address','address');"></th>
      </tr>
      <tr>
        <th><label for='address'>住所</label></th>
        <th>
          <?php if(isset($valid['address'])): ?>
            <span><?=$valid['address'] ?><br></span>
          <?php endif ?>
        <input type='text' name='address' size='30' class='text_input'></th>
      </tr>
      <tr>
        <th><label for='comment'>コメント</label><br><p class='notice'>(200字以内)</th>
        <th>
          <?php if(isset($valid['commnt'])):?>
            <span><?=$valid['comment'] ?><br></span>
          <?php endif ?>
        <textarea name='comment' class='text_input'></textarea></th>
      </tr>
      <tr>
        <th><label for='image'>画像</label></th>
        <th>
          <?php if(isset($valid['image'])):?>
            <span><?=$valid['image']?><br></span>
          <?php endif ?>
        <input type='file' name='image' accept='image/*'></th>
      </tr>
    </table>
    <input type='submit' name='submit' value='投稿' class='submit_button'>
  </form>
</div>
