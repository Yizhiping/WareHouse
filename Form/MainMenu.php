<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 9:39
 */
if($isMobile) {
    ?>
    <style>
        #divMainMenu a {
            display: inline-block;
            border: 1px solid black;
            color: black;
            height: 1em;
            /* width: 80px; */
            float: left;
            text-align: center;
            font-size: 2em;
            line-height: 1em;
            margin-right: 0.2em;
            border-radius: 15%;
            text-decoration: none;
            padding: 0.1em 0.5em 0.1em;
            margin-top: 0.1em;
        }

        #divMainMenu a:hover {
            font-weight: bold;
            background-color: #000;
            color: #fff;
        }
    </style>
    <?php
} else {
    ?>
    <style>
        #divMainMenu a {
            display: inline-block;
            border: 1px solid black;
            color: black;
            /*height: 1em;*/
            /*width: 80px;*/
            float: left;
            text-align: center;
            /*font-size: 2em;*/
            line-height: 1em;
            margin-right: 0.2em;
            border-radius: 15%;
            text-decoration: none;
            padding: 0.1em 0.5em 0.1em;
            margin-top: 0.1em;
        }

        #divMainMenu a:hover {
            font-weight: bold;
            background-color: #000;
            color: #fff;
        }
    </style>
    <?php
}
?>
<div id="divMainMenu">
    <div style="float: left">
    <?php
        __createLink(null,null,'menuButton','?act=good/search','查詢');
        __createLink(null,null,'menuButton','?act=good/in','入庫');
        __createLink(null,null,'menuButton','?act=good/out','出庫');
        if(!$isMobile) __createLink(null,null,'menuButton','?act=shelf','儲位');
        if(!$isMobile) __createLink(null,null,'menuButton','?act=inventory','盤點');
        if(!$isMobile && $user->authByRole('管理員'))
        {
            __createLink(null,null,'menuButton','?act=user/man','用戶管理');
            __createLink(null,null,'menuButton','?act=user/roles','角色管理');
            __createLink(null,null,'menuButton','?act=user/fun','功能管理');
        }
    ?>
    </div>
    <div style="float: right">
        <?php
        if(!$isMobile) __createLink(null,null,'menuButton','?act=user/detail',$user->name);
        __createLink(null,null,'menuButton','?act=user/logout','登出');
        ?>
    </div>
</div>
