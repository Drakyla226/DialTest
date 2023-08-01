<!DOCTYPE html>
<html lang="ru">

<head>
  <title>
    <?= $APPLICATION->ShowTitle() ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
</head>

<body>
  <?php $APPLICATION->ShowHead(); ?>
  <div id="panel">
    <?= $APPLICATION->ShowPanel() ?>
  </div>

  <div align="right">
    <?php
    if ($USER->IsAuthorized()) :
      $userid = $USER->GetID();
      $user = $USER->GetByID($userid)->Fetch();
      $firstName = $user['NAME'];
      $lastName = $user['LAST_NAME'];
    ?>
      Привет, <?= $firstName ?> <?= $lastName ?>!<p>
      <form method="post">
        <button name='logout'>Выйти</button>
        <button><a  href="/auth/personal.php" style="text-decoration: none">Профиль</a></button>
      </form>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) :
        session_start();
        session_destroy();
        header('Location: /');
        exit();
      endif;
    else :?>
      <button><a href="/auth/">Авторизация</a></button>
    <?php endif;
    ?>
  </div>