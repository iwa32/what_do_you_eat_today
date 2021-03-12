<?php
require('function.php');

debug('「「「「「「「「「「「');
debug('プロフィール編集ページ');
debugLogStart();

require('auth.php');

$dbFormData = getUser($_SESSION['user_id']);

if (!empty($_POST)) {

  debug('POST送信があります。');
  $name = escape($_POST['name']);
  $email = escape($_POST['email']);
  $message = escape($_POST['message']);
  //ファイルが送信されていればそのファイルのパスを格納する。
  $my_icon = (!empty($_FILES['my_icon']['name'])) ? uploadImage($_FILES['my_icon'], 'my_icon') : '';
  //ファイルが送信されていないが、ユーザーデータにアイコンのパスがあればそのパスを格納する。
  $my_icon = (empty($my_icon) && !empty($dbFormData['my_icon'])) ? $dbFormData['my_icon'] : $my_icon;

  debug('バリデーション開始');
  if ($dbFormData['name'] !== $name) {
    //name
    validMaxLen($name, 'name');
  }

  if ($dbFormData['email'] !== $email) {
    //email
    //未入力チェック
    validRequired($email, 'email');
    //形式チェック
    validTypeEmail($email);
    //最大文字数チェック
    validMaxLen($email, 'email');
    if (empty($err_msg)) {
      //メール重複チェック
      validEmailDup($email);
    }
  }

  if ($dbFormData['message'] !== $message) {
    //message
    validMaxLen($message, 'message', 1000);
  }

  if (empty($err_msg)) {

    debug('バリデーションOK');
    debug('リクエストデータ' . print_r($_POST, true));
    try {
      $pdo = dbConnect();
      $sql = 'UPDATE users SET name = :name, email = :email, message = :message, my_icon = :my_icon, updated_at = :updated_at WHERE id = :u_id';

      $data = [
        ':name' => $name,
        ':email' => $email,
        ':message' => $message,
        ':my_icon' => $my_icon,
        ':updated_at' => date('Y-m-d H:i:s'),
        ':u_id' => $_SESSION['user_id']
      ];
      $stmt = queryPost($pdo, $sql, $data);

      if ($stmt) {
        $_SESSION['msg_success'] = SUC_EDITED_PROFILE;
        debug('クエリ成功');
        debug('マイページへ遷移します。');
        header('Location:my_page.php');
      } else {

        debug('クエリ失敗');
        $err_msg['common'] = MSG_SYS_ERROR;
      }
    } catch (Exception $e) {

      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = MSG_SYS_ERROR;
    }
  }
}


?>

<?php
$siteTitle = 'プロフィール編集';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area edit-my-page">
        <h2 class="form-area__title">プロフィール編集</h2>

        <form action="" method="POST" enctype="multipart/form-data">

          <div class="form-area__group__alert"><?php echo getErrMsg('common'); ?></div>
          <div class="form-area__group">
            <label for="myIcon" class="my-icon" id="imageArea">
              <p class="my-icon__thum-img">
                <img src="<?php echo showImg(getFormData('my_icon')); ?>" id="myIconImg">
              </p>
              <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
              <input type="file" name="my_icon" id="myIcon" class="my-icon__input-file">

              <div class="form-area__group__place-holder">ドラッグ&ドロップかクリックでファイルを選択</div>
              <div class="form-area__group__alert"><?php echo getErrMsg('my_icon'); ?></div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="name">
              <div class="form-area__group__name">お名前<span class="form-area__group__badge form-area__group__badge--normal">[任意]</span></div>
              <input class="form-area__group__input" type="text" name="name" id="name" value="<?php echo getFormData('name'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('name'); ?></div>
              <div class="form-area__group__place-holder">山田太郎</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">Eメール<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
              <input class="form-area__group__input" type="text" name="email" id="email" value="<?php echo getFormData('email'); ?>">
              <div class="form-area__group__alert"><?php echo getErrMsg('email'); ?></div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="message">
              <div class="form-area__group__name">メッセージ<span class="form-area__group__badge form-area__group__badge--normal">[任意]</span></div>
              <div class="form-area__group__help">1000文字まで入力可能です。</div>
              <textarea class="form-area__group__input edit-my-page__message" type="text" name="message" id="myMessage"><?php echo getFormData('message'); ?></textarea>
              <div class="form-area__group__alert"><?php echo getErrMsg('message'); ?></div>
              <div class="form-area__group__place-holder">
                <span class="count">0</span>/1000
              </div>
            </label>
          </div>

          <div class="edit-btns"><button class="edit-btn btn">編集する</button></div>
        </form>
      </div>
    </div>
  </main>

  <?php require("footer.php") ?>