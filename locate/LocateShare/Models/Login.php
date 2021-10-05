<?php
require_once(ROOT_PATH .'/Models/Db.php');

class LogIn extends Db {
  private $table = 'User';

  //test
  public function test() {
    $sql = 'SELECT * FROM '.$this->table;
    $sth = $this->dbh->prepare($sql);
    $sth ->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // ユーザー新規登録
  public function SignUp($arr) {
    try {
      $this->dbh->beginTransaction();

      $sql = 'INSERT INTO '.$this->table.' (name, mail, birth, password) VALUES (:name, :mail, :birth, :password);';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam('name', $arr["name"], PDO::PARAM_STR);
      $sth ->bindParam(':mail', $arr["mail"], PDO::PARAM_STR);
      $sth ->bindParam(':password', $arr["password"], PDO::PARAM_STR);
      $sth ->bindParam(':birth', $arr['birth'], PDO::PARAM_STR);
      $sth ->execute();

      $this->dbh->commit();
    } catch (PDOException $e){
      $this->dbh->rollback();
      echo 'データベースアクセスに失敗'.$e->getMessage();
      exit;
    }
  }

//ユーザー名重複チェック
  public function NameDuplicateCheck($name) {
    $sql = 'SELECT * FROM '.$this->table.' WHERE name = :name';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':name', $name, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //アドレス重複チェック
  public function AddressDuplicateCheck($mail) {
    $sql = 'SELECT * FROM '.$this->table.' WHERE mail = :mail';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':mail', $mail, PDO::PARAM_STR);
    $sth ->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

//ユーザーログイン
  public function UserValid($arr = ['name' => '', 'password' => '']) {
    $sql = 'SELECT * FROM '.$this->table.' WHERE name = :name';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':name', $arr['name'], PDO::PARAM_STR);
    $sth ->execute();
    $params = $sth->fetch(PDO::FETCH_ASSOC);
    if(isset($params['password'])) {
      if(password_verify($arr['password'], $params['password'])) {
        return $params;
      }
    }
  }
  //アドレス,生年月日チェック
  public function Mail_Birth_valid($mail, $birth) {
    $sql = 'SELECT * FROM '.$this->table.' WHERE mail = :mail AND birth = :birth';
    $sth = $this->dbh->prepare($sql);
    $sth ->bindParam(':mail', $mail, PDO::PARAM_STR);
    $sth ->bindParam(':birth', $birth, PDO::PARAM_STR);
    $sth ->execute();
    $res = $sth->fetch(PDO::FETCH_ASSOC);
    if(isset($res)) {
      return $res;
    } else {
      return false;
    }
  }
  //パスワード更新
  public function Pass_Reset($pass, $mail) {
    $msg = '';
    try {
      $this->dbh->beginTransaction();
      $sql = 'UPDATE User SET password = :password WHERE mail = :mail';
      $sth = $this->dbh->prepare($sql);
      $sth ->bindParam(':password', $pass, PDO::PARAM_STR);
      $sth ->bindParam(':mail', $mail, PDO::PARAM_STR);
      $sth ->execute();
      $this ->dbh->commit();
      $msg = 'パスワードの更新が完了しました';
    } catch(PDOException $e) {
      $this->dbh->rollback();
      $msg = 'パスワードの更新に失敗しました';
    }
    return $msg;
  }
}
