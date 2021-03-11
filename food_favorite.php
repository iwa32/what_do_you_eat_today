<?php

require('function.php');
debug('「「「「「「「「「「「「「「');
debug('お気に入り登録');
debugLogStart();

if (!empty($_POST) && isset($_SESSION['user_id'])) {
  debug('POST送信あり、ユーザー認証あり。');
  $foodId = escape($_POST['food_id']);
  //お気に入り状態フラグ,trueならお気に入りとして扱う
  $isFavorite = false;

  try {
    $pdo = dbConnect();
    $sql1 = 'SELECT * FROM favorite_foods WHERE user_id = :u_id AND food_id = :f_id';
    $data = [
      ':u_id' => $_SESSION['user_id'],
      ':f_id' => $foodId
    ];
    $stmt = queryPost($pdo, $sql1, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
      //あれば更新
      debug('お気に入りデータ登録済み' . print_r($result, true));

      if(!empty($result['deleted_at'])) {
        //削除(解除)されていたら登録し直す
        debug('お気に入り登録します。');
        $sql2 = "UPDATE favorite_foods SET deleted_at = NULL, updated_at = now() WHERE user_id = :u_id AND food_id = :f_id";
        queryPost($pdo, $sql2, $data);
        $isFavorite = true;
      } else {

        debug('お気に入り解除します。');
        $sql3 = "UPDATE favorite_foods SET deleted_at = now(), updated_at = now() WHERE user_id = :u_id AND food_id = :f_id";
        queryPost($pdo, $sql3, $data);
        $isFavorite = false;//初期値はfalseだがわかりやすくするため再代入
      }
    } else {
      //お気に入りとして登録
      debug('お気に入りとしてデータ作成、登録します。');
      $sql4 = 'INSERT INTO favorite_foods(user_id, food_id, created_at, updated_at) VALUES(:u_id, :f_id, now(), now())';
      queryPost($pdo, $sql4, $data);
      $isFavorite = true;
    }

    $returnData = [
      'status' => 201,
      'isFavorite' => $isFavorite,
      'message' => 'お気に入り登録を行いました。'
    ];

  } catch (Exception $e) {
    error_log("エラー発生" . $e->getMessage());
    $returnData = [
      'status' => 500,
      'message' => $e->getMessage()
    ];
  }
  header("Content-type: application/json; charset=UTF-8");
  echo json_encode($returnData);
  exit;

} else {
  //ユーザー登録する必要があります。
  $returnData = [];
  header("Content-type: application/json; charset=UTF-8");
  echo json_encode($returnData);
  exit;
}