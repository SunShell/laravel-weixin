$(function () {
    initFun();
});

function initFun() {
    //投票
    $('.voteOpBtn').on('click', voteOp)
}

function voteOp() {
    $('#xsId').val($(this).attr('data-id'));
    $('#voteOpForm').submit();
}