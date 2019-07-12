<?php

class Shelf
{
    private $Id;
    private $name;
    private $sConn;

    public function __construct()
    {
        global $conn;
        $this->sConn = $conn;       //初始化數據庫鏈接
    }

    public function get($kwd)
    {
        return $this->sConn->getAllRow("select shelfid,description from shelfs where ShelfID like '{$kwd}'");
    }

    public function add($id, $name)
    {
        return $this->sConn->query("insert into shelfs (ShelfID, Description) value ('{$id}','{$name}')");
    }

    public function del($id)
    {
        return $this->sConn->query("delete from shelfs where ShelfID='{$id}'");
    }

    public function update($uid, $newName)
    {
        return $this->sConn->query("update shelfs set Description='{$newName}' where ShelfID='{$uid}'");
    }
}