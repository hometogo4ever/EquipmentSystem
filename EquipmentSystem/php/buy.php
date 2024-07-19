<?php
$shoppinglist = $_COOKIE['shoppinglist'];
setcookie('buylist', $shoppinglist, time() + 3600, '/');    // 쿠키에 저장된 쇼핑리스트를 구매리스트로 옮김
echo "1";
?>