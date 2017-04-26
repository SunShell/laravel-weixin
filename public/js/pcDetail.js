$(function () {
    initFun();
});

function initFun() {
    $('#detailOp').on('click', function () {
       if($(this).hasClass('fa-angle-double-down')){
           $(this).removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
           $('#detailDiv').removeClass('noShow');
       } else{
           $(this).removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
           $('#detailDiv').addClass('noShow');
       }
    });

    $('#searchBtn').on('click',function () {
        $('.forClear').val('');
        $('#queryVal').val($('#searchVal').val());
        $('#searchForm').submit();
    });

    $('.voteOpBtn').on('click',function () {
        $('.forClear').val('');

        if($(this).find('i').hasClass('fa-thumbs-o-up')){
            var _this = this;
            layer.prompt({title: '请输入票数'}, function(val, index){
                if(!/^[0-9]*[1-9][0-9]*$/.test(val)){
                    alert('请输入正整数！');
                    return false;
                }
                $('#xsId').val($(_this).attr('data-id'));
                $('#voteNum').val(val);
                $('#searchForm').submit();
                layer.close(index);
            });
        }else{
            $('#checkId').val($(this).attr('data-id'));
            $('#searchForm').submit();
        }
    });

    $('.voteDelBtn').on('click',function () {
        $('.forClear').val('');
        if(!confirm('删除后不可恢复，确认删除该选手吗？')) return false;
        $('#delId').val($(this).attr('data-id'));
        $('#searchForm').submit();
    });

    $('#toRank').on('click', function () {
        layer.msg('加载中', {
            icon: 16,
            shade: 0.8
        });
    });
}