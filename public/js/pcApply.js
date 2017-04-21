$(function () {
    initFun();
});

function initFun() {
    $('#saveBtn').on('click', saveFun);
}

function saveFun() {
    var flag = true;

    $('.form-control').each(function () {
       if(!$(this).val()){
           if($(this).attr('id') === 'img'){
               alert('请上传'+$(this).attr('tip')+'！');
           }else{
               alert('请填写'+$(this).attr('tip')+'！');
           }

           flag = false;

           return false;
       }
    });

    if(!flag) return false;

    $('.voteApply').submit();
}