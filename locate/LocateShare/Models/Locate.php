<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Locate extends Db {
  private $table = 'Location';
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

// ユーザーidからユーザー投稿一覧取得
  public function posted_locate($id):Array {
    $sql = 'SELECT * FROM '.$this->table;
    $sql .= ' WHERE :user_id = user_id AND del_flg = 0 ORDER BY updated_at DESC;';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':user_id', $id, PDO::PARAM_INT);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

//投稿検索
  public function find_locate($f_name, $f_category, $f_address, $page):Array {
    $sql = 'SELECT l.*, u.name u_name, u.id u_id FROM '.$this->table.' l JOIN `User` u ON l.user_id = u.id';
    $sql .= " WHERE l.del_flg = 0 AND l.name LIKE '$f_name'";
    $sql .= ' AND category_id = '.$f_category;
    $sql .= " AND address LIKE '$f_address' ORDER BY l.updated_at DESC";
    $sql .= ' LIMIT 10 OFFSET '.(10 * $page);
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //検索件数取得
  public function find_count($f_name, $f_category, $f_address) {
    $sql = 'SELECT count(*) FROM '.$this->table.' l JOIN `User` u ON l.user_id = u.id';
    $sql .= " WHERE l.del_flg = 0 AND l.name LIKE '$f_name'";
    $sql .= ' AND category_id = '.$f_category;
    $sql .= " AND address LIKE '$f_address'";
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $count = $sth ->fetchColumn();
    return $count;
  }

//投稿idから投稿内容取得
  public function detail_locate($id):Array {
    $sql = 'SELECT l.*, u.name u_name FROM '.$this->table;
    $sql .= ' l JOIN `User` u ON l.user_id = u.id';
    $sql .= ' WHERE :id = l.id AND l.del_flg = 0';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_INT);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

//新規投稿
  public function add_locate($arr) {
    try {
      $this->dbh->beginTransaction();
      $sql = 'INSERT INTO '.$this->table;
      $sql .= ' (name, category_id, user_id, post_num, image, address, comment)';
      $sql .= ' VALUES (:name, :category_id, :user_id, :post_num, :image, :address, :comment)';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':name', $arr["name"], PDO::PARAM_STR);
      $sth ->bindParam(':category_id', $arr['category_id'], PDO::PARAM_STR);
      $sth ->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
      $sth ->bindParam(':post_num', $arr['post_num'], PDO::PARAM_STR);
      $sth ->bindParam(':image' ,$arr['image'], PDO::PARAM_STR);
      $sth ->bindParam(':address', $arr['address'], PDO::PARAM_STR);
      $sth ->bindParam(':comment', $arr['comment'], PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
      $msg = '投稿完了しました';
    } catch (PDOException $e) {
      $this ->dbh->rollback();
      $msg = '投稿失敗しました'.$e;
    }
    return $msg;
  }

  //投稿更新
  public function upd_locate($arr) {
    $msg = '';
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE '.$this->table.' SET name = :name, category_id = :category_id, post_num = :post_num,';
      $sql .= ' image = :image, address = :address, comment = :comment WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':id', $arr['id'], PDO::PARAM_STR);
      $sth ->bindParam(':name', $arr["name"], PDO::PARAM_STR);
      $sth ->bindParam(':category_id', $arr['category_id'], PDO::PARAM_STR);
      $sth ->bindParam(':post_num', $arr['post_num'], PDO::PARAM_STR);
      $sth ->bindParam(':image' ,$arr['image'], PDO::PARAM_STR);
      $sth ->bindParam(':address', $arr['address'], PDO::PARAM_STR);
      $sth ->bindParam(':comment', $arr['comment'], PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
      $msg = '更新完了しました。';
    } catch (PDOException $e) {
      $this ->dbh->rollback();
      $msg =  "更新に失敗しました<br>".$e->getMessage();
    }
    return $msg;
  }
  //投稿削除(del_flg == 1に更新)
  public function delete($id) {
  $msg = '';
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Location SET del_flg = 1 WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':id', $id, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
      $msg = '削除完了しました';
    }  catch(PDOException $e) {
      $this ->dbh->rollback();
      $msg = '削除に失敗しました';
    }
    return $msg;
  }
//dbからカテゴリ取得
  public function categories():Array {
    $sql = 'SELECT * FROM Category';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

//アップロード画像の確認表示
  public function img_upload($arr) {
    $up_file = '';
    $up_valid = false;
    $file_name = isset($arr['name']) ? $arr['name'] : '';
    $tmp_file = isset($arr['tmp']) ? $arr['tmp'] : '';
    if(isset($tmp_file) and isset($tmp_file)) {
      $split = explode('.', $file_name);
      $ext = end($split);
      if(isset($ext) and $ext != $file_name) {
        $up_file = 'img/'.date('Ymd_His.') .mt_rand(1000,9999) .$ext;
        $up_valid = move_uploaded_file($tmp_file, $up_file);
        return $up_file;
      }
    }
  }
  //新規の違反報告
  public function report($id, $posted_by, $rep_category, $reported_by) {
    $msg = '';
    try {
      $this->dbh->beginTransaction();
      $sql = 'INSERT INTO Report (location_id, posted_by, rep_category, reported_by)';
      $sql .= ' VALUE (:id, :posted_by, :rep_category, :reported_by)';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':id', $id, PDO::PARAM_STR);
      $sth ->bindParam(':posted_by', $posted_by, PDO::PARAM_STR);
      $sth ->bindParam(':rep_category', $rep_category, PDO::PARAM_STR);
      $sth ->bindParam(':reported_by', $reported_by, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
      $msg = '報告が完了しました';
    } catch (PDOException $e) {
      $this->dbh->rollback();
      $msg = '報告内容の登録に失敗しました';
    }
    return $msg;
  }
  //違反報告の重複確認
  public function report_duplicate($id, $user_id) {
    $sql = 'SELECT * FROM Report WHERE location_id = :id AND reported_by = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //Favorite の重複確認
  public function fav_duplicate() {
    $sql = 'SELECT f.id, f.del_flg FROM Favroite f JOIN `User` u ON f.user_id = :u_id';
    $sql .= ' WHERE f.location_id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':u_id', $user_id, PDO::PARAM_STR);
    $sth ->bindParam(':id', $post_id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //Follow の確認
  public function follow_duplicate($u_id, $p_id) {
    $sql = 'SELECT * FROM Follow WHERE :follow_user = follow_user AND :followed_user = followed_user';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':follow_user', $u_id, PDO::PARAM_STR);
    $sth ->bindParam(':followed_user', $p_id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //Follow 追加
  public function follow_add($u_id, $p_id) {
    try{
      $this->dbh->beginTransaction();
      $sql = 'INSERT INTO Follow (follow_user, followed_user) VALUES (:u_id, :p_id)';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':u_id', $u_id, PDO::PARAM_STR);
      $sth ->bindParam(':p_id', $p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
    } catch (PDOException $e){
      $this->dbh->rollback();
    }
  }
  //再度フォロー del_flg == oに更新
  public function re_follow($u_id, $p_id) {
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Follow SET del_flg = 0 WHERE follow_user = :u_id AND followed_user = :p_id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':u_id', $u_id, PDO::PARAM_STR);
      $sth ->bindParam(':p_id', $p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
    }
  }
  //フォロー解除　del_flg == 1に更新
  public function follow_remove($u_id, $p_id) {
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Follow SET del_flg = 1 WHERE follow_user = :u_id AND followed_user = :p_id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':u_id', $u_id, PDO::PARAM_STR);
      $sth ->bindParam(':p_id', $p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
    }
  }
  //fav チェック
  public function favorite_duplicate($fav_u_id, $fav_p_id) {
    $sql = 'SELECT * FROM Favorite WHERE :location_id = location_id AND :user_id = user_id';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':location_id', $fav_p_id, PDO::PARAM_STR);
    $sth ->bindParam(':user_id', $fav_u_id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //fav 追加
  public function favorite_add($fav_u_id, $fav_p_id) {
    try{
      $this->dbh->beginTransaction();
      $sql = 'INSERT INTO Favorite (location_id, user_id) VALUES (:fav_p_id, :fav_u_id)';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':fav_u_id', $fav_u_id, PDO::PARAM_STR);
      $sth ->bindParam(':fav_p_id', $fav_p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this->dbh->commit();
    } catch (PDOException $e){
      $this->dbh->rollback();
    }
  }
  //fav 再度フォロー del_flg == oに更新
  public function re_favorite($fav_u_id, $fav_p_id) {
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Favorite SET del_flg = 0 WHERE location_id = :fav_p_id AND user_id = :fav_u_id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':fav_u_id', $fav_u_id, PDO::PARAM_STR);
      $sth ->bindParam(':fav_p_id', $fav_p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
    }
  }
  //お気に入り解除　del_flg == 1に更新
  public function favorite_remove($fav_u_id, $fav_p_id) {
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE Favorite SET del_flg = 1 WHERE location_id = :fav_p_id AND user_id = :fav_u_id';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':fav_u_id', $fav_u_id, PDO::PARAM_STR);
      $sth ->bindParam(':fav_p_id', $fav_p_id, PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
    }
  }
  //favorite 一覧
  public function favorite_all($id) {
    $sql = 'SELECT l.*, u.name u_name FROM Favorite f JOIN Location l ON f.location_id = l.id';
    $sql .= ' JOIN User u ON l.user_id = u.id WHERE f.user_id = :id AND l.del_flg = 0 AND f.del_flg = 0 ORDER BY l.updated_at DESC';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //favoreite 件数
  public function favorite_counts($id) {
    $sql = 'SELECT count(*) c FROM Favorite WHERE location_id = :id AND del_flg = 0 GROUP BY location_id';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //followユーザ投稿一覧
  public function follow_posts($id) {
    $sql = 'SELECT l.*, u.name u_name FROM Follow f JOIN Location l ON f.followed_user = l.user_id JOIN User u ON l.user_id = u.id';
    $sql .= ' WHERE f.follow_user = :id AND l.del_flg = 0 AND f.del_flg = 0 ORDER BY l.updated_at DESC';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //ユーザーidからユーザー名取得
  public function name_get($id) {
    $sql = 'SELECT name FROM User WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':id', $id, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //follow全部 テスト用
  public function follow_All() {
    $sql = 'SELECT * FROM Follow';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //fav全部 テスト用
  public function fav_All() {
    $sql = 'SELECT * FROM Favorite';
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
