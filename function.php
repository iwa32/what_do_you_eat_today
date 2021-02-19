<?php
ini_set('log_errors', 'on');
//エラーログの出力先を変更する。
ini_set('error_log', 'php.log');

/**
 * デバッグを出力する
 */
$debug_flg = true; //本番環境時はfalseにする。
function debug($str)
{
  global $debug_flg;
  if ($debug_flg) {
    error_log('デバッグ:' . $str);
  }
}

/**
 * デバッグ開始、セッションのデータなどを確認する。
 */
function debugLogStart()
{
  debug('>>>>>>>>>>>>>>>>>>>画面表示開始');
  debug('セッションid:' . session_id());
  debug('セッション変数の中身:' . print_r($_SESSION, true));
  debug('現在日時' . time());
  if (!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])) {
    debug('ログイン日時の有効期限' . ($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}

//セッションの保管場所を変更
session_save_path("/var/tmp/");
//ガベージコレクション設定
//セッションの有効期限を30日にする。
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
//クッキーをブラウザを閉じても残し、有効期限を30日にする。
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
session_start();
//セッションidを毎度再生成する。(なりすまし対策)
session_regenerate_id();


//エラーメッセージ格納用
$err_msg = [];

//バリデーションメッセージ
define('MSG_REQUIRED', '入力必須です。');
define('MSG_EMAIL_TYPE', 'Eメール形式で入力してください。');
define('MSG_EMAIL_DUP', 'そのEメールは既に登録されています。');
define('MSG_MIN', '5文字以上で入力してください。');
define('MSG_MAX', '文字以内で入力してください。');
define('MSG_FIXED', '文字で入力してください。');
define('MSG_HALF', '半角英数字で入力してください。');
define('MSG_SYS_ERROR', 'システムエラーが発生しました。しばらくお待ちください。');
define('MSG_NO_MATCH', 'Eメールアドレスまたはパスワードが間違っています。');
define('MSG_NO_MATCH_CURRENT_PASS', '現在のパスワードが違います。');
define('MSG_SAME_CURRENT_PASS', '現在のパスワードと同じです。');
define('MSG_RETYPE_NOT_MATCH', '再入力があっていません。');
define('MSG_EXPIRED', '有効期限切れです。');
define('MSG_AUTH_IS_INCORRECT', '認証キーが正しくありません。');
define('SUC_SENDED_MAIL', 'メールを送信しました。');


/**
 * 未入力チェック
 */
function validRequired($value, $key)
{
  if (empty($value)) {
    global $err_msg;
    $err_msg[$key] = MSG_REQUIRED;
  }
}

/**
 * 最大文字数チェック
 */
function validMaxLen($value, $key, $max = 256)
{
  if (mb_strlen($value) >= $max) {
    global $err_msg;
    $err_msg[$key] = $max . MSG_MAX;
  }
}

/**
 * 最小文字数チェック
 */
function validMinLen($value, $key)
{
  if (mb_strlen($value) < 5) {
    global $err_msg;
    $err_msg[$key] = MSG_MIN;
  }
}

/**
 * email形式チェック
 */
function validTypeEmail($value)
{
  if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $value)) {
    global $err_msg;
    $err_msg['email'] = MSG_EMAIL_TYPE;
  }
}

/**
 * email重複チェック
 */
