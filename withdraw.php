<?php
require('function.php');

debug('「「「「「「「「「「「');
debug('退会');
debugLogStart();

require('auth.php');


if (!empty($_POST)) {
  debug("POST送信がありました。");

  try {
    $pdo = dbConnect();
    $sql = "UPDATE users SET deleted_at = now() WHERE id = :id";
    $data = [':id' => $_SESSION['user_id']];
    $stmt = queryPost($pdo, $sql, $data);

    if ($stmt) {
      debug('退会完了');
      session_destroy();
      debug('セッションの中身'. print_r($_SESSION, true));
      header('Location:index.php');
    }
    
  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
    $err_msg['common'] = MSG_SYS_ERROR;
  }
}

?>


<?php
$siteTitle = '退会する';
require('head.php');
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area with-draw-page">
        <form action="" method="POST">
          <p class="with-draw-page__title">※退会を行うと全てのユーザー情報が失われます。</p>
          <div class="with-draw-page__btns"><button type="submit" class="with-draw-page__btn btn" name="submit" value="退会する">退会する</button></div>
        </form>
      </div>
    </div>
  </main>

  <?php require("footer.php") ?>