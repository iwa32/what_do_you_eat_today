<header class="g-header">
  <div class="g-header__wrapp container">
    <h1 class="g-header__logo"><a href="./">今日は何食べる？</a></h1>
    <nav class="g-header__nav">
      <ul>
      <?php
      if (empty($_SESSION['user_id'])) {
      ?>
        <li><a href="./login.php">ログイン</a></li>
        <li><a href="./signup.php">ユーザー登録</a></li>
      <?php
      } else {
      ?>
        <li><a href="./my_page.php">マイページ</a></li>
        <li><a href="./logout.php">ログアウト</a></li>
      <?php } ?>
      </ul>
    </nav>
  </div>
</header>