//チェックボックスをチェックすると、「入力内容を確認する」ボタンがactiveになる
$(function () {
  $('#submit').prop('disabled', true);

  $('#agree').on('click', function () {
    if ($(this).prop('checked') == false) {
      $('#submit').prop('disabled', true);
    } else {
      $('#submit').prop('disabled', false);
    }
  });
});
