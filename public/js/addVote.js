$(function () {
    $('#startTimeDiv').calendar({
        trigger: '#startTime',
        zIndex: 999
    });

    $('#endTimeDiv').calendar({
        trigger: '#endTime',
        zIndex: 999
    });

    $('#saveBtn').on('click', saveFun)
});

//提交方法
function saveFun() {

}