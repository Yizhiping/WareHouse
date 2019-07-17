<?php
/**
 * Created by PhpStorm.
 * User: Ping_
 * Date: 2019/6/11
 * Time: 22:13
 */

?>

<div class="divSearch" style="font-size: 1.5em;">
    <form id="formSearch" name="formSearch" method="post" action="?act=goods/search">
        <table style="width: 100%;">
            <td colspan="4"><input type="submit" name="btnSearch" id="btnSearch" value="查詢" style="width: 100%;"></td>
            <tr>
                <td style="width: 15%;">條碼:</td>
                <td colspan="3"><input style="width: 100%;" type="text" name="scanISN" id="isn" value="<?php print $scanISN ?>" class="input"  /></td>
            </tr>
            <tr>
                <td style="width: 15%;">類型:</td>
                <td >
                    <select name="searchType" id="searchType"style="width: 100%;" class="selBlur">
                        <?php
                        foreach (array('儲位'=>'shelf','訂單'=>'so','棧板'=>'pallet') as $key=>$val)
                        {
                            $html = "<option value='{$val}'>{$key}</option>";
                            if($searchType == $val)  $html = "<option value='{$val}' selected='selected'>{$key}</option>";
                            print $html;
                        }
                        ?>
                    </select>
                </td>
                <tr>
                <td style="width: 15%;">內容:</td>
                <td ><input style="width: 100%;" type="text" name="isn" id="isnAAA" value="<?php echo $isn ?>" class="input" /></td>
            </tr>

            </tr>
        </table>
    </form>
</div>
<div class="divResult" style="font-size: 1em;">
    <?php
    if(!$result)
    {
        echo "沒有數據可顯示.";
    } else {
        //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
        //表頭部分
        echo "<table class='resultTable' style='width: 100%;'>";
        echo "<tr class='resultTitle'>";
        foreach (array('序號','儲位','棧板號',/*'機種','料號',*/'訂單','數量') as $item) echo "<td>{$item}</td>";
//        echo "<td><input type='checkbox' id='selAll'/></td>";
        echo "</tr>";
        //表格部分
        $idx = 0;
        foreach ($result as $item)
        {
            $idx++;
            print "<tr class='resultContent'>";
            printf( "<td>%d</td>", $idx);
            printf( "<td>%s</td>", $item['shelfId']);
            printf( "<td>%s</td>", $item['palletId']);
//            printf( "<td>%s</td>", $item['model']);
//            printf( "<td>%s</td>", $item['item']);
            printf( "<td>%s</td>", $item['so']);
            printf( "<td>%s</td>", $item['qty']);
//            printf( "<td><input type='checkbox' name='PID_%s' class='clsSelPallet' value='%s'/></td>", $item['palletId'],$item['palletId']);
            print "</tr>";
        }
        print "</table>";
    }
    ?>
</div>