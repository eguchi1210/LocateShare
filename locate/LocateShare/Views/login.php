<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
$Login = new LoginController;

$params = $Login->Signin();

if(isset($params)) {
  if($params['del_flg'] == 0) {
    session_start();
    $_SESSION['user'] = $params;
    header('Location:/index.php');
  } elseif($params['del_flg'] == 2) {
    $msg = '管理者により無効化されたアカウントです';
  }
}

if(isset($_POST['name']) and empty($params)) {
  $msg = '入力内容が誤っています';
}

//テスト用id表示
$param = $Login ->test_users();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>Locate Share</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div class='input'>
  <h2>ログイン</h2>
  <div class='form'>
    <?php if(!empty($msg)):?>
      <span><?=$msg;?></span>
    <?php endif ?>
  <form action='' method='post'>
    <p>ユーザー名</p>
    <input type='text' name='name' class='textform'></input>
    <p>パスワード</p>
    <input type='password' name='password' class='textform'><br></input>
    <input type='submit' value='ログイン' class='submit_button'>
  </form>
  <div class='login_menu'>
    <a href='signup.php'>新規登録</a>/
    <a href='reset_input.php'>パスワードを忘れた方</a>
  </div>
  </div>
</div>
<!-- テスト用-->
  <table>
    <tr>
      <th>id</th><th>name</th><th>mail</th><th>created_at</th>
    </tr>
    <?php foreach ($param as $row): ?>
      <tr>
        <th><?=$row['id'] ?></th><th><?=$row['name'] ?></th><th><?=$row['mail'] ?></th><th><?=$row['created_at'] ?></th>
      </tr>
    <?php endforeach ?>
