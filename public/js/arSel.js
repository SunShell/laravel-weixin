//初始化
$(function () {
    initFun();
});

function initFun() {
    $('.btnSel').on('click', function () {
        parent.lValue = $(this).attr('data-str');
        parent.mOp();
    });
}