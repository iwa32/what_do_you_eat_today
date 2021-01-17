<?php

require('function.php');
debug('「「「「「「「「「「「「「');
debug('ユーザー登録ページ');
debugLogStart();

if (!empty($_POST)) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  validRequired($email, 'email');
  validRequired($password, 'password');

  if (empty($err_msg)) {
    //name
    validMaxLen($name, 'name');
    //email
    validTypeEmail($email);
    validEmailDup($email);
    validMaxLen($email, 'email');
    //password
    validMinLen($password, 'password');
    validMaxLen($password, 'password');
    validHalf($password, 'password');

    if (empty($err_msg)) {

      try {
        $pdo = dbConnect();
        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password) WHERE deleted_at IS NULL';

        $data = [
          ':name' => $name,
          ':email' => $email,
          ':password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $stmt = queryPost($pdo, $sql, $data);

        if ($stmt) {
          //認証済みユーザーとして扱う
          //セッションの有効期限
          $sessionLimit = 60 * 60;
          $_SESSION['login_date'] = time();
          $_SESSION['login_limit'] = $sessionLimit;
          $_SESSION['user_id'] = $pdo->lastInsertId();

          debug('ユーザー登録成功、マイページへ遷移します。');
          debug('セッションの中身' . print_r($_SESSION, true));
          header('Location:my_page.php');
        } else {

          debug('クエリに失敗しました。');
          $err_msg['common'] = MSG_SYS_ERROR;
        }

      } catch (Exception $e) {
        error_log('ユーザー登録エラー' . $e->getMessage());
        $err_msg['common'] = MSG_SYS_ERROR;
      }
    }
  }
}

?>

<?php
$siteTitle = 'ユーザー登録';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">ユーザー登録</h2>

        <form action="" method="POST" id="signUpForm">
          <div class="form-area__group">
            <div class="form-area__group__alert"><?php if (!empty($err_msg['common'])) echo $err_msg['common'] ?></div>
          </div>
          <div class="form-area__group">
            <label for="name">
              <div class="form-area__group__name">お名前<span class="form-area__group__badge form-area__group__badge--any">[任意]</span></div>
              <input class="form-area__group__input" type="text" name="name" id="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name']; ?>">
              <div class="form-area__group__alert"><?php if (!empty($err_msg['name'])) echo $err_msg['name']; ?></div>
              <div class="form-area__group__place-holder">山田太郎</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">Eメール<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
              <input class="form-area__group__input" type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
              <div class="form-area__group__alert"><?php if (!empty($err_msg['email'])) echo $err_msg['email']; ?></div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="password">
              <div class="form-area__group__name">パスワード<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">5文字以上で半角英数字で入力してください</div>
              <input class="form-area__group__input" type="password" name="password" id="password" value="<?php if(!empty($_POST['password'])) echo $_POST['password'] ?>">
              <div class="form-area__group__alert"><?php if (!empty($err_msg['password'])) echo $err_msg['password'] ?></div>
            </label>
          </div>

          <div class="form-area__btn-group">
            <div class="form-area__btn--wrapp">
              <button class="form-area__btn form-area__btn--normal disabled" id="submitBtn">登録する</button>
            </div>

            <div class="form-area__btn--wrapp">
              <button class="form-area__btn form-area__btn--twitter">Sign in with Twitter</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </main>

  <?php require("footer.php") ?>