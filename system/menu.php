<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
if (!isset($_SESSION['USERID'])) {
  header("Location:login.php");
}}
include_once 'init.php';

?>



<?php

$userrole=$_SESSION['ROLE'];

$menu="users/menu/$userrole.php";
include $menu;

?>