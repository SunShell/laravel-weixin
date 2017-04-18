var um;

$(function () {
    um = UM.getEditor('detail',{
        toolbar : [
                'source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
                'insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize' ,
                '| justifyleft justifycenter justifyright justifyjustify |',
                'link unlink | horizontal preview fullscreen', 'drafts', 'formula'
        ],
        initialFrameHeight  : 240
    });

    $('#startTimeDiv').calendar({
        trigger: '#startTime',
        zIndex: 999
    });

    $('#endTimeDiv').calendar({
        trigger: '#endTime',
        zIndex: 999
    });

    $('#saveBtn').on('click', saveFun);
});

//提交表单
function saveFun() {
    /*var flag = true;

    $('.voteForm .form-control').each(function () {
        if($(this).attr('tip') != '' && $(this).val() == ''){
            alert($(this).attr('tip') + '为必填项！');

            flag = false;

            return false;
        }
    })

    if(!flag) return false;

    var stm = $('#startTime').val(),
        etm = $('#endTime').val();

    if(stm > etm){
        alert('开始时间不能大于结束时间！');
        return false;
    }

    if(!um.hasContents()){
        alert('请填写活动介绍！');
        return false;
    }*/

    $('.voteForm').submit();
}
