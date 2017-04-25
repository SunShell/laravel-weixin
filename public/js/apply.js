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

    /*var arr = $('#img').val().split('.'),
        hzm = arr[arr.length-1].toLowerCase();

    if(['jpg','png','jpeg','gif','bmp'].indexOf(hzm) < 0){
        alert('请上传正确格式的图片文件！');
        return false;
    }*/

    $('.voteApply').submit();
}