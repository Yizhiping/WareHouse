<?php
/**
 * Created by PhpStorm.
 * User: Ping_
 * Date: 2019/6/11
 * Time: 22:13
 */
require_once "Libs/Goods.php";           //包含庫
//********************表單變量獲取**********************
$searchType = __get('searchType');      //查找類型
$isn        = __get('iptSearch');       //查找內容
$btnSearch  = __get('btnSearch');       //查找按鈕


//*********************變量定義*************************
$goods = new Goods();
$palletInfo = $goods->samplePalletInfo;
$resultHtml = null;
$idx = 0;

//*********************查找*****************************
if(!empty($btnSearch))
{
    switch ($searchType)
    {
        case 'S001':
            $palletInfo['shelfId'] = $isn;
            break;
        case 'S002':
            $palletInfo['so']     = $isn;
            break;
        case 'S003':
            $palletInfo['palletId'] = $isn;
            break;
    }
#ShelfId,PalletId,model,item,so,qty,customer,uid,datein
    if($res = $goods->getGoodsInfo($palletInfo))
    {
        $resultHtml .= "<table><tr><td>序號</td><td>儲位</td><td>棧板</td><td>訂單</td><td>數量</td></tr>";
        foreach ($res as $r)
        {
            $idx++;
            $resultHtml .= "<tr><td>{$idx}</td><td>{$r[0]}</td><td>{$r[1]}</td><td>{$r[4]}</td><td>{$r[5]}</td></tr>";

        }
        $resultHtml .= "</table>";
    } else {
        $resultHtml .= "沒有找到相關結果.";
    }
}

?>
<style>
    .divResult table tr td{
        font-size: 100%;
        height: 1em;
    }
    .divSearch form label {
        font-size: 1.5em;
    }
</style>
<div class="divSearch">
    <form id="formSearch" name="formSearch" method="post" action="?act=search">
        <label for="searchType">類型</label>
        <select name="searchType" id="searchType">
            <option value="S001">儲位</option>
            <option value="S002">訂單</option>
            <option value="S003">棧板</option>
        </select>
        <br />
        <label for="iptSearch">内容</label>
        <input type="text" name="iptSearch" id="iptSearch" value="<?php echo $isn ?>" style="width: 50%"/>
        <input type="submit" name="btnSearch" id="btnSearch" value="查詢">
    </form>
</div>
<div class="divResult">
    <?php echo $resultHtml ?>
</div>