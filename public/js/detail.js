$(function () {
    initFun();
});

function initFun() {
    //详情展开和收起
    $('#detailOp').on('click', function () {
        if($(this).hasClass('fa-angle-double-down')){
            $(this).removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
            $('#detailDiv').removeClass('noShow');
        } else{
            $(this).removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            $('#detailDiv').addClass('noShow');
        }
    });
    
    //搜索
    $('#searchBtn').on('click',function () {
        $('#queryVal').val($('#searchVal').val());
        $('#searchForm').submit();
    });
    
    //投票
    $('.voteOpBtn').on('click', voteOp)
}

function voteOp() {
    $('#xsId').val($(this).attr('data-id'));
    $('#voteOpForm').submit();
}