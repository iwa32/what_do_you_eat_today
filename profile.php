<?php

require('function.php');
debug('「「「「「「「「「「「「「「');
debug('プロフィールページ');
debugLogStart();

require('auth.php');

$user = getUser($_SESSION['user_id']);

?>

<?php
$siteTitle = 'プロフィール';
require("head.php");;
?>

<body>
  <?php require("header.php");; ?>

  <main class="contents">
    <div class="main-container container">
      <div class="my-page">
        <div class="my-page__header">
          <div class="profile-me">
            <div class="profile-me__main">
              <p class="profile-me__icon"><img src="http://placehold.jp/120x120.png"></p>

              <div class="profile-me__text">
                <p class="profile-me__name"><?php if(!empty($user['name'])) echo $user['name']; ?></p>
                <p class="profile-me__email"><?php if(!empty($user['email'])) echo $user['email']; ?></p>
              </div>
            </div>

            <p class="profile-me__message"><?php if(!empty($user['message'])) {
              echo $user['message'];
            } else {
              echo 'メッセージはありません。';
            } ?></p>

            <div class="profile-me__edit"><button class="edit-btn btn" id="toEditProfileBtn">プロフィールを編集</button></div>
          </div>

          <ul class="my-page__nav">
            <li class="my-page__nav__link current"><a href="./my_page.php">ジャンルごとの食事回数</a></li>
            <li class="my-page__nav__link">
              <a href="">マイレビュー</a></li>
            <li class="my-page__nav__link">
              <a href="./my_favorite.php">お気に入りの飲食店</a></li>
            <li class="my-page__nav__link">
              <a href="./my_history.php">検索履歴</a></li>
          </ul>
        </div>