function validEmailDup($email)
{
  $pdo = dbConnect();
  $sql = 'SELECT count(*) as count FROM users WHERE email = :email AND deleted_at IS NULL';
  $data = [
    ':email' => $email
  ];
  $stmt = queryPost($pdo, $sql, $data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if (intval($result['count']) > 0) {
    global $err_msg;
    $err_msg['email'] = MSG_EMAIL_DUP;
  }
}

/**
 * 半角英数字チェック
 */
function validHalf($value, $key)
{
  if (!preg_match("/^[a-zA-Z0-9]+$/", $value)) {
    global $err_msg;
    $err_msg[$key] = MSG_HALF;
  }
}

/**
 * パスワードチェック
 */
function validPass($value, $key)
{
  //最小文字数チェック
  validMinLen($value, $key);
  //最大文字数チェック
  validMaxLen($value, $key);
  //半角英数字チェック
  validHalf($value, $key);
}


/**
 * 入力内容が一致しているか確認
 */
function validMatch($value1, $value2, $key)
{
  global $err_msg;
  if ($value1 !== $value2) {
    return $err_msg[$key] = MSG_RETYPE_NOT_MATCH;
  }
}

/**
 * 固定長チェック
 */
function validLength($value, $key, $length = 8)
{
  if (mb_strlen($value) !== $length) {
    global $err_msg;
    $err_msg[$key] = $length . MSG_FIXED;
  }
}

/**
 * DB接続処理
 */
function dbConnect()
{
  try {
    $dsn = 'mysql:dbname=what_do_you_eat_today;host=localhost;charset=utf8mb4';
    $name = 'root';
    $password = 'root';
    $option = [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
    ];
    $pdo = new PDO($dsn, $name, $password, $option);
    return $pdo;
  } catch (PDOException $e) {
    error_log('システムエラー:' . $e->getMessage());
    global $err_msg;
    $err_msg['common'] = MSG_SYS_ERROR;
  }
}


/**
 * SQL実行処理
 */
function queryPost($pdo, $sql, $data = [])
{
  $stmt = $pdo->prepare($sql);
  $stmt->execute($data);

  return $stmt;
}

/**
 * ユーザー情報を取得
 */
function getUser($userId)
{
  try {

    debug('ユーザー情報を取得');
    $pdo = dbConnect();
    $sql = 'SELECT * FROM users WHERE id = :u_id AND deleted_at IS NULL';
    $data = [':u_id' => $userId];
    $stmt = queryPost($pdo, $sql, $data);

    if ($stmt) {
      debug('クエリに成功しました。');
    } else {
      debug('クエリに失敗しました。');
    }
  } catch (PDOException $e) {

    error_log('エラー発生:' . $e->getMessage());
    header('Location:login.php');
  }

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * フォーム入力保持, エラー時POSTの内容を保持する
 */
function getFormData($key)
{
  global $dbFormData;
  global $err_msg;

  if (!empty($dbFormData)) {
    //ユーザー情報があるとき
    if (!empty($err_msg[$key])) {

      //エラーがある時
      if (!empty($_POST[$key])) {

        //POSTの内容を表示
        return $_POST[$key];
      } else {

        //POSTが存在し、DBの情報と違うならPOSTの情報を表示する
        if (!empty($_POST[$key]) && $_POST[$key] !== $dbFormData[$key]) {

          return $_POST[$key];
        } else {

          //そもそも変更がない場合
          return $dbFormData[$key];
        }
      }
    } else {

      return $dbFormData[$key];
    }
  } else {
    //POSTがあるとき
    if (!empty($_POST[$key])) {
      return $_POST[$key];
    }
  }
}

/**
 * エラーメッセージ表示
 */
function getErrMsg($key)
{
  global $err_msg;

  if (!empty($err_msg[$key])) {
    return $err_msg[$key];
  }
}

/**
 * カテゴリーを取得する
 */
function getMainCategories()
{
  $pdo = dbConnect();
  $sql = 'SELECT id, name FROM food_categories WHERE deleted_at IS NULL';
  $stmt = queryPost($pdo, $sql);
  $mainCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
  debug('カテゴリーの中身:' . print_r($mainCategories, true));

  return $mainCategories;
}

/**
 * サブカテゴリーを取得する
 */
function getSubCategories()
{
  $pdo = dbConnect();
  $sql = 'SELECT id, name FROM food_sub_categories WHERE deleted_at IS NULL';
  $stmt = queryPost($pdo, $sql);
  $subCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
  debug('サブカテゴリーの中身:' . print_r($subCategories, true));

  return $subCategories;
}

/**
 * メール送信
 */
function sendMail($to, $subject, $message, $from)
{
  if (!empty($to) && !empty($subject) && !empty($message) && !empty($from)) {
    //使用言語の指定
    mb_language('Japanese');
    //文字コードの指定
    mb_internal_encoding('UTF-8');

    if (mb_send_mail($to, $subject, $message, 'From' . $from)) {
      //メール送信
      debug('メールが送信されました。');
    } else {
      debug('メールが送信されませんでした。');
    }
  }
}

/**
 * ランダムな文字列で認証キーを生成する
 */
function generateRandomAuthKey($length = 8)
{
  return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
}
