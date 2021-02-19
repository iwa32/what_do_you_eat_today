<?php
require('function.php');

debug('「「「「「「「「「「「');
debug('パスワード変更ページ');
debug('」」」」」」」」」」」」');
debugLogStart();

//ログイン認証チェック
require('auth.php');
$userData = getUser($_SESSION['user_id']);

if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POST送信内容' . print_r($_POST, true));
  $currentPass = $_POST['current_pass'];
  $newPass = $_POST['new_pass'];
  $newPassConfirm = $_POST['new_pass_confirm'];

  //バリデーションチェック
  //未入力チェック
  validRequired($currentPass, 'current_pass');
  validRequired($newPass, 'new_pass');
  validRequired($newPassConfirm, 'new_pass_confirm');

  if (empty($err_msg)) {

    debug('未入力チェックOK');
    validPass($currentPass, 'current_pass');

    //現在のパスワードとDBのパスワードを照合する
    if (!password_verify($currentPass, $userData['password'])) {
      $err_msg['current_pass'] = MSG_NO_MATCH_CURRENT_PASS;
    }

    //現在のパスワードと新しいパスワードが同じ場合
    if ($currentPass === $newPass) {
      $err_msg['new_pass'] = MSG_SAME_CURRENT_PASS;
    }

    //パスワードが一致しているか
    validMatch($newPass, $newPassConfirm, 'new_pass_confirm');

    if (empty($err_msg)) {

      debug('バリデーションOK');
      try {

        $pdo = dbConnect();
        $sql = 'UPDATE users SET password = :password WHERE id = :u_id';
        $data = [
          ':u_id' => $_SESSION['user_id'],
          ':password' => password_hash($newPass, PASSWORD_DEFAULT)
        ];
        $stmt = queryPost($pdo, $sql, $data);

        if($stmt) {
          debug('クエリ成功');
          
          //メール送信
          $userName = ($userData['name']) ? $userData['name']: 'unknown';
          $from = 'iwakou32.web@gmail.com';
          $to = $userData['email'];
          $subject = '[今日は何食べる？]**パスワード変更のお知らせ';
          $message = <<<EOM
          {$userName}さん。
          パスワードが変更されました。
          -------------------------------------
          今日は何食べる？
          URL http://localhost:8888//
          E-mail iwakou32@gmail.com
          -------------------------------------
          EOM;
          sendMail($to, $subject, $message, $from);

          //マイページへ遷移
          header('Location:my_page.php');
        }

      } catch (Exception $e) {

        error_log('エラー発生'. $e->getMessage());
        $err_msg['common'] = MSG_SYS_ERROR;
      }
    }
  }
}
?>

<?php
$siteTitle = 'パスワード変更';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">パスワード変更</h2>

        <form action="" method="POST">

          <div class="form-area__group__alert"><?php echo getErrMsg('common'); ?></div>

          <div class="form-area__group">
            <label for="currentPass">
              <div class="form-area__group__name">現在のパスワード<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <input class="form-area__group__input" type="text" name="current_pass" id="currentPass" value="<?php echo getFormData('current_pass'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('current_pass'); ?></div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="newPass">
              <div class="form-area__group__name">新しいパスワード<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">5文字以上で半角英数字で入力してください</div>
              <input class="form-area__group__input" type="text" name="new_pass" id="newPass" value="<?php echo getFormData('new_pass'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('new_pass'); ?></div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="newPassConfirm">
              <div class="form-area__group__name">新しいパスワード(再入力)<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <input class="form-area__group__input" type="text" name="new_pass_confirm" id="newPassConfirm" value="<?php echo getFormData('new_pass_confirm'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('new_pass_confirm'); ?></div>
            </label>
          </div>

          <div class="edit-btns"><button class="edit-btn btn">変更する</button></div>
        </form>
      </div>
    </div>
  </main>

  <?php require("footer.php") ?>