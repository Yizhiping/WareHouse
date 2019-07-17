<style>
    #palletForm {
        width: 100%;
    }

    #palletForm tr td {
        border-bottom: 1px solid #222;
    }

    #palletForm tr td input[type='text']{
        width: 100%;
        border: none;
    }

    #palletForm tr td:nth-child(1){
        width: 20%;
    }

    #palletForm tr td:nth-child(2){
        width: 80%;
        text-align: left;
    }


</style>

<table style="width: 100%;" id="palletForm">
    <tr>
        <td>條碼:</td>
        <td><input  name="sfisISN" id="sfisISN" type="text" readonly="readonly" value="<?php echo $sfisISN ?>"></td>
    </tr>
    <tr>
        <td>棧板:</td>
        <td><input  name="palletId" id="palletId" type="text" readonly="readonly" value="<?php echo $palletId ?>"></td>
    </tr>
    <tr>
        <td>機種:</td>
        <td><input  name="model" id="model" type="text" readonly="readonly" value="<?php echo $model ?>"></td>
    </tr>
    <tr>
        <td>訂單:</td>
        <td><input  name="so" id="so" type="text" readonly="readonly" value="<?php echo $so ?>"></td>
    </tr>
    <tr>
        <td>料號:</td>
        <td><input name="item" id="item" type="text" readonly="readonly" value="<?php echo $item ?>"></td>
    </tr>
    <tr>
        <td>數量:</td>
        <td><input name="qty" id="qty" type="text" readonly="readonly" value="<?php echo $qty ?>"></td>
    </tr>
</table>
