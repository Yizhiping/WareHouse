<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/13
 * Time: 13:19
 */
require_once "Libs/WebService.php";     //WebService庫
require_once "Libs/Goods.php";          //貨物庫

//定義變量
$palletInfoStr = '';
$isn = $sfisISN = $item = $pallet = $so = $qty = $model = null;
$shelfId = __get('shelfId');    //儲位ID
$existShelfid = false;      //已經存在的儲位ID
$isn = __get('isn');
$newShelfId = __get('newShelfId');
$goods = new Goods();
$palletInfo = $goods->samplePalletInfo;

//查詢輸入條碼的產品信息
if(!empty(__get('btnSearch')))
{
    if(strlen($isn) == 0)
    {
        __showMsg('查詢條件為空.');
    } else {
        $sfis = new SFIS($device, $opid);
        if($sfisISN = $sfis->getSFISISN($isn))      //查詢輸入內容的SFISISN
        {
            if($palletInfo = $sfis->getPalletInfoByIsn($sfisISN))
            {
                $pallet = $palletInfo['pallet'];
                $model  = $palletInfo['model'];
                $so     = $palletInfo['so'];
                $qty    = $palletInfo['qty'];
                $item   = $palletInfo['item'];
                $existShelfid = $conn->getLine("select shelfId from Goods where SO='{$so}' group by ShelfId");
            } else {
                __showMsg('無法查詢到輸入條碼的棧板信息, 請確認.');
            }
        }else {
            __showMsg('搜索結果為空, 請檢查輸入的條碼是否正確.');
        }
    }
} else {
    $pallet = __get('pallet');
    $model  = __get('model');
    $so     = __get('so');
    $qty    = __get('qty');
    $item   = __get('item');
}

//入庫
if(!empty(__get('btnGoodsIn')))
{
    //如果儲位名稱不是newShelfId, 說明選擇的是已有的儲位, 否則讀取newShelfId
    $shelfId = __get('shelfId');
    if($shelfId == 'newShelfId')
    {
        $shelfId = __get('newShelfId');
    }

    //判斷一下儲位ID, 如果為null說明沒有進行選擇.
    if(strlen($shelfId) == 7)
    {
        $palletInfo['palletId'] = $pallet;
        $palletInfo['model']    = $model;
        $palletInfo['item']     = $item;
        $palletInfo['so']       = $so;
        $palletInfo['qty']      = $qty;
        $palletInfo['customer'] = null;
        $palletInfo['shelfId']  = $shelfId;
        $palletInfo['uid']      = $user->uid;

        if($goods->putGoods($palletInfo))
        {
            __showMsg('棧板入庫成功');
        } else {
            __showMsg('棧板入賬失敗' . $conn->getErr());
        }

        //無論入庫成功與否, 都清空資料, 防止錯誤.
        $pallet = $model = $item = $so = $shelfId = $qty = $newShelfId = null;
        $existShelfid = false;
    } else {
        __showMsg('資料格式不正確,請確認儲位是否選擇好.');
        $pallet = $model = $item = $so = $shelfId = $qty = $newShelfId = null;
        $existShelfid = false;
    }
}

//生成棧板信息的html
if(true)
{
    $palletInfoStr .= "<lable for='pallet'>棧板編號:</lable><input name='pallet' value='{$pallet}' id='pallet' type='text' readonly='readonly'/>" . EOL;
    $palletInfoStr .= "<lable for='model'>機種名稱:</lable><input name='model' value='{$model}' id='model' type='text' readonly='readonly' />" . EOL;
    $palletInfoStr .= "<lable for='so'>訂單編號:</lable><input name='so' value='{$so}' id='so' type='text' readonly='readonly' />" . EOL;
    $palletInfoStr .= "<lable for='item'>機種料號:</lable><input name='item' value='{$item}' id='item' type='text' readonly='readonly' />" . EOL;
    $palletInfoStr .= "<lable for='qty'>棧板數量:</lable><input name='qty' value='{$qty}' id='qty' type='text' readonly='readonly' />" . EOL;

    if ($existShelfid != false) {
        $palletInfoStr .= '<span>選擇一個儲位</span>';
        foreach ($existShelfid as $v)
        {
            $palletInfoStr .= "<input type='radio' id='{$v}' name='shelfId' value='{$v}'/><label for='{$v}'>{$v}</label>";
        }
        $palletInfoStr .= "<input type='radio' id='selNewShelfId' name='shelfId' value='newShelfId'/><label for='selNewShelfId'>新儲位</label>";
    } else {
        $palletInfoStr .= "<input type='radio' id='selNewShelfId' name='shelfId' value='newShelfId' checked='checked'/><label for='selNewShelfId'>新儲位</label>";
    }
    //最後一個選項是新儲位, 顯示儲位清單. 如果是新訂單, 則該選項默認被選擇
}

?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#btnSearch').click(function (e) {
            if($('#isn').val() != "")
            {
                return true;
            } else {
                alert('查詢的條碼為空, 請確認.');
                return false;
            }
        });

        $('#selNewShelfId').click(function (e) {
            $('#divNewShelfId').show();
        });



    });
</script>

<div>
    <form method="post">
        <div class="divSearch">
            <label for="isn">條碼:</label>
            <input type="text" id="isn" name="isn"/>
            <input type="submit" id="btnSearch" name="btnSearch" value="查詢">
            <input type="submit" id="btnGoodIn" name="btnGoodsIn" value="入庫">
        </div>
        <div>
        <?php
        //如果是新進訂單, 則默認顯示儲位清單, 否則默認不顯示
//        if($existShelfid != false) {
//            echo "<div id='divNewShelfId' style='display:none'>";
//        } else {
//            echo "<div id='divNewShelfId' style='display:block'>";
//        }

        echo $palletInfoStr;
        __createList($conn->getLine('select shelfId from shelfs order by ShelfID'), 'newShelfId', 'newShelfId',null, $newShelfId );
            echo "</div>";
        ?>
        </div>
    </form>
</div>
