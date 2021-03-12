<?php

//共通変数・関数読み込み
require('function.php');
debug('「「「「「「「「「「「「');
debug('パスワード再発行ページ');
debug('」」」」」」」」」」」」」');
debugLogStart();

if (!empty($_POST)) {
  debug('POST送信があります。');
  debug('POSTの中身' . print_r($_POST, true));
  $email = escape($_POST['email']);

  debug('バリデーション開始');
  //未入力チェック
  validRequired($email, 'email');

  if (empty($err_msg)) {

    validTypeEmail($email);
    validMaxLen($email, 'email');
    
    if (empty($err_msg)) {
      debug('バリデーションOK');
      
      try {
        $pdo = dbConnect();
        $sql = 'SELECT count(*) FROM users WHERE email = :email AND deleted_at IS NULL';
        $data = [
          ':email' => $email
        ];
        $stmt = queryPost($pdo, $sql, $data);
        //クエリの実行結果を取得
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt && array_shift($result)) {
          //EmailがDBに登録されている場合
          debug('クエリ成功、DB登録あり');
          $_SESSION['msg_success'] = SUC_SENDED_MAIL;
          //認証キーを発行
          $auth_key = generateRandomAuthKey();
          //メール送信しました。フラグをsessionに格納
          //メール送信
          $to = $email;
          $from = 'iwakou32@gmail.com';
          $subject = '[今日は何食べる？]**パスワード再発行認証のお知らせ';
          $message = <<<EOM
          パスワード再発行のお知らせです。下記の認証キーを認証ページにてご入力ください。
          認証キー:{$auth_key}
          認証ページURL:http://localhost:8888/input_auth_key.php
          -------------------------------------
          今日は何食べる？
          URL http://localhost:8888/
          E-mail iwakou32@gmail.com
          -------------------------------------
          EOM;
          sendMail($to, $subject, $message, $from);

          $_SESSION['auth_key'] = $auth_key;
          $_SESSION['auth_email'] = $email;
          //現在時刻から30分間を有効期限とする.UNIXタイムスタンプを格納
          $_SESSION['auth_key_limit'] = time() + (60 * 30);
          debug('セッション変数の中身' . print_r($_SESSION, true));

          //認証キー入力ページへリダイレクト
          header('Location:input_auth_key.php');
        }

      } catch (Exception $e) {
        error_log('エラー発生' . $e->getMessage());
        $err_msg['common'] = MSG_SYS_ERROR;
      }
    }
  }
}
?>


<?php
$siteTitle = 'パスワード再発行';
require('head.php');
?>

<body>
  <?php
  require('header.php');
  ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">パスワード再発行</h2>

        <form action="" method="POST" id="authForm">
          <div class="form-area__group">
            <div class="form-area__group__alert"><?php echo getErrMsg('common'); ?></div>
          </div>
          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">Eメール<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
              <input class="form-area__group__input" type="text" name="email" id="remindEmail" 　value="<?php getFormData('email'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('email'); ?></div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__btn-group">
            <div class="form-area__btn--wrapp">
              <button class="form-area__auth-btn form-area__auth-btn--normal disabled" id="submitBtn">メール送信</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </main>

  <?php
  require('footer.php');
  ?>