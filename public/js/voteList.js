$(function () {
    initFun();
});

function initFun(){
    //全选
    $('.checkAll').on('click', allSelect);
    //批量删除
    $('#batchDel').on('click', delOp);
    //单个删除
    $('.votesOperation .fa-times').on('click', delOp);
}

function allSelect() {
    $('.checkOne').prop('checked',$('.checkAll').prop('checked'));
}

//删除
function delOp(){
    var type = 'single',
        arr = [];

    if($(this).hasClass('btn-danger')) type = 'batch';

    if(type == 'batch'){
        $('.checkOne').each(function(){
            if($(this).prop('checked')){
                arr.push($(this).attr('data-id'));
            }
        });

        if(arr.length < 1){
            alert('请选择要删除的数据！');
            return false;
        }
    }else{
        arr.push($(this).attr('data-id'));
    }

    if(!confirm('删除后将无法恢复，确认删除所选数据吗？')) return false;

    $('#voteIds').val(arr.join(','));

    $('#delForm').submit();
}