$(document).ready(function () {
    getAllPrice();
    $("#checkall").click(function () {
        if(this.checked ==  true){
            $('[type=checkbox]').prop('checked', true);
        }else{
            $('[type=checkbox]').prop('checked', false);
        }
        var checkedLen = $("input[type='checkbox'][name='check']:checked").length;
        $('.checked_num').text(checkedLen);        
        getAllPrice();
    });
    $(".son").click(function () {
        //总的checkbox的个数
        var len = $(".son").length;
        //已选中的checkbox的个数
        var checkedLen = $("input[type='checkbox'][name='check']:checked").length;
        $('.checked_num').text(checkedLen);
        if(len  ==  checkedLen){
            $('#checkall').prop('checked', true);
        }else{
            $('#checkall').prop('checked', false);
        }
        getAllPrice()
    });


});
function getAllPrice() {
    var s =  0.00;
    $("input[type='checkbox'][name='check']").each(function () {
        if(this.checked == true){
            var id = $(this).val();
            s += parseInt(id);
        }
    })
    $(".allprice").text(s);
}

// 删除购物车
function del(id){
    $.ajax({
        url:'./common/qajax.php?type=cart_del',
        data:{id:id},
        type:'post',
        dataType:'json',
        success:function(data){
            if(data.errno==1){
                console.log(data.error);
                //发异步删除数据
                $('.shop_goods').remove();
            }else{
                console.log(data.error);
                return false;
            }
        },
        error:function(e){
            console.log(e.responseText);
        }
    });
}

// 清空购物车
function cartempty(id){
    $.ajax({
        url:'./common/qajax.php?type=cart_empty',
        data:{id:id},
        type:'post',
        dataType:'json',
        success:function(data){
            if(data.errno==1){
                console.log(data.error);
                //发异步删除数据
                $('.shop_goods').remove();
            }else{
                console.log(data.error);
                return false;
            }
        },
        error:function(e){
            console.log(e.responseText);
        }
    });
}