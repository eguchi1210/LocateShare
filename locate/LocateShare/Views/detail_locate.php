<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');
require_once('../zoomimg.php');

$Locate = new LocateController;
//投稿内容取得
$arr = $Locate->detail();
$params = $Locate->category_array();
$rep = $Locate->report_category();

//違反報告の重複
$report_res = $Locate->report_check($arr['id'], $_SESSION['user']['id']);

//フォロー　fav関連
$p_id = $arr['user_id'];
$u_id = $_SESSION['user']['id'];
$res = $Locate->follow_check($u_id, $p_id);
$fav_res = $Locate->favorite_check($u_id, $arr['id']);

//フォローボタン 重複チェックの戻り値でclass名判定
$button = '';
$class = '';
$else_class = '';
if(!empty($res)) {
  $button = 'フォロー中';
  $class = 'follow_btn_on';
  $else_class = 'off_btn';
} else {
  $button = 'フォロー';
  $class = 'off_btn';
  $else_class = 'follow_btn_on';
}
//お気に入りボタン
$fav_class = '';
$fav_else = '';
if(!empty($fav_res)) {
  $fav_class = 'fav_btn_on';
  $fav_else = 'off_btn';
} else {
  $fav_class = 'off_btn';
  $fav_else = 'fav_btn_on';
}
// imageがなければno imageを表示
$path = $arr['image'] ? $arr['image'] : 'img/noimage.png';

//データが存在しなければindexに返す
if(empty($arr)) {
  header('Location:/index.php');
}
if($_SESSION['user']['role'] == 1) {
  header("Location:/admin_detail_locate.php?id={$_GET['id']}");
}

?>
<h2>Location 詳細</h2>

<div class='main_column'>
  <div class='img_column'>
    <div id="map"></div>
    <?php require_once('../gmap.php'); ?>
    <img src='<?=$path ?>' class='detail_img'>
    <div id="graydisplay"></div>
  </div>
  <div class='main'>
    <table>
      <tr>
        <th>名前</th><th><?=$arr['name']; ?></th>
        <td class='btn_area'>
        <!-- user idと投稿idが不一致(別ユーザー投稿)の場合、Favoriteボタン表示 -->
        <?php if($_SESSION['user']['id'] != $arr['user_id']): ?>
          <?php require_once('../favorite.php');?>
          <form action='' method='post'>
            <input type='hidden' class='fav_p_id' value='<?=$arr['id'] ?>' name='fav_p_id'>
            <input type='hidden' class='fav_u_id' value='<?=$_SESSION['user']['id']?>' name='fav_u_id'>
            <button id='favorite_btn' class='<?=$fav_class?>'>Favorite</button>
          </form>
        <?php endif ?>
        </td>
      </tr>
      <tr>
        <th>カテゴリ</th><th colspan="2">
          <?php if($arr['category_id']): ?>
            <?=$params[$arr['category_id']]?></td>
          <?php else: ?>
            登録なし
        <?php endif ?>
      </th>
      </tr>
      <tr>
        <th>郵便番号</th><th colspan="2"><?=$arr['post_num']; ?></th>
      </tr>
      <tr>
        <th>住所</th><th id='address' colspan="2"><?=$arr['address']; ?></th>
      </tr>
      <tr>
        <th>コメント</th><th colspan="2" class='comment'><?=$arr['comment']; ?></th>
      </tr>
      <tr>
        <th>投稿者</th>
        <th>
          <a href='/user_locate.php?user_id=<?=$arr['user_id'];?>'><?=$arr['u_name']; ?>
        </th>
        <td>
          <!-- user idと投稿idが不一致(別ユーザー投稿)の場合、フォローボタン表示 -->
          <?php if($_SESSION['user']['id'] != $arr['user_id']): ?>
            <?php require_once('../follow.php'); ?>
            <form action='' method='post'>
              <input type='hidden' class='u_id' value='<?=$_SESSION['user']['id']?>' name='u_id'>
              <input type='hidden' class='p_id' value='<?=$arr['user_id'];?>' name='p_id'>
              <button id='follow_btn' class='<?=$class ?>'><?=$button;?></button>
            </form>
          <?php endif ?>
        </td>
      </tr>
      <tr>
        <th>最終更新</th><th><?=$arr['updated_at'] ?></th>
    </table>
    <?php if($arr['user_id'] == $_SESSION['user']['id']): ?>
      <a href='/edit.php?id=<?=$arr['id']?>'>編集</a>
      <a href='/delete.php?id=<?=$arr['id']?>' onclick="return confirm('削除しますか？')">削除</a>
    <?php else: ?>
      <details>
        <summary>違反報告</summary>
      <?php if(empty($report_res)): ?>
      <table class='content'>
        <form method='post' action="report.php?id=<?=$arr['id']?>" class='rep_form'>
          <tr>
            <td>違反内容を選択して下さい</td>
            <td>
              <select name='rep_category' class='rep_cate'>
                <option value='' hidden>選択してください</option>
                <?php foreach($rep as $key => $row): ?>
                <option value=<?=$key?>><?=$row?></option>
              <?php endforeach ?>
              </select>
            </td>
            <td><button>送信</button></td>
            <script>
            $('.rep_form').submit(function(){
              var val = $('.rep_cate').val();
              if(val == ''){
                window.alert('選択してください');
                return false;
              } else {
                if(confirm('送信しますか？')) {
                  return true;
                } else {
                  return false;
                }
              }
            })
            </script>
          </tr>
        </form>
      </details>
      <?php else: ?>
        <p class='content'>違反報告済み</p>
      </details>
      <?php endif ?>
    <?php endif ?>
  </div>
</div>
