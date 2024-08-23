<?php


$eqid = $_POST['eqid'];

if (isset($_COOKIE['shoppinglist'])) {
    $shoppinglist = $_COOKIE['shoppinglist'];
    if (strpos($shoppinglist, $eqid) !== false) {
        echo '2';
        exit;
    } else {
        $shoppinglist = $shoppinglist . ',' . $eqid;
    }
} else {
    $shoppinglist = $eqid;
}

setcookie('shoppinglist', $shoppinglist, time() + 3600, '/EquipmentSystem');
echo '1';

?>