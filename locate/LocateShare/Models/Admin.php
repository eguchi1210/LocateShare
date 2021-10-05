<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Admin extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
  //違反 > 更新日でソート　データ取得
  public function reports_count() {
    $sql = 'SELECT count(*) c, l.* FROM Report r JOIN Location l ON r.location_id = l.id WHERE l.del_flg = 0';
    $sql .= ' GROUP BY r.location_id ORDER BY c DESC, l.updated_at DESC';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //投稿ごとの報告件数取得
  public function rep_detail_count($id) {
  $sql = 'SELECT count(*) c FROM Report r JOIN Location l ON r.location_id = l.id WHERE :id = r.location_id';
  $sth = $this->dbh->prepare($sql);
  $sth ->bindParam(':id', $id, PDO::PARAM_STR);
  $sth ->execute();
  $result = $sth->fetch(PDO::FETCH_ASSOC);
  return $result;
  }
  //違反のカテゴリごと集計データ取得
  public function rep_category_count($id) {
    $sql = 'SELECT rep_category, count(*) c FROM Report r WHERE :id = r.location_id GROUP BY rep_category';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //報告されたユーザーの抽出
  public function reported() {
    $sql = 'SELECT u.id, u.name, count(*) c FROM Report r JOIN User u ON r.posted_by = u.id GROUP BY u.id ORDER BY c DESC';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //報告者ごとの報告件数取得
  public function count_by_reporter() {
    $sql = 'SELECT u.id, u.name, count(*) c FROM Report r JOIN User u ON r.posted_by = u.id GROUP BY u.id';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
  //アカウントの無効化(無効化フラグ:del_flg==2更新)
  public function user_del($id) {
    $msg = '';
    try{
      $this->dbh->beginTransaction();
      $sql = 'UPDATE User SET del_flg = 2 WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':id', $id, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
      $msg = '成功';
    } catch (PDOException $e) {
      $this ->dbh->rollback();
      $msg = '失敗'.$e;
    }
    return $msg;
  }
  //無効化したアカウントの投稿を全て削除(無効化フラグ:del_flg==2)
  public function del_posts_all($id) {
    $msg = '';
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Location l SET del_flg = 2 WHERE del_flg = 0 AND user_id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':id', $id, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
      $msg = '成功';
    } catch (PDOException $e) {
      $this->dbh->rollback();
      $msg = '失敗'.$e;
    }
  }
}
