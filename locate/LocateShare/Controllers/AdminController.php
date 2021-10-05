<?php
require_once(ROOT_PATH .'/Models/Admin.php');

class AdminController {
  private $Admin;

  public function __construct() {
    $this ->request['get'] = $_GET;
    $this ->request['post'] = $_POST;

    $this ->Admin = new Admin();
    $dbh = $this ->Admin->get_db_handler();
  }
  //違反報告のある投稿を表示(ソート:報告数 > 更新日)
  public function rep_count_locate() {
    $res = $this->Admin->reports_count();
    return $res;
  }
  //報告内容の配列取得
  public function report_arr() {
    $id = $_GET['id'] ? $_GET['id'] : '';
    $rep_count = $this->Admin->rep_detail_count($id);
    $rep_category = $this->Admin->rep_category_count($id);
    $res = ['count' => $rep_count['c'],
            'category' => $rep_category];
    return $res;
  }
  //報告されたユーザーの取得
  public function reported_user() {
    $res = $this->Admin->reported();
    return $res;
  }
  //投稿ごとの報告件数取得
  public function count_by_post($id) {
    $res = $this->Admin->rep_detail_count($id);
    return $res;
  }
  //報告者ごとの報告件数取得
  public function reporters() {
    $res = $this->Admin->count_by_reporter();
    return $res;
  }
  //アカウントの無効化
  public function nullify_account() {
    $id = $_GET['id'] ? $_GET['id'] : '';
    $res_account = $this->Admin->user_del($id);
    $res_post = $this->Admin->del_posts_all($id);
    $res = [$res_account, $res_post];
    return $res;
  }
}
