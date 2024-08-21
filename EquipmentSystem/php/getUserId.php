<?php
session_start();
if (!isset($_SESSION['userId'])) {
    echo "0";
} else {
    echo $_SESSION['userId'];
}
?>