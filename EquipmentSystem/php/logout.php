<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그아웃중</title>
</head>
<body>
    <?php
    setcookie('user_id', $id, time() - 3600, '/');
    header('Location: ../index.html');
    ?>
</body>
</html>