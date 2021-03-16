<footer class="g-footer" id="globalFooter">
  <div class="g-footer__wrapp container">
    <small>Copyright &copy; 2020-2020 今日は何食べる？<br class="sp-on"> All Rights Reserved.</small>
  </div>
</footer>
<script src="http://maps.google.com/maps/api/js?key={API_KEY}&libraries=places&language=ja"></script>
<script src = "./node_modules/jquery/dist/jquery.js"></script>
<script>
  //お気に入り登録時とお気に入りアイコン表示の有無のために使用する
  var userId = '<?php echo (!empty($_SESSION['user_id'])) ? $_SESSION['user_id']: ''; ?>';
</script>
<script src="./js/index.js"></script>
<script src="./js/const.js"></script>
<script src="./js/function.js"></script>
</body>
</html>