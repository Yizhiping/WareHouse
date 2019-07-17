<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/16
 * Time: 9:32
 */


if($isMobile) {
    if(file_exists("Form/{$act}/{$method}_Mobile.php"))
    {
        include("Form/{$act}/{$method}_Mobile.php");
    } else {
        if(file_exists("Form/{$act}/{$method}.php"))
        {
            include("Form/{$act}/{$method}.php");
        } else {
            include("Form/404.php");
        }
    }
} else {
    if(file_exists("Form/{$act}/{$method}.php"))
    {
        include("Form/{$act}/{$method}.php");
    } else {
        include("Form/404.php");
    }
}
