
$(".check").on("click", function(){
    $('.check').prop('checked', false);  //  全部のチェックを外す
    $(this).prop('checked', true);  //  押したやつだけチェックつける
    $('.label').removeClass('active');  //  クラスを取り除いて色を抜く
    $(this).next('.label').addClass('active');//  選択状態の色を変える
});

