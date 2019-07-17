<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 9:52
 */

switch ($act)
{
//    case "userLogout":
//        $user->logout();
//        header('Location:'. $homeUrl);
//        break;

    default:
        if(empty($act))
        {
            //todo: 空請求, 顯示主頁.
        } else {
            if(file_exists("Form/{$act}/index.php"))
            {
                include("Form/{$act}/index.php");
            } else {
                include("Form/404.php");
            }
        }
        break;
}

pageEnd: