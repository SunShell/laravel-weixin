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

    var arr = $('#img').val().split('.');

    if(['jpg','png','jpeg','gif','bmp'].indexOf(arr[arr.length-1]) === -1){
        alert('请上传图片文件！');
        return false;
    }

    $('.voteApply').submit();
}