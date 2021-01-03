<?php
require('function.php');

debug('「「「「「「「「「「「「「「「「');
debug('ログアウト処理開始');

session_destroy();
debug('ログアウトし、ログインページへ遷移します。');

header('Location:login.php');