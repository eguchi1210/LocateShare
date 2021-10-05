<?php
$valid = [];

$mail = $_POST['mail'];
$name = $_POST['name'];
$password = $_POST['password'];
$birth = $_POST['birth'];

//アドレスバリデーション
if(empty($mail)) {
  $valid['mail'] = 'メールアドレスを入力してください';
} elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
  $valid['mail'] = 'メールアドレスの形式が正しくありません';
} elseif(!empty($d_mail)) {
  $valid['mail'] = 'このメールアドレスは使用されています';
}
//生年月日の空チェック
if(empty($birth)) {
  $valid['birth'] = '生年月日は必須です';
}

//名前の空チェック
if(empty($name)) {
  $valid['name'] = 'ユーザー名は必須項目です';
} elseif(!empty($d_name)) {
  $valid['name'] = 'このユーザー名は使用されています';
}

//パスワード
if(empty($password)) {
  $valid['password'] = 'パスワードは必須項目です';
}
$judge = array_filter($valid);
?>
