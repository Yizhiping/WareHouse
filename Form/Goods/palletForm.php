<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/15
 * Time: 9:42
 */

?>

<table>
    <tr>
        <td>SFIS條碼:</td>
        <td><input  name="sfisISN" id="sfisISN" type="text" readonly="readonly" value="<?php echo $sfisISN ?>"></td>
    </tr>
    <tr>
        <td>棧板編號:</td>
        <td><input  name="palletId" id="palletId" type="text" readonly="readonly" value="<?php echo $palletId ?>"></td>
    </tr>
    <tr>
        <td>機種名稱:</td>
        <td><input  name="model" id="model" type="text" readonly="readonly" value="<?php echo $model ?>"></td>
    </tr>
    <tr>
        <td>訂單編號:</td>
        <td><input  name="so" id="so" type="text" readonly="readonly" value="<?php echo $so ?>"></td>
    </tr>
    <tr>
        <td>機種料號:</td>
        <td><input name="item" id="item" type="text" readonly="readonly" value="<?php echo $item ?>"></td>
    </tr>
    <tr>
        <td>棧板數量:</td>
        <td><input name="qty" id="qty" type="text" readonly="readonly" value="<?php echo $qty ?>"></td>
    </tr>
</table>
