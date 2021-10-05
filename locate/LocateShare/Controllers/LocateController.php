<?php
require_once(ROOT_PATH .'/Models/Locate.php');

class LocateController {
  private $Locate;

  public function __construct() {
    $this ->request['get'] = $_GET;
    $this ->request['post'] = $_POST;

    $this ->Locate = new Locate();
    $dbh = $this ->Locate->get_db_handler();
  }
//my page 表示用　過去投稿
  public function index() {
    $arr = [];
    $id = $_SESSION['user']['id'] ? $_SESSION['user']['id'] : '';
    if(isset($id)){
      $arr = $this->Locate->posted_locate($id);
    }
    return $arr;
  }
//index用　新着投稿
  public function index_posts($id) {
    $result = $this->Locate->follow_posts($id);
    $res = array_slice($result, 0, 3);
    foreach($res as $key => $row) {
      $res[$key]['image'] = $row['image'] ? $row['image'] : 'img/noimage.png';
    }
    return $res;
  }
//検索
  public function serch($arr) {
    $res = '';
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    if(isset($arr)) {
      $f_name = $arr['name'] ? '%'.$arr['name'].'%' : '%';
      $f_category = $arr['category'] ? $arr['category'] : 'category_id';
      $f_address = $arr['address'] ? '%'.$arr['address'].'%' : '%';
      $res = $this ->Locate ->find_locate($f_name, $f_category, $f_address, $page);
      $count = $this->Locate->find_count($f_name, $f_category, $f_address);
      $result = [
        'result' => $res,
        'count' => $count / 10
      ];
      return $result;
    }
  }
//詳細画面
  public function detail() {
    $id = $_GET['id'] ? $_GET['id'] : '';
    if(isset($id)) {
      $arr = $this->Locate->detail_locate($id);
      return $arr;
    }
  }
//投稿時
  public function location_post() {
    $result = [];
    if(isset($_POST['submit'])) {
      require_once('../post_valid.php');
        $result['post'] = $_POST;
        $result['file'] = $_FILES;
        $result['valid'] = $valid;
      }
    return $result;
  }
//カテゴリのid,名称を配列で取得
  public function category_array() {
    $result = [];
    $arr = [];
    $result = $this->Locate->categories();
    foreach ($result as $row) {
      $arr[$row['id']] = $row['name'];
    }
    return $arr;
  }
  //確認画面　画像表示
  public function img_disp() {
    $arr = [];
    $name =  isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    $tmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
    if(isset($name) and isset($tmp)) {
      $arr = [
        'name' => $name,
        'tmp' => $tmp
      ];
      $dir = $this->Locate->img_upload($arr);
      return $dir;
    }
  }
  //投稿
  public function post_complete() {
    $arr = [];
    if(isset($_SESSION)) {
      $user_info = $_SESSION['user'];
      $post_info = $_SESSION['result']['post'];
      $post_info['category'] = $post_info['category'] ? $post_info['category'] : '';
      $path = $_SESSION['result']['path'];
      $arr = [
        'name' => $post_info['name'],
        'category_id' => $post_info['category'],
        'user_id' => $user_info['id'],
        'post_num' => $post_info['post_num'],
        'image' => $path,
        'address' => $post_info['address'],
        'comment' => $post_info['comment']
      ];
      $res = $this->Locate->add_locate($arr);
      $_SESSION['result'] = '';
    }
    return $res;
  }
  //更新
  public function upd_complete() {
    $arr = [];
    if(isset($_SESSION)) {
      $post_id = $_SESSION['result']['id'];
      $post_info = $_SESSION['result']['post'];
      $path = $_SESSION['result']['path'];
      $arr = [
        'id' => $post_id,
        'name' => $post_info['name'],
        'category_id' => $post_info['category'],
        'post_num' => $post_info['post_num'],
        'image' => $path,
        'address' => $post_info['address'],
        'comment' => $post_info['comment']
      ];
      $res = $this->Locate->upd_locate($arr);
      $_SESSION['result'] = '';
    }
    return $res;
  }
  //削除(論理削除)
  public function del_complete() {
    $id = $_GET['id'] ? $_GET['id'] : '';
    $msg = $this->Locate->delete($id);
    return $msg;
  }
  //管理者報告の重複確認
  public function report_check($id, $user_id) {
    $res = $this->Locate->report_duplicate($id, $user_id);
    return $res;
  }
  //管理者報告　reportテーブルに投稿者,報告者,投稿id,カテゴリを登録
  public function report_complete($id, $posted_by) {
    $rep_category = $_POST['rep_category'] ? $_POST['rep_category'] : '';
    $reported_by = $_SESSION['user']['id'];
    $msg = $this->Locate->report($id, $posted_by, $rep_category, $reported_by);
    return $msg;
  }
  //Follow 重複チェック
  public function follow_check($u_id, $p_id) {
    $res = $this->Locate->follow_duplicate($u_id, $p_id);
    //del_flg == 1のときを除外
    if(!empty($res)) {
      if($res['del_flg'] == 1) {
      $res = [];
      }
    }
    return $res;
  }
  //follow db操作
  public function follow_process($u_id, $p_id) {
    $res = $this->Locate->follow_duplicate($u_id, $p_id);
    //テーブルになければ追加
    if(!empty($res)) {
      if($res['del_flg'] == 1) {
        $this->Locate->re_follow($u_id, $p_id);
      } else {
        $this->Locate->follow_remove($u_id, $p_id);
      }
    } else {
      $this->Locate->follow_add($u_id, $p_id);
    }
  }
  //favorite 重複チェック
  public function favorite_check($fav_u_id, $fav_p_id) {
    $res = $this->Locate->favorite_duplicate($fav_u_id, $fav_p_id);
    //del_flg == 1のときを除外
    if(!empty($res)) {
      if($res['del_flg'] == 1) {
      $res = [];
      }
    }
    return $res;
  }
  //fav db操作
  public function fav_process($fav_u_id, $fav_p_id) {
    $res = $this->Locate->favorite_duplicate($fav_u_id, $fav_p_id);
    if(!empty($res)) {
      if($res['del_flg'] == 1) {
        $this->Locate->re_favorite($fav_u_id, $fav_p_id);
      } else {
        $this->Locate->favorite_remove($fav_u_id, $fav_p_id);
      }
    } else {
      $this->Locate->favorite_add($fav_u_id, $fav_p_id);
    }
  }
  //favorite 一覧用
  public function favorite_list($id) {
    $result = $this->Locate->favorite_all($id);
    return $result;
  }
  //favorite 件数表示
  public function favorite_number($id) {
    $res = '';
    $result = $this->Locate->favorite_counts($id);
    if($result) {
      $res = $result['c'];
    } else {
      $res = 0;
    }
    return $res;
  }
  //followユーザー投稿 一覧用
  public function follow_list($id) {
    $result = $this->Locate->follow_posts($id);
    return $result;
  }
  //特定ユーザーのページ
  public function user_locate() {
    $id = $_GET ? $_GET['user_id'] : '';
    $result = $this->Locate->posted_locate($id);
    return $result;
  }
  //ユーザーidからユーザー名の取得
  public function user_name() {
    $id = $_GET ? $_GET['user_id'] : '';
    $name = $this->Locate->name_get($id);
    return $name;
  }
  //報告内容カテゴリ配列
  public function report_category() {
    $rep = ['1' => '虚偽投稿',
            '2' => '公序良俗に反する',
            '3' => '誹謗中傷にあたる'];
    return $rep;
  }
}
