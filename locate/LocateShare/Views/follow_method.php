<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
$Locate = new LocateController;

if(!empty($_POST)) {
  $u_id = $_POST['u_id'];
  $p_id = $_POST['p_id'];
  $Locate->follow_process($u_id, $p_id);
}
$_POST = [];
?>
