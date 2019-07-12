<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/13
 * Time: 10:15
 * 本文件包含兩個類, WebService 和 SFIS
 * WebService 是基於NUSOAP連接工廠SFIS WebService的基礎功能.
 * SFIS 基於WebService 實現各種具體功能
 */
require_once "lib/nusoap.php";        //引用NuSoap

/** 基於NuSoap連接工廠SFIS WebService, 調用SFIS功能返回結果.
 * Class WebService
 */
class WebService
{
    private $url = 'Http://172.24.248.15/sfiswebservice/sfistspwebservice.asmx?WSDL';
//   private $url = 'http://172.24.255.10/SFISWebService_SZASCD0QA/SFISTSPWebService.asmx?WSDL';        //測試地址
    private $uid = 'TSP_BBPE';  //賬號
    private $pwd = 'wk4jd9';    //密碼
    private $device = "";       //撥號
    private $opid = "";         //工號
    private $Client;
    public $result;            //執行結果的源代碼
    public $err;               //發生錯誤時的錯誤內容


    /**
     * WebService constructor.
     * @param $device   撥號
     * @param $opid     工號
     */
    public function __construct($device, $opid)
    {
        $this->Client = new nusoap_client($this->url,'wsdl');
        $this->Client->timeout = 2000;
        $this->device = $device;
        $this->opid = $opid;
//        $this->GetDatabaseInformation();
    }

    /**
     * 獲取當前數據描述信息
     * @return array|bool
     */
    public function GetDatabaseInformation()
    {
        return $this->getResult(__FUNCTION__, $this->Client->call(__FUNCTION__,array()));
    }

    /**
     * @param $isn  查詢的序列號
     * @param $type 查詢類型
     * @param string $chkdat1   CheckData1
     * @param string $chkdat2   CheckData2
     * @return array|bool   成功返回結果,失敗返回false
     */
    public function WTSP_GETVERSION($isn, $type, $chkdat1=' ', $chkdat2=' ' )
    {
        $paras = array(
                'programId'=>$this->uid,
                'programPassword'=>$this->pwd,
                'ISN'=>$isn,
                'device'=>$this->device,
                'type'=>$type,
                'ChkData'=>$chkdat1,
                'ChkData2'=>$chkdat2
                );
        return $this->getResult(__FUNCTION__, $this->Client->call(__FUNCTION__,$paras));
    }

    /**
     * @param $methodName   方法名稱
     * @param $obj  從SoapCall返回的對象
     * @return array|bool 如果執行失敗返回false, 執行成功返回結果.
     */
    private function getResult($methodName, $obj)
    {
        if(is_array($obj) && isset($obj[$methodName . 'Result'])) {
            $this->result = $obj[$methodName . 'Result'];
            $arr = explode(chr(127), $obj[$methodName . 'Result']);

            if ($arr[0] == '1') {
                return $arr;
                $this->err = false;
            } else {
                $this->err = $arr[1];
                return false;
            }
        } else
        {
            return false;
        }

    }
}

/**
 * 基於SFIS WEBService實現SFIS功能
 * Class SFIS
 */
class SFIS
{
    private $WebService;    //Websrivice
    //private $err = false;           //錯誤


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
        $res = $this->WebService->WTSP_GETVERSION($isn,'GET_TABLE','ISN;MODEL,PALLET,ITEM,SO;ISN');
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

    /** 查詢輸入條碼對應棧板的信息, 結構 item,pallet,so,qty,model
     * @param $isn  被查詢的條碼
     * @return array|bool   查詢成功返回棧板信息, 失敗返回false.
     */
    public function getPalletInfoByIsn($isn)
    {
        $sfisISN = $pallet = null;
        $tmpArr = "";
        $palletInfo = array(
            'item'      => null,
            'pallet'    => null,
            'so'        => null,
            'qty'       => 0,
            'model'     => null
        );
        if($sfisISN = $this->getSFISISN($isn))
        {

            if($tmpArr = $this->getItemInfoByISN($sfisISN))
            {
                $palletInfo['model'] = $tmpArr['MODEL'];
                $palletInfo['pallet'] = $tmpArr['PALLET'];
                $palletInfo['item'] = $tmpArr['ITEM'];
                $palletInfo['so'] = $tmpArr['SO'];
                if($tmpArr = $this->getPalletQty($palletInfo['pallet']))
                {
                    $palletInfo['qty'] = $tmpArr;

                    return $palletInfo;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}