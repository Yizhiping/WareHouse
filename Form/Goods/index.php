<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/12
 * Time: 16:38
 */
//********************************引用庫文件*********************************
require_once "Libs/Goods.php";          //貨物庫
require_once "Libs/WebService.php";     //WebService庫

//********************************實例化類**********************************
$goods = new Goods();
$sfis = new SFIS($device, $opid);     //實例化SFISWebservice

//********************************變量定義***********************************
//$isn = __get('isn');                //查詢的條碼
$sfisISN = null;                        //從SFIS獲取的條碼
$item = __get('item');              //料號
$palletId = __get('palletId');      //棧板號
$so = __get('so');                  //訂單號
$qty = __get('qty');                //數量
$model = __get('model');             //機種
$shelfId = __get('shelfId');         //儲位
$existShelfId = false;                   //已經存在的儲位ID
$palletInfo = $goods->samplePalletInfo;  //貨物資料格式
$message = "請輸入條碼進行操作";                        //需要顯示的信息
$isSuccess = false;                     //操作是否成功
$result = false;                        //查詢的結果

//********************************表單獲取***********************************
$shelfId = __get('shelfId');            //儲位ID
$newShelfId = __get('newShelfId');      //新儲位ID, 變更時用
$isn = __get('isn');                    //查詢的條碼
$scanISN = __get("scanISN");            //出貨頁面刷條碼的地方

$opType = __get('opType');


/*
        'palletId'  => null,        //棧板號
        'model'     => null,        //機種名
        'item'      => null,        //料件號
        'so'        => null,        //訂單號
        'qty'       => null,        //數量
        'customer'  => null,        //客戶
        'shelfId'   => null,        //儲位號
        'uid'       => null,        //用戶名
        'dateStart' => null,        //開始時間, 搜索用, 表示信息時為入庫時間
        'dateStop'  => null         //結束時間, 搜索用, 表示已出貨時為出庫時間

                'model'     =>  $tmpArr[1],
                'pallet'    =>  $tmpArr[2],
                'item'      =>  $tmpArr[3],
                'so'        =>  $tmpArr[4]
 */

