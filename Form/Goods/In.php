<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/15
 * Time: 9:47
 */

?>
<form method="post" action="?act=goods/in">
    <div>
        <table>
            <tr>
                <td>條碼:</td>
                <td><input type="text" class="input" name="isn" id="isn" value="<?php echo $isn?>"></td>
                <td><input type="submit" class="button" name="btnGoodIn" id="btnGoodsIn" value="<?php echo $shelfId=='NULL' ? "查詢->入庫" : "入庫" ?>"></td>
            </tr>
        </table>
    </div>
    <div><?php include("Form/goods/palletForm.php") ?></div>
    <div>
        入庫儲位:
            <?php
                if($isSuccess)
                {
                    echo $shelfId;
                } else {
                    echo '<select id="shelfId" name="shelfId" >';
                    echo '<option value="NULL">選擇庫位</option>';
                    foreach ($conn->getLine("select shelfId from shelfs order by ShelfID") as $item) {
                        echo "<option value='{$item}'>{$item}</option>";
                    }
                    echo '</select>';
                }
            ?>

    </div>
    <div style="text-align: center; font-size: 1.5em; border: 1px solid"><?php echo $message ?></div>
</form>
