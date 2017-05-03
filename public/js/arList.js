var lIndex,
    lValue = '',
    pageObj     = {
        kwd : '',
        theToken : '',
        pageSize : 10,
        pageCount : 1 ,
        allNum : 0,
        typeObj : {
            0   : '文字',
            1   : '图片素材',
            2   : '文章素材',
            3   : '投票',
            4   : '图文消息'
        }
    };

//获取列表信息
pageObj.getPageInfo = function(kwd) {
    var _this = pageObj;

    _this.kwd = kwd || '';

    $.ajax({
        type    : 'post',
        url     : '/autoReply/getPageInfo',
        headers : {
            'X-CSRF-TOKEN'  : _this.theToken
        },
        data    : {
            kwd         : _this.kwd,
            pageSize    : _this.pageSize
        },
        success : function (res) {
            _this.allNum     = res.allNum;
            _this.pageCount  = Math.ceil(_this.allNum/(_this.pageSize)) + (_this.allNum === 0 ? 1 : 0);
            //加载列表
            _this.pageBar(1);
            _this.renderData(res.pageData);
        }
    });
};

//翻页工具条
pageObj.pageBar = function (pageId) {
    var sPage   = pageId - 2,
        ePage   = pageId + 2,
        pageBar =   '<a class="btn btn-sm btn-primary llPage" title="首页"><i class="fa fa-angle-double-left"></i></a>&nbsp;'+
                    '<a class="btn btn-sm btn-primary lPage" title="上一页"><i class="fa fa-angle-left"></i></a>&nbsp;';

    if(sPage < 1){
        sPage = 1;
        ePage += 2;
    }

    if(ePage > this.pageCount){
        ePage = this.pageCount;
    }

    for(var i=sPage;i<=ePage;i++){
        if(i === pageId){
            pageBar += '<a class="btn btn-sm btn-primary nowPage">'+i+'</a>&nbsp;';
        }else{
            pageBar += '<a class="btn btn-sm btn-primary">'+i+'</a>&nbsp;';
        }
    }

    pageBar +=  '<a class="btn btn-sm btn-primary rPage" title="下一页"><i class="fa fa-angle-right"></i></a>&nbsp;'+
                '<a class="btn btn-sm btn-primary rrPage" title="末页"><i class="fa fa-angle-double-right"></i></a>';

    $('.pageBar').html(pageBar);

    $('.pageBar > a').on('click',function () {
        var pNum = 1,
            nNum = +$('.nowPage').eq(0).text();

        if($(this).hasClass('llPage')){
            pNum = 1;
        }else if($(this).hasClass('lPage')){
            pNum = nNum - 1;
            if(pNum < 1) pNum = 1;
        }else if($(this).hasClass('rPage')){
            pNum = nNum + 1;
            if(pNum > pageObj.pageCount) pNum = pageObj.pageCount;
        }else if($(this).hasClass('rrPage')){
            pNum = pageObj.pageCount;
        }else{
            pNum = +$(this).text();
        }

        if(pNum === nNum) return false;

        pageObj.paging(pNum);
    });
};

//翻页
pageObj.paging = function (pageId) {
    var _this = pageObj;

    $.ajax({
        type    : 'post',
        url     : '/autoReply/getPaging',
        headers : {
            'X-CSRF-TOKEN'  : _this.theToken
        },
        data    : {
            kwd       : _this.kwd,
            pageSize  : _this.pageSize,
            pageId    : pageId
        },
        success : function (res) {
            _this.pageBar(pageId);
            _this.renderData(res.pageData);
        }
    });
};

//加载数据
pageObj.renderData = function (arr) {
    var data = '',
        _this = pageObj;

    for(var i=0;i<arr.length;i++){
        data += '<tr class="kwdList">'+
                    '<td class="text-center">'+
                        '<input type="checkbox" class="checkOne" data-id="'+arr[i].id+'">'+
                    '</td>'+
                    '<td class="text-center">'+
                        arr[i].keywords+
                    '</td>'+
                    '<td class="text-center">'+
                        _this.typeObj[arr[i].type]+
                    '</td>'+
                    '<td class="text-center">'+
                        arr[i].mTitle+
                    '</td>'+
                    '<td class="text-center votesOperation">'+
                        '<i class="fa fa-times arOperation" title="删除" data-id="'+arr[i].id+'"></i>'+
                    '</td>'+
                '</tr>';
    }

    $('.kwdList').remove();
    $('.table-hover > tbody').html(data);

    $('.arOperation').on('click',function () {
        delOp($(this).attr('data-id'));
    });
};

