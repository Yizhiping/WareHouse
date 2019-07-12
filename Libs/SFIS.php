<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/13
 * Time: 9:27
 */

class SFIS
{
    private $WebService;    //Websrivice
    private $err = false;           //錯誤


    /**
     * SFIS constructor.    以WebService初始化SFIS
     * @param $dev  撥號
     * @param $opid 工號
     */
    public function __construct($dev, $opid)
    {
        $this->WebService = new WebService($dev, $opid);
    }

    /** 返回所查條碼對應的SFIS ISN條碼
     * @param $isn  需要查詢的條碼
     * @return bool 成功返回條碼, 失敗返回false.
     */
    public function getSFISISN($isn)
    {
        $res = $this->WebService->WTSP_GETVERSION($isn,'ITEMINFO',null,null);
        if($res)
        {
            return $res[5];
        } else {
            return false;
        }
    }

    /**
     * 輸入ISN取得產品的MODEL,PALLET,ITEM,SO
     * @param $isn  需要查詢的ISN
     * @return array|bool   成功返回ISN對應產品訊息, 失敗返回false.
     */
    public function getItemInfoByISN($isn)
    {
        $res = $this->WebService->WTSP_GETVERSION($isn,'GET_TABLE','ISN;MODEL,PALLET,ITEM,SO;SSN');
        if($res)
        {
            $tmpArr = explode(',', $res[2]);
            return array(
                'MODEL'     =>  $tmpArr[1],
                'PALLET'    =>  $tmpArr[2],
                'ITEM'      =>  $tmpArr[3],
                'SO'        =>  $tmpArr[4]
            );

        } else {
            return false;
        }
    }

    /**
     * 輸入棧板ID返回該棧板的數量, 失敗返回false
     * @param $pallet   棧板ID
     * @return bool
     */
    public function getPalletQty($pallet)
    {
        $res = $this->WebService->WTSP_GETVERSION($pallet,'GET_TABLE','PALLET;QTY;PALLET');
        if($res)
        {
            $tmpArr = explode(',', $res[2]);
            return $tmpArr[1];
        } else {
            return false;
        }
    }
}