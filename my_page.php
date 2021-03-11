<?php

require('function.php');
debug('「「「「「「「「「「「「「「');
debug('マイページ・お気に入りの飲食店');
debugLogStart();

require('auth.php');
$user = getUser($_SESSION['user_id']);
?>

<?php
$siteTitle = 'マイページ・お気に入りの飲食店';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>
  <?php
  $current = 'favorite';
  require('profile.php');
  ?>
  <div class="my-page__body">

    <div class="selected-genre">
      お気に入りの飲食店
      UIはトップページと同様に、お気に入り登録した飲食の検索結果を表示させる。
      情報はDBからidをもってきて、apiにリクエストするが、渡すidは一度に10レコード分までにしたいのでページネーション機能をつけて渡すidを動的に切り替えていく.
    </div>
  </div>
  </div>
  </div>
  </main>
  <?php require("footer.php") ?>