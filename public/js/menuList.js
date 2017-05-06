var lIndex,
    tokenVal = '';

$(function () {
    tokenVal = $('[name="_token"]').val();
    initFun();
});

function initFun() {
    $('#menuAdd').on('click', menuAdd);
    $('#menuClear').on('click', menuClear);
    $('#updateMenu').on('click', updateMenu);
    $('#dropMenu').on('click', dropMenu);
    getMenuData();
}

function menuAdd() {
    layer.open({
        type: 2,
        title: '添加菜单',
        area: ['500px', '600px'],
        fixed: false,
        resize: false,
        content: '/menuList/add',
        success: function (layero, index) {
            lIndex = index;
        }
    });
}

function menuClear() {
    if(!confirm('该操作不可恢复，确认清空自定义菜单吗？')) return false;

    $.ajax({
        type    : 'post',
        url     : '/menuList/clearMenu',
        headers : {
            'X-CSRF-TOKEN'  : tokenVal
        },
        data    : {},
        success : function (res) {
            alert('清空' + res.data + '！');
            if(res.data.indexOf('成功') > -1) getMenuData();
        }
    });
}

function updateMenu() {
    var treeObj = $.fn.zTree.getZTreeObj("menuTree"),
        nodes   = treeObj.getNodes();

    if(!nodes[0].children){
        alert('自定义菜单为空，无法更新！');
        return false;
    }

    if(!confirm('更新操作会将原来的菜单替换为当前设置的菜单，确认更新菜单吗？')) return false;

    $.ajax({
        type    : 'post',
        url     : '/menuList/updateMenu',
        headers : {
            'X-CSRF-TOKEN'  : tokenVal
        },
        data    : {},
        success : function (res) {
            alert('更新' + res.data + '！');

            if(res.data.indexOf('成功') > -1){
                $('#updateTime').html(res.updateTime);
            }
        }
    });
}

function dropMenu() {
    if(!confirm('确认删除公众平台已配置的自定义菜单吗？')) return false;

    $.ajax({
        type    : 'post',
        url     : '/menuList/dropMenu',
        headers : {
            'X-CSRF-TOKEN'  : tokenVal
        },
        data    : {},
        success : function (res) {
            alert('删除' + res.data + '！');

            if(res.data.indexOf('成功') > -1){
                $('#updateTime').html(res.updateTime);
            }
        }
    });
}

function lClose() {
    layer.close(lIndex);
    getMenuData();
}

function getMenuData() {
    $.ajax({
        type    : 'post',
        url     : '/menuList/getMenu',
        headers : {
            'X-CSRF-TOKEN'  : tokenVal
        },
        data    : {},
        success : function (res) {
            var arr = res.data,
                brr = [];

            $(arr).each(function () {
                brr.push({
                    id      : this.nodeId,
                    pId     : this.parentId,
                    name    : this.name,
                    open    : this.parentId === 'root' ? true : false
                });
            });

            initTree(brr);
        }
    });
}

function initTree(treeData) {
    var setting = {
        data: {
            simpleData: {
                enable: true
            }
        },
        view: {
            showIcon: false,
            dblClickExpand : false
        },
        callback: {
            onClick: showMenu
        }
    };

    treeData.push({ id : 'root', pId : 0, name :"自定义菜单", open : true });

    $("#menuTree").html('');
    $('.menuContainerRight').html('');

    $.fn.zTree.init($("#menuTree"), setting, treeData);
}

function showMenu(event, treeId, treeNode) {
    $('.menuContainerRight').html('');

    if(treeNode.id === 'root') return false;

    $.ajax({
        type    : 'post',
        url     : '/menuList/getOneMenu',
        headers : {
            'X-CSRF-TOKEN'  : tokenVal
        },
        data    : {
            nodeId : treeNode.id
        },
        success : function (res) {
            renderDetail(res.data);
        }
    });
}

function renderDetail(obj) {
    var html = '<ul class="list-group">';

    html += '<li class="list-group-item">菜单名称：' + obj.name + '</li>'+
            '<li class="list-group-item">菜单级别：' + (obj.parentId === 'root' ? '一级' : '二级') + '</li>'+
            '<li class="list-group-item">菜单类型：' + getMenuType(obj.type,obj.arType) + '</li>';

    if(obj.parentId !== 'root'){
        html += '<li class="list-group-item">菜单内容：' + obj.mTitle + '</li>';
    }

    html += '<li class="list-group-item"><button id="menuDel" class="btn btn-sm btn-danger" data-id="'+obj.nodeId+'">删除</button></li>'+
            '</ul>';

    $('.menuContainerRight').html(html);

    //单个删除
    $('#menuDel').on('click', function () {
        if(!confirm('确认删除该菜单吗？如果删除父菜单会同时删除该菜单下的子菜单！')) return false;

        $.ajax({
            type    : 'post',
            url     : '/menuList/delOneMenu',
            headers : {
                'X-CSRF-TOKEN'  : tokenVal
            },
            data    : {
                nodeId : $(this).attr('data-id')
            },
            success : function (res) {
                if(res.data > 0){
                    alert('删除成功！');
                }else{
                    alert('删除失败！');
                }

                getMenuData();
            }
        });
    });
}

function getMenuType(aType,bType) {
    var val = '',
        obj = {
            'parent'    : '父菜单',
            'view'      : 'URL链接',
            'media_id'  : '自动回复',
            'click'     : '自动回复'
        },
        aro = {
            '0' : '文字',
            '1' : '素材图片',
            '2' : '素材文章',
            '3' : '投票',
            '4' : '图文消息'
        };

    val = obj[aType];

    if(aType === 'click' || aType === 'media_id') val += '-' + aro[bType];

    return val;
}