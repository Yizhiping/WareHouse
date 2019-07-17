<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/15
 * Time: 9:47
 */

?>
<form method="post" action="?act=goods/in" style="font-size: 1.5em;">
    <div>
        <table style="width: 100%;">
            <tr>
                <td colspan="2"><input type="submit" class="button" name="btnGoodIn" id="btnGoodsIn" value="<?php echo $shelfId=='NULL' ? "查詢->入庫" : "入庫" ?>" style="width: 100%;"></td>
            </tr>
            <tr>
                <td style="width: 20%;">輸入:</td>
                <td><input style="width: 100%;" type="text" class="input" name="isn" id="isn" value="<?php echo $isn?>"></td>

            </tr>
        </table>
    </div>
    <div><?php include("Form/goods/palletForm.php") ?></div>
    <div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 20%;">儲位:</td>
                <td style="width: 80%;">
                    <?php
                    if($isSuccess)
                    {
                        echo $shelfId;
                    } else {
                        echo '<select id="shelfId" name="shelfId" style="width: 100%;">';
                        echo '<option value="NULL">選擇儲位</option>';
                        foreach ($conn->getLine("select shelfId from shelfs order by ShelfID") as $item) {
                            echo "<option value='{$item}'>{$item}</option>";
                        }
                        echo '</select>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div style="font-size: 1.5em;
            margin-top: 10px;
            border: 1px solid #222;

            text-align: center;
            line-height: 1.5em;"><?php echo $message ?></div>
</form>