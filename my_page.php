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
  <?php require('alert_msg.php'); ?>
  <?php
  $current = 'favorite';
  require('profile.php');
  ?>
  <div class="my-page__body">

    <div class="selected-genre">
    </div>
  </div>
  </div>
  </div>
  </main>
  <?php require("footer.php") ?>