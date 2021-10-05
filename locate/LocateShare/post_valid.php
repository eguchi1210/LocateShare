<?php
$valid = [];

$name = $_POST['name'];
$post_num = $_POST['post_num'];
$address = $_POST['address'];
$comment = $_POST['comment'];
$image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$image_size = $_FILES['image']['size'];
$size_limit = 1024 * 1024 * 2.5;

if(empty($name)) {
  $valid['name'] = '名前は必須項目です';
} elseif(mb_strlen($name) > 30) {
  $valid['name'] = '名前は30字以内で入力してください';
}

if(!empty($post_num)){
  if(!preg_match("/^(([0-9]{3}-[0-9]{4})|([0-9]{7}))$/", $post_num)) {
    $valid['post_num'] = '正しい形式で入力してください';
  }
}

if(empty($address)) {
  $valid['address'] = '住所は必須項目です';
} elseif(!preg_match("/(.*?[都道府県])(.*?[市区町村])/u", $address)) {
  $valid['address'] = '正しい形式で入力してください';
}

if(mb_strlen($comment) > 200) {
  $valid['comment'] = 'コメントは300字で入力してください';
}

if($image_size > 0) {
  if($image_ext != 'jpg' and $image_ext != 'png' and $image_ext != 'gif') {
    $valid['image'] = 'アップロードは画像ファイルのみです';
  } elseif($image_size > $size_limit) {
    $valid['image'] = 'アップロードサイズは2.5MB以下です';
  }
}
?>