//初始化
$(function () {
    pageObj.theToken = $('#theToken').val();
    pageObj.getPageInfo();

    initFun();
});

function initFun() {
    //查询
    $('#kwdQuery').on('click',function () {
        var kwd = $('#keyword').val();

        pageObj.getPageInfo(kwd);
    });

    //全选
    $('.checkAll').on('click',function(){
       $('.checkOne').prop('checked',$(this).prop('checked'));
    });

    //删除
    $('#batchDel').on('click', function () {
        var arr = [];

        $('.checkOne').each(function(){
           if($(this).prop('checked')) arr.push($(this).attr('data-id'));
        });

        if(arr.length < 1){
            alert('请选择要删除的数据！');
            return false;
        }

        delOp(arr.join(','));
    });

    //添加
    $('#kwdAdd').on('click', function () {
        layer.open({
            type: 1,
            title: '添加自动回复',
            area: ['600px', '600px'],
            fixed: false,
            resize: false,
            content: '<div id="addDivContainer">' + $('#addDiv').html() + '</div>',
            success: function () {
                //绑定添加事件
                initAddFun();
            }
        });
    });
}

//绑定添加事件
function initAddFun() {
    $('#addDivContainer').find('#arType').on('change', typeChange);
    $('#addDivContainer').find('#arSelectBtn').on('click', materialSel);
    $('#addDivContainer').find('#addBtn').on('click', saveFun);
}

//回复类型切换
function typeChange() {
    var val = $(this).val();

    $('#addDivContainer').find('.form-group').each(function () {
        if(!$(this).hasClass('arType-all')){
            $(this).find('.form-control').val('');
        }

        if($(this).hasClass('arType-all') || $(this).hasClass('arType-' + val)){
            if($(this).hasClass('notShow')) $(this).removeClass('notShow');
        }else{
            $(this).addClass('notShow');
        }
    });
}

//素材选择
function materialSel() {
    var _this = pageObj;

    layer.open({
        type: 2,
        title: '素材选择',
        area: ['400px', '500px'],
        fixed: false,
        resize: false,
        content: '/autoReply/sel/' + $('#addDivContainer').find('#arType').val() + '<@>1',
        success: function (layero, index) {
            lIndex = index;
        }
    });
}

//关闭弹出层
function mOp()
{
    var arr = lValue.split('\2'),
        val = $('#addDivContainer').find('#arType').val();

    //不同类型，不同赋值
    switch (val){
        case '1':
            $('#addDivContainer').find('#arSelect').val(arr[0]);
            $('#addDivContainer').find('#arMtitle').val(arr[0]);
            $('#addDivContainer').find('#arContent').val(arr[1]);
            break;
        case '2':
            $('#addDivContainer').find('#arSelect').val(arr[0]);
            $('#addDivContainer').find('#arMtitle').val(arr[0]);
            $('#addDivContainer').find('#arContent').val(arr[1]);
            break;
        case '3':
            $('#addDivContainer').find('#arSelect').val(arr[0]);
            $('#addDivContainer').find('#arMurl').val(arr[1]);
            $('#addDivContainer').find('#arMimage').val(arr[2]);
            break;
    }

    //清空变量
    lValue = '';
    //关闭弹窗
    layer.close(lIndex);
}

//保存
function saveFun() {
    var flag = true;

    $('#addDivContainer').find('.form-control').each(function () {
        if(!$(this).val() && !$(this.parentNode.parentNode).hasClass('notShow')){
            if($(this).attr('id') === 'arSelect'){
                alert('请选择素材！');
            }else{
                alert('请填写' + $(this).attr('placeholder') + '！');
            }
            flag = false;
            return false;
        }
    });

    if(!flag) return false;

    $(this.parentNode).submit();
}

//删除
function delOp(ids){
    if(!confirm('确认删除所选数据吗？')) return false;

    var _this = pageObj;

    $.ajax({
        type    : 'post',
        url     : '/autoReply/del',
        headers : {
            'X-CSRF-TOKEN'  : _this.theToken
        },
        data    : {
            delIds : ids
        },
        success : function (res) {
            if(res.delRes > 0){
                alert('删除成功！');
                _this.getPageInfo();
            }else{
                alert('删除失败！');
            }
        }
    });
}