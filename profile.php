<?php
?>

<main class="contents">
  <div class="main-container container">
    <div class="my-page">
      <div class="my-page__header">
        <div class="profile-me">
          <div class="profile-me__main">
            <p class="profile-me__icon"><img src="<?php echo showImg(escape($user['my_icon'])); ?>"></p>

            <div class="profile-me__text">
              <p class="profile-me__name"><?php if (!empty($user['name'])) echo escape($user['name']); ?></p>
              <p class="profile-me__email"><?php if (!empty($user['email'])) echo escape($user['email']); ?></p>
            </div>
          </div>

          <p class="profile-me__message"><?php if (!empty($user['message'])) {
                                            echo escape($user['message']);
                                          } else {
                                            echo 'メッセージはありません。';
                                          } ?></p>

          <div class="profile-me__edit"><button class="edit-btn btn" id="toEditProfileBtn">プロフィールを編集</button>
            <button class="edit-btn btn" id="toEditPassBtn">パスワード変更</button>
          </div>
        </div>

        <ul class="my-page__nav">
          <li class="my-page__nav__link <?php echoCurrent('favorite', $current) ?>">
            <a href="./my_favorite.php">お気に入りの飲食店</a>
          </li>
          <li class="my-page__nav__link <?php echoCurrent('genre', $current) ?>"><a href="./my_page.php">ジャンルごとの食事回数</a></li>
          <li class="my-page__nav__link <?php echoCurrent('my_review', $current) ?>">
            <a href="">マイレビュー</a>
          </li>
          <li class="my-page__nav__link <?php echoCurrent('history', $current) ?>">
            <a href="./my_history.php">検索履歴</a>
          </li>
        </ul>
      </div>