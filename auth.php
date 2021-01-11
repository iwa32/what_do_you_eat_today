<?php
//ログイン認証
if (!empty($_SESSION['login_date'])) {
  debug('ログインユーザーです。');

  if (($_SESSION['login_date'] + $_SESSION['login_limit']) < time()) {

    debug("有効期限外ユーザーです。");
    //情報を破棄
    session_destroy();
    header('Location:login.php');

  } else {

    debug("有効期限内ユーザーです。");
    //ログイン日時を更新
    $_SESSION['login_date'] = time();
    if (basename($_SERVER['PHP_SELF']) === 'login.php') {

      header('Location:my_page.php');
    }
  }

} else {
  debug('未ログインユーザーです。');

  if (basename($_SERVER['PHP_SELF']) !== 'login.php') {

    header('Location:login.php');
  }
}