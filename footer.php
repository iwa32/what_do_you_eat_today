<footer class="g-footer" id="globalFooter">
  <div class="g-footer__wrapp container">
    <small>Copyright &copy; 2020-2020 今日は何食べる？ All Rights Reserved.</small>
  </div>
</footer>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script>
  $(function() {
    var $footer = $('#globalFooter');

    if (window.innerHeight > $footer.offset().top + $footer.outerHeight()) {
      $footer.attr({'style': 'position:fixed; top:' + (window.innerHeight - $footer.outerHeight()) + 'px;'});
    }
  })
</script>
</body>

</html>