switch ($method)
{
    //入庫
    case 'in':
        if(!empty($isn)) {
            if($sfisISN = $sfis->getSFISISN($isn))                     //獲取SFISISN
            {
                if ($result = $sfis->getPalletInfoByIsn($sfisISN)) {
                    $item = $result['item'];         //料號
                    $palletId = $result['pallet'];   //棧板
                    $qty = $result['qty'];           //數量
                    $so = $result['so'];             //訂單
                    $model = $result['model'];       //機種
                    $existShelfId = $conn->getLine("select shelfId from goods where so='{$so}' group by shelfId order by id desc");
                    if (!empty($existShelfId))      //如果庫里已經有了, 儲位為最後入的儲位
                    {
                        $shelfId = $existShelfId[0];
                    } else {                         //庫里沒有, 儲位為上傳的儲位, 表單區已讀取
                        $message = "庫中無此訂單記錄, 請指定新儲位.";
                    }

                    if (($shelfId != 'NULL' && $shelfId != null))
                    {
                        $isn = null;
                        if ($goods->in(array(
                            'palletId' => $palletId,
                            'model' => $model,
                            'item' => $item,
                            'so' => $so,
                            'qty' => $qty,
                            'customer' => null,
                            'shelfId' => $shelfId,
                            'uid' => $user->uid
                        ))) {
                            $message = "入庫成功"; //{$palletId}=>{$shelfId},model:{$model},item:{$item}, Qty:{$qty}.
                            //__showMsg("入庫操作成功.");
                            $isSuccess = true;
                        } else {
                            if($conn->getErrNo() == 1062)
                            {
                                //__showMsg( "庫中已存在此編號的棧板, 無法重複入庫.");
                                $message = "庫中已存在此編號的棧板, 無法重複入庫.";
                            } else {
                                //__showMsg("入庫失敗" . $conn->getErr());
                                $message = "入庫失敗";
                            }
                        }
                    }
                } else {
                    $palletId = $model = $so = $model = $qty = $item =  null;   //沒有查詢到的時候清空顯示信息, 避免看錯.
                    __showMsg("輸入的條碼無法查詢到棧板信息");
                }
            } else {
                $palletId = $model = $so = $model = $qty = $item =  null;   //沒有查詢到的時候清空顯示信息, 避免看錯.
                __showMsg("輸入的條碼無法查詢到信息");
            }
        } else {        //沒有輸入查詢條碼的情況
            $palletId = $model = $so = $model = $qty = $item =  null;   //沒有查詢到的時候清空顯示信息, 避免看錯.

        }

        break;
    case 'change':      //變更
        break;
    case 'out':         //出庫

        //獲取所有上傳的棧板ID
        $pallets = array();
        foreach ($_POST as $key=>$val)
        {
            if(substr($key,0,4) == "PID_")
            {
                array_push($pallets,$val);
            }
        }

        $err = null;
        if(!empty(__get('btnGoodsOut')) && !empty($pallets))        //出貨
        {
            foreach ($pallets as $item)
            {
                if(!$goods->out($item, $user->uid)) $err .= $item . ',';
            }
        } else if(!empty(__get('btnGoodsChange')) && !empty($pallets)) {    //變更儲位
            foreach ($pallets as $item)
            {
                if(!$goods->update($item, $newShelfId)) $err .= $item . ',';
            }
        }

        if((!empty(__get('btnGoodsOut')) || !empty(__get('btnGoodsChange'))) && !empty($pallets)) {
            if (empty($err)) {
                __showMsg("選擇的棧板全部操作完成");
            } else {
                __showMsg("發生錯誤,以下棧板操作未完成," . $err);
            }
        }

        if(!empty($scanISN))
        {
            if ($sfisISN = $sfis->getSFISISN($scanISN))
            {
                if($pallet = $sfis->getPalletInfoByIsn($sfisISN))
                {
                    switch ($opType)
                    {
                        case 'pallet': $isn = $pallet['pallet'];   break;
                        case 'so': $isn = $pallet['so'];   break;
                        case 'shelf': $isn = $goods->getInfo($pallet['pallet'],'shelfId');   break;

                    }
                }
            }
        }

        if(!empty($isn)) {
            switch ($opType) {
                case 'pallet':
                    $palletInfo['palletId'] = $isn;
                    break;
                case 'shelf':
                    $palletInfo['shelfId'] = $isn;
                    break;
                case 'so':
                    $palletInfo['so'] = $isn;
                    break;
            }
            $result = $goods->getGoodsInfo($palletInfo);
        }

        break;
    case 'search':      //搜索
        $searchType = __get('searchType');      //查找類型
        //$isn        = __get('iptSearch');       //查找內容
        $palletInfo = $goods->samplePalletInfo;

        if(!empty($scanISN))
        {
            if ($sfisISN = $sfis->getSFISISN($scanISN))
            {
                if($pallet = $sfis->getPalletInfoByIsn($sfisISN))
                {
                    switch ($searchType)
                    {
                        case 'pallet': $isn = $pallet['pallet'];   break;
                        case 'so': $isn = $pallet['so'];   break;
                        case 'shelf': $isn = $goods->getInfo($pallet['pallet'],'shelfId');   break;

                    }
                }
            }
        }

        if(!empty($isn))
        {
            switch ($searchType)
            {
                case 'shelf':
                    $palletInfo['shelfId'] = $isn;
                    break;
                case 'so':
                    $palletInfo['so']     = $isn;
                    break;
                case 'pallet':
                    $palletInfo['palletId'] = $isn;
                    break;
            }

            $result = $goods->getGoodsInfo($palletInfo);
        }
    default:
        break;
}

require_once("Libs/checkMobileLoadPage.php");



