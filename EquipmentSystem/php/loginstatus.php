<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo '0';
} else {
  $id = $_SESSION['user_id'];
  echo $id;
}

?>
