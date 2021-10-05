<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
$Locate = new LocateController;

if(!empty($_POST)) {
  $fav_u_id = $_POST['fav_u_id'];
  $fav_p_id = $_POST['fav_p_id'];
  $Locate->fav_process($fav_u_id, $fav_p_id);
}
$_POST = [];
?>
