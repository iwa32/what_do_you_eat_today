<?php

require('function.php');

//デバッグ
debug('「「「「「「「「「「「「「「「「');
debug('ログインページ');
debugLogStart();

//認証チェック
require('auth.php');

//ログイン処理
if (!empty($_POST)) {

  debug('POST送信されました。');
  $email = escape($_POST['email']);
  $password = escape($_POST['password']);
  $password_save = !empty(escape($_POST['password_save'])) ? true: false;

  //バリデーション
  debug('バリデーション開始');
  //email
  validRequired($email, 'email');
  validMaxLen($email, 'email');
  validTypeEmail($email);
  //password
  validRequired($password, 'password');
  validMinLen($password, 'password');
  validHalf($password, 'password');

  if (empty($err_msg)) {

    debug('バリデーションOK');
    try {
      $sql = 'SELECT password,id FROM users WHERE email = :email AND deleted_at IS NULL';
      $pdo = dbConnect();
      $data = [
        ':email' => $email
      ];

      $stmt = queryPost($pdo, $sql, $data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      debug('resultの中身' . print_r($result, true));

      if (!empty($result) && password_verify($password, $result['password'])) {
        //パスワードの照合

        debug('パスワードが一致しました。');
        //セッションにユーザー情報を保存
        //デフォルト有効期限は1時間
        $sessionLimit = 60 * 60;
        if ($password_save) {

          debug('ログインを保持します。');
          //有効期限を30日にする。
          $_SESSION['login_limit'] = $sessionLimit * 24 * 30;

        } else {

          debug('ログインを保持しません。');
          $_SESSION['login_limit'] = $sessionLimit;
        }

        $_SESSION['login_date'] = time();
        $_SESSION['user_id'] = $result['id'];

        //マイページへ
        header('Location:my_page.php');
      } else {

        debug('パスワードが一致しませんでした。');
        $err_msg['common'] = MSG_NO_MATCH;
      }

    } catch(Exception $e) {
      debug('システムエラー' . $e->getMessage());
      $err_msg['common'] = MSG_SYS_ERROR;
    }
  }
}

?>


<?php
$siteTitle = 'ログイン';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">ログイン</h2>

        <form action="" method="POST" id="authForm">
          <div class="form-area__group">
            <div class="form-area__group__alert"><?php echo getErrMsg('common'); ?></div>
          </div>
          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">Eメール<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
              <input class="form-area__group__input" type="text" name="email" id="email"　value="<?php getFormData('email'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('email'); ?></div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="password">
              <div class="form-area__group__name">パスワード<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">パスワードは5文字以上で入力してください</div>
              <input class="form-area__group__input" type="password" name="password" id="password" value="<?php getFormData('password'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('password'); ?></div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="password_save" class="form-area__group__checkbox-area">
              <input class="form-area__group__check" type="checkbox" name="password_save" id="password_save">
              <div class="form-area__group__name">ログインを保持する。</div>
            </label>
          </div>

          <a href="./remind_pass.php">パスワードをお忘れの方はこちらへ</a>

          <div class="form-area__btn-group">
            <div class="form-area__btn--wrapp">
              <button class="form-area__auth-btn form-area__auth-btn--normal disabled" id="submitBtn">ログインする</button>
            </div>

            <!-- <div class="form-area__btn--wrapp">
              <button class="form-area__auth-btn form-area__auth-btn--twitter">Sign in with Twitter</button>
            </div> -->
          </div>
        </form>

      </div>
    </div>
  </main>

  <?php require("footer.php") ?>