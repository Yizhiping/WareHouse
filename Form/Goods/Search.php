<?php
/**
 * Created by PhpStorm.
 * User: Ping_
 * Date: 2019/6/11
 * Time: 22:13
 */

?>

<div class="divSearch">
    <form id="formSearch" name="formSearch" method="post" action="?act=goods/search">
        <label for="searchType">類型</label>
        <select name="searchType" id="searchType">
            <?php
                foreach (array('儲位'=>'shelf','訂單'=>'so','棧板'=>'pallet') as $key=>$val)
                {
                    $html = "<option value='{$val}'>{$key}</option>";
                    if($searchType == $val)  $html = "<option value='{$val}' selected='selected'>{$key}</option>";
                    print $html;
                }
            ?>
        </select>
        <label for="iptSearch">内容</label>
        <input type="text" name="isn" id="iptSearch" value="<?php echo $isn ?>" />
        <input type="submit" name="btnSearch" id="btnSearch" value="查詢">
    </form>
</div>
<div class="divResult">
    <?php
    if(!$result)
    {
        echo "沒有數據可顯示.";
    } else {
        //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
        //表頭部分
        echo "<table class='resultTable'>";
        echo "<tr class='resultTitle'>";
        foreach (array('序號','儲位','棧板號','機種','料號','訂單','數量') as $item) echo "<td>{$item}</td>";
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
            printf( "<td>%s</td>", $item['model']);
            printf( "<td>%s</td>", $item['item']);
            printf( "<td>%s</td>", $item['so']);
            printf( "<td>%s</td>", $item['qty']);
//            printf( "<td><input type='checkbox' name='PID_%s' class='clsSelPallet' value='%s'/></td>", $item['palletId'],$item['palletId']);
            print "</tr>";
        }
        print "</table>";
    }
    ?>
</div>