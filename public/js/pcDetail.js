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
        $('#queryVal').val($('#searchVal').val());
        $('#searchForm').submit();
    });

    $('.voteOpBtn').on('click',function () {
        if($(this).find('i').hasClass('fa-thumbs-o-up')) return false;

        $('#checkId').val($(this).attr('data-id'));
        $('#searchForm').submit();
    });
}