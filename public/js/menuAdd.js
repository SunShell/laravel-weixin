var lIndex,
    lValue = '';

$(function () {
    initFun();
});

function initFun() {
    //所属一级菜单显示和隐藏
    $('#menuLevel').on('change', function () {
        var val = $(this).val();

        if(val === '2'){
            $('.menuLevelOne').removeClass('notShow');
            $('#menuType').html('<option value="view">URL</option><option value="click">自动回复</option>');
        }else{
            $('.menuLevelOne').addClass('notShow');
            $('#menuType').html('<option value="parent">父菜单</option><option value="view">URL</option><option value="click">自动回复</option>');
        }

        //菜单类型切换
        changeMt();
    });

    //菜单类型切换
    $('#menuType').on('change', changeMt);

    //回复类型切换
    $('#arType').on('change', changeAt);

    //素材选择
    $('#arSelectBtn').on('click', materialSel);
    
    //保存
    $('#addBtn').on('click', saveFun);
}

//菜单类型切换
function changeMt() {
    var val = $('#menuType').val();

    $('.menuAddForm .form-group').each(function () {
        if($(this).hasClass('menuType-all')) return true;

        if($(this).hasClass('menuType-' + val)){
            $(this).removeClass('notShow');
        }else{
            $(this).addClass('notShow');
            $(this).find('.form-control').val('');
        }
    });

    if(val === 'click') changeAt();
}

//回复类型切换
function changeAt() {
    var val = $('#arType').val();

    $('.menuAddForm .form-group').each(function () {
        if($(this).hasClass('menuType-all') || $(this).hasClass('arType-all')) return true;

        if($(this).hasClass('arType-' + val)){
            $(this).removeClass('notShow');
        }else{
            $(this).addClass('notShow');
            $(this).find('.form-control').val('');
        }
    });
}

//素材选择
function materialSel() {
    layer.open({
        type: 2,
        title: '素材选择',
        area: ['400px', '500px'],
        fixed: false,
        resize: false,
        content: '/autoReply/sel/' + $('#arType').val() + '<@>1',
        success: function (layero, index) {
            lIndex = index;
        }
    });
}

//素材操作
function mOp() {
    var arr = lValue.split('\2'),
        val = $('#arType').val();

    //不同类型，不同赋值
    switch (val){
        case '1':
            $('#arSelect').val(arr[0]);
            $('#arMtitle').val(arr[0]);
            $('#arContent').val(arr[1]);
            break;
        case '2':
            $('#arSelect').val(arr[0]);
            $('#arMtitle').val(arr[0]);
            $('#arContent').val(arr[1]);
            break;
        case '3':
            $('#arSelect').val(arr[0]);
            $('#arMurl').val(arr[1]);
            $('#arMimage').val(arr[2]);
            break;
    }

    //清空变量
    lValue = '';
    //关闭弹窗
    layer.close(lIndex);
}

//保存操作
function saveFun() {
    var flag = true;

    $('.form-control').each(function(){
       if(!$(this).val() && !$(this.parentNode.parentNode).hasClass('notShow')){
           var tip = $(this).attr('placeholder');

           if(tip == '请选择'){
               alert('请选择素材！');
           }else{
               alert('请填写' + tip + '！');
           }

           flag = false;
           return false;
       }
    });

    if(!flag) return false;

    $('.custom-select').each(function(){
        if(!$(this).val() && !$(this.parentNode.parentNode).hasClass('notShow')){
            alert('请选择' + $(this).attr('tip') + '！');
            flag = false;
            return false;
        }
    });

    if(!flag) return false;

    if($('#menuType').val() === 'view') $('#arMtitle').val($('#menuContent').val());

    $.ajax({
        type    : 'post',
        url     : '/menuList/store',
        headers : {
            'X-CSRF-TOKEN'  : $('[name="_token"]').val()
        },
        data    : {
            menuName        : $('#menuName').val(),
            menuLevel       : $('#menuLevel').val(),
            levelOne        : $('#levelOne').val(),
            menuType        : $('#menuType').val(),
            menuContent     : $('#menuContent').val(),
            arType          : $('#arType').val(),
            arContent       : $('#arContent').val(),
            arMtitle        : $('#arMtitle').val(),
            arMdescription  : $('#arMdescription').val(),
            arMurl          : $('#arMurl').val(),
            arMimage        : $('#arMimage').val()
        },
        success : function (res) {
            alert(res.data);
            if(res.data.indexOf('成功') > -1) parent.lClose();
        }
    });
}