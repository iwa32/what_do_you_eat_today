$(function () {
  var $footer = $('#globalFooter');

  if (window.innerHeight > $footer.offset().top + $footer.outerHeight()) {
    $footer.attr({
      'style': 'position:fixed; top:' + (window.innerHeight - $footer.outerHeight()) + 'px;'
    });
  }

  $('#firstSelect .eat-select__list').on('click', function() {
    $('#secondSelect').show(600);
    $('#firstSelect').hide(600);
  })

  $('#secondSelect .eat-select__list').on('click', function() {
    $('#mealSearchResult').show(600);
    $('#secondSelect').hide(600);
  })
})