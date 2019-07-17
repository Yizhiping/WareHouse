<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/15
 * Time: 16:15
 */

?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#selAll').click(function () {                   //全部選中或不選, 及顏色變化
            if($(this).is(':checked')) {
                $('.clsSelPallet').prop('checked',true);
                $('.clsSelPallet').parent('td').parent('tr').children().css('background','#33ff33');
            } else {
                $('.clsSelPallet').prop('checked',false);
                $('.clsSelPallet').parent('td').parent('tr').children().css('background','none');
            }
        });

        $('.palletRow').click(function () {                 //單行選中或取消, 及顏色變化
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


        $('#btnShowShelfChange').click(function () {
            if($('#divNewShelfId').is(':hidden'))
            {
                $('#divNewShelfId').show();
                $(this).val('隱藏新儲位');
            } else {
                $('#divNewShelfId').hide();
                $(this).val('顯示新儲位');
            }
        });
    });
</script>

<form method="post" action="?act=goods/out">
    <div style="border-bottom: 1px solid #222; padding: 5px 0 5px; font-size: 1.5em;" >
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%;"><input style="width: 100%" type="submit" name="btnGoodsSearch" id="btnGoodSearch" class="button" value="查詢" /></td>
                <td style="width: 33%;"><input style="width: 100%" type="submit" name="btnGoodsOut" id="btnGoodsOut" class="button" value="出貨" /></td>
                <td style="width: 33%;"><input style="width: 100%" type="button" name="btnShowShelfChange" id="btnShowShelfChange" class="button" value="顯示新儲位" /></td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width: 15%;">條碼:</td>
                <td colspan="3"><input style="width: 100%;" type="text" name="scanISN" id="isn" value="<?php print $scanISN ?>" class="input" /></td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width: 15%;">方式:</td>
                <td>
                    <select name="opType" id="opType" style="width: 100%;" class="selBlur">
                        <?php
                        foreach (array('棧板'=>'pallet','儲位'=>'shelf','訂單'=>'so') as $key=>$val)
                        {
                            $html = "<option value='{$val}'>{$key}</option>";
                            if($opType == $val) $html = "<option value='{$val}' selected='selected'>{$key}</option>";
                            print $html;
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>內容:</td>
                <td><input type="text" name="isn" id="isnAAA" value="<?php print $isn ?>" class="input" style="width: 100%;"/></td>
            </tr>
        </table>
    </div>
    <div id="divNewShelfId" style="border-bottom: 1px solid #222; padding: 5px 0 5px;display: none;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 20%;">新儲位:</td>
                <td style="width: 40%;">
                    <select id="newShelfId" name="newShelfId" style="width: 100%;">
                        <option value="NULL">選擇儲位</option>
                        <?php
                        foreach ($conn->getLine("select shelfId from shelfs order by ShelfID") as $item)
                        {
                            printf("<option value='%s'>%s</option>" , $item , $item);
                        }
                        ?>
                    </select>
                </td>
                <td style="width: 40%;"><input style="width: 100%;" type="submit" name="btnGoodsChange" id="btnGoodsChange" class="button" value="變更儲位" /></td>
            </tr>
        </table>
    </div>
    <div>
        <?php
        if(!$result)
        {
            print "沒有數據可顯示.";
        } else {
            //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
            //表頭部分
            print "<table class='resultTable' style='width: 100%;'>";
            print "<tr class='resultTitle'>";
            foreach (array('序號','儲位','棧板號',/*'機種','料號',*/'訂單','數量') as $item) print "<td>{$item}</td>";
            print "<td><input type='checkbox' id='selAll'/></td>";
            print "</tr>";
            //表格部分
            $idx = 0;
            foreach ($result as $item)
            {
                $idx++;
                print "<tr class='palletRow resultContent'>";
                printf( "<td>%d</td>", $idx);
                printf( "<td>%s</td>", $item['shelfId']);
                printf( "<td>%s</td>", $item['palletId']);
//                printf( "<td>%s</td>", $item['model']);
//                printf( "<td>%s</td>", $item['item']);
                printf( "<td>%s</td>", $item['so']);
                printf( "<td>%s</td>", $item['qty']);
                printf( "<td><input type='checkbox' name='PID_%s' class='clsSelPallet' value='%s'/></td>", $item['palletId'],$item['palletId']);
                print "</tr>";
            }
            print "</table>";
        }
        ?>
    </div>
</form>