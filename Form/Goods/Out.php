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
                $('.clsSelPallet').parent('td').parent('tr').children().css('background','#ccc');
            }
        });

        $('.palletRow').click(function () {                 //單行選中或取消, 及顏色變化
            var thisChk = $(this).children('td').children('input');
            if(thisChk.is(':checked'))
            {
                $(this).children('td').css('background','#ccc');
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
<style>
    .palletRow:hover td{
        background-color: #ffccff;
        cursor: pointer;
    }

    .palletRow td {
        background-color: #ccc;
        text-align: center;
        padding: 0 0.5em 0;
        height: 1.5em;
    }

    .palletTitle td {
        background-color: #222;
        text-align: center;
        color: #fff;
        height: 2em;
        padding: 0 0.5em 0;
    }

</style>
<form method="post" action="?act=goods/out">
    <div style="border-bottom: 1px solid #222; padding: 5px 0 5px;">
        <lable for="opType">方式:</lable>
        <select name="opType" id="opType">
            <?php
                foreach (array('棧板'=>'pallet','儲位'=>'shelf','訂單'=>'so') as $key=>$val)
                {
                    $html = "<option value='{$val}'>{$key}</option>";
                    if($opType == $val) $html = "<option value='{$val}' selected='selected'>{$key}</option>";
                    echo $html;
                }
            ?>
        </select>
        <label for="isn">查詢內容:</label>
        <input type="text" name="isn" id="isn" value="<?php echo $isn ?>" class="input" />
        <input  type="submit" name="btnGoodsSearch" id="btnGoodSearch" class="button" value="查詢" />
        <input  type="submit" name="btnGoodsOut" id="btnGoodsOut" class="button" value="出貨" />
        <input  type="button" name="btnShowShelfChange" id="btnShowShelfChange" class="button" value="顯示新儲位" />
    </div>
    <div id="divNewShelfId" style="border-bottom: 1px solid #222; padding: 5px 0 5px;display: none;">
        <label for="newShelfId">新儲位:</label>
        <select id="newShelfId" name="newShelfId">
            <option value="NULL">選擇儲位</option>
            <?php
                foreach ($conn->getLine("select shelfId from shelfs order by ShelfID") as $item)
                {
                    printf("<option value='%s'>%s</option>" , $item , $item);
                }
            ?>
        </select>
        <input  type="submit" name="btnGoodsChange" id="btnGoodsChange" class="button" value="變更儲位" />
    </div>
    <div>
        <?php
            if(!$result)
            {
                echo "沒有數據可顯示.";
            } else {
                //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
                //表頭部分
                echo "<table>";
                echo "<tr class='palletTitle'>";
                foreach (array('序號','儲位','棧板號','機種','料號','訂單','數量') as $item) echo "<td>{$item}</td>";
                echo "<td><input type='checkbox' id='selAll'/></td>";
                echo "</tr>";
                //表格部分
                $idx = 0;
                foreach ($result as $item)
                {
                    $idx++;
                    print "<tr class='palletRow'>";
                    printf( "<td>%d</td>", $idx);
                    printf( "<td>%s</td>", $item['shelfId']);
                    printf( "<td>%s</td>", $item['palletId']);
                    printf( "<td>%s</td>", $item['model']);
                    printf( "<td>%s</td>", $item['item']);
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