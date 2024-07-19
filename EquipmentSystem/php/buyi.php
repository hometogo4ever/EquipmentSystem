<?php
$buylist = $_POST['eqid'];
setcookie('buylist', $buylist, time() + 3600, '/');
echo "1";
?>