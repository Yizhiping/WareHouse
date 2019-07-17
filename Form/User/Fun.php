<form action="?act=user/fun" method="post" enctype="multipart/form-data" name="formFun" id="formFun">
    <div>
        <div class="divSearch">
            <label for="newFunName">新建功能:</label>
            <input type="text" name="newFunName" id="newFunName" />
            <input type="submit" name="btnCreateFun" id="btnCreateFun" value="創建功能" />
            <input type="submit" name="btnFunDel" id="btnFunDel" value="刪除選擇的功能" />
        </div>
        <div>
            <?php
            if(!$result)
            {
                echo "沒有數據可顯示.";
            } else {
                //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
                //表頭部分
                echo "<table class='resultTable'>";
                echo "<tr class='resultTitle'>";
                foreach (array('序號','代碼','功能名稱','') as $item) echo "<td>{$item}</td>";
                echo "</tr>";
                //表格部分
                $idx = 0;
                foreach ($result as $item)
                {
                    $idx++;
                    print "<tr class='resultContent selRow'>";
                    printf( "<td>%d</td>", $idx);
                    printf( "<td>%s</td>", $item['code']);
                    printf( "<td>%s</td>", $item['name']);
                    printf( "<td><input type='checkbox' name='FID_%s' class='clsSelPallet' value='%s'/></td>", $item['code'],$item['code']);
                    print "</tr>";
                }
                print "</table>";
            }
            ?>
        </div>
    </div>
</form>