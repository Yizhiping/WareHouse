$(document).ready(function () {
    //id為isn的元素在頁面被加載的時候被選中
    $('#isn').focus().select();

    $('input[class=input]').click(function () {
        $(this).val("");
        $(this).focus();
    });

    //窗口自動高度
    $(window).resize(function () {

        var h = window.innerHeight
            || document.documentElement.clientHeight
            || document.body.clientHeight;

        var w = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        $('#main').height(h-50-20);

        if(w < 320){
            $('#Container').width(320);
        }
    });
    $(window).resize();

    $('.selRow').click(function () {                 //單行選中或取消, 及顏色變化
        var thisChk = $(this).children('td').children('input');
        if(thisChk.is(':checked'))
        {
            $(this).children('td').css('background','none');
            thisChk.prop('checked',false)
        } else {
            $(this).children('td').css('background','#33ff33');
            thisChk.prop('checked',true);
        }
    });

    $('.selBlur').blur(function () {
        $('#isn').val('').focus();
    });

    $('.selBlur').change(function () {
        $('#isn').val('').focus();
    });
});