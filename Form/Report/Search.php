<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/17
 * Time: 18:37
 */

?>

<div>
    <div>
        <table>
            <tr>
                <td>數據來源:</td>
                <td>
                    <select name="dataSource">
                        <?php
                            foreach (array('未出貨'=>'goods','已出貨'=>'goods_shipped') as $key=>$val)
                            {
                                $html = "<option value='%s'>%s</option>";
                                if($dateSource == $val) $html = "<option value='%s' selected='selected'>%s</option>";
                                printf($html, $val, $key);
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
    </div>
</div>
