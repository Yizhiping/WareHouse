<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/14
 * Time: 9:21
 */

class Goods
{
    public $gconn;     //數據庫連接
    public  $samplePalletInfo = array(
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
    );

    public function __construct()
    {
        global $conn;
        $this->gconn = $conn;
    }

    /**
     * 返回搜索結果
     * @param $searchInfo 搜索條件
     * @return array|bool|null
     */
    public function getGoodsInfo($searchInfo)
    {
        if($tmpSql = $this->__createSelSql($searchInfo))
        {
            return $this->gconn->getAllRow("select shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn from goods where 1=1 " . $tmpSql);
        } else {
            return false;
        }
    }

    /**
     * 入庫
     * @param $palletInfo   增加棧板的信息
     * @return true|false   成功返回true, 失敗返回false.
     */
    public function in($palletInfo)
    {
        $sql = "insert into Goods (PalletId, Model, Item, SO, Qty, Customer, ShelfId, uidIn, Datein) VALUE (
                '{$palletInfo['palletId']}',
                '{$palletInfo['model']}',
                '{$palletInfo['item']}',
                '{$palletInfo['so']}',
                 {$palletInfo['qty']},
                '{$palletInfo['customer']}',
                '{$palletInfo['shelfId']}',
                '{$palletInfo['uid']}',
                now()
                )";
        return $this->gconn->query($sql);
    }

    /**
     * 出庫
     * @param $palletId 棧板號
     * @param $uid      出庫處理人
     * @return true|false
     */
    public function out($palletId, $uid)
    {
        #這裡需要一個事物, 從庫存刪除之前, 需要將數據保存到已出貨表中, 然後再刪除庫存表中的記錄, 否則執行回滾.
        #第一步, 開始事物
        $this->gconn->query('begin');
        #第二步,複製資料到已出貨表
        if(!$this->gconn->query("insert into goods_shipped (palletId,model,item,so,qty,customer,uidIn,dateIn) select palletId,model,item,so,qty,customer,uidIn,dateIn from Goods where PalletId='{$palletId}'")) goto outEnd;

        #第三步, 更新已出貨表的處理人
        if(!$this->gconn->query("update goods_shipped set dateOut=now(), uidOut='{$uid}' where PalletId='{$palletId}'")) goto outEnd;

        #第四步, 刪除庫存資料
        if(!$this->gconn->query("delete from Goods where PalletId='{$palletId}'")) goto outEnd;

        #第五步, 提交事物
        return $this->gconn->query('commit');

        outEnd:
        $this->gconn->query('rollback');
        return false;

    }

    /**
     * 生成搜索所用sql
     * @param $palletInfo
     * @return bool|null|string
     */
    private function __createSelSql($palletInfo)
    {
        $tmpSql = null;

        foreach ($palletInfo as $key=>$val)
        {
            if($key != 'dateStart' && $key != 'dateStop') {
                if (!empty($val)) $tmpSql .= " and {$key}='{$val}'";
            } else {
                if (!empty($val) && $key=='dateStart') $tmpSql .= " and datein >='{$val}'";
                if (!empty($val) && $key=='dateStop') $tmpSql .= " and datein <='{$val}'";
            }
        }
        return empty($tmpSql) ? false : $tmpSql;
    }

    /**
     * 更新貨物表, 僅可更新ShelfId欄位
     * @param $palletId 棧板號
     * @param $newShelfId 新的儲位
     * @return bool|null    成功返回true, 失敗返回false
     */
    public function update($palletId, $newShelfId)
    {
        #獲取原位置, 寫事件用的
        $oldShelfId = $this->gconn->getItemByItemName("select shelfId from Goods where PalletId='{$palletId}'");
        $updateSql = "update Goods set ShelfId='{$newShelfId}' where PalletId='{$palletId}'";
        return $this->gconn->query($updateSql);
    }

    /**
     * 返回對應棧板一個字段的信息
     * @param $palletId
     * @param $field
     * @return bool
     */
    public function getInfo($palletId, $field)
    {
        return $this->gconn->getItemByItemName("select {$field} from goods where palletId='{$palletId}'");
    }
}