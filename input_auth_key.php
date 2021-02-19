<?php
//共通関数読み込み
require('function.php');
debug('「「「「「「「「「');
debug('認証キー入力ページ');
debug('」」」」」」」」」」');
debugLogStart();

if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POSTの中身' . print_r($_POST, true));

  $auth_key = $_POST['auth_key'];
  //未入力チェック
  validRequired($auth_key, 'auth_key');

  if (empty($err_msg)) {

    //英数字チェック
    validHalf($auth_key, 'auth_key');
    //桁数チェック
    validLength($auth_key, 'auth_key');

    if (empty($err_msg)) {

      debug('バリデーションOK');
      //認証キーの有効期限チェック
      if (time() > $_SESSION['auth_key_limit']) {
        debug('認証キー有効期限切れ');
        $err_msg['auth_key'] = MSG_EXPIRED;
      }

      //認証キーのPOSTデータとSESSIONデータの照合
      if ($auth_key !== $_SESSION['auth_key']) {
        debug('認証キーが正しくありません');
        $err_msg['auth_key'] = MSG_AUTH_IS_INCORRECT;
      }

      if (empty($err_msg)) {
        debug('認証キー照合OK');
        //パスワード生成
        $password = generateRandomAuthKey();
        try {
          $pdo = dbConnect();
          $sql = 'UPDATE users SET password = :password WHERE email = :email';
          $data = [
            ':email' => $_SESSION['auth_email'],
            ':password' => password_hash($password, PASSWORD_DEFAULT)
          ];
          $stmt = queryPost($pdo, $sql, $data);

          if ($stmt) {
            debug('クエリ成功DB更新');
            //メール送信
            $to = $_SESSION['auth_email'];
            $from = 'iwakou32@gmail.com';
            $subject = '[今日は何食べる？]**パスワード再発行のお知らせ';
            $message = <<<EOM
            パスワード再発行が完了しました。
            下記のURLにて再発行パスワードをご入力いただき、ログインください。
            パスワード: {$password}
            ログインページURL:http://localhost:8888/login.php
            -------------------------------------
            今日は何食べる？
            URL http://localhost:8888/
            E-mail iwakou32@gmail.com
            -------------------------------------
            EOM;
            sendMail($to, $subject, $message, $from);
            //セッションを削除, 下記のmsgを保存するためsession_idを削除しない方法で処理
            session_unset();
            $_SESSION['msg_success'] = SUC_SENDED_MAIL;
            header('Location:login.php');
          }
        } catch (Exception $e) {
          error_log('エラー発生' . $e->getMessage());
          $err_msg['common'] = MSG_SYS_ERROR;
        }
      }
    }
  }
}

?>
<?php
$siteTitle = '認証キー入力';
require('head.php');
?>

<body>
  <?php
  require('header.php');
  ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">認証キーを入力</h2>

        <form action="" method="POST">
          <div class="form-area__group">
            <div class="form-area__group__alert"><?php echo getErrMsg('common'); ?></div>
          </div>
          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">認証キー<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <input class="form-area__group__input" type="text" name="auth_key" id="authKey" value="<?php if (!empty($_POST['auth_key'])) echo $_POST['auth_key']; ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('auth_key'); ?></div>
            </label>
          </div>

          <div class="form-area__btn-group">
            <div class="form-area__btn--wrapp">
              <button class="form-area__auth-btn form-area__auth-btn--normal" id="submitBtn">パスワード再発行</button>
            </div>

          </div>
        </form>

      </div>
    </div>
  </main>

  <?php
  require('footer.php');
  ?>