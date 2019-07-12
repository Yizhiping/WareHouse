<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 16:15
 */
$uid = __get('uid');
$pwd = __get('password');

if(!empty(__get('btnUserLogin')))
{
    if(empty($uid) || empty($pwd))
    {
        __showMsg("账号和密码不能为空.");
    } else {
        if($user->login($uid, $pwd))
        {
            header("Location:" . $homeUrl);
        } else {
            __showMsg("账号或密码错误, 登录失败.");
        }
    }
}

?>
<script type="text/javascript">
$(document).ready(function(e) {
    $('#btnuserLogin').click( function(e)
	{
		if($('#uid').val()=="" || $('#password').val() == "")
		{
			alert("用戶名和密碼不能為空.");
			return false;
		} else 
		{
            return true;
		}
	}
	);
});
</script>
<style>
    #divUserLogin table tr td{
        font-size: 1em;
    }
    #divUserLogin table td:nth-child(1)
    {
        width: 100px;
        font-size: 1.5em;
    }
    #divUserLogin table td:nth-child(2)
    {
        width: 300px;
    }

    #divUserLogin
    {
<?php
    if($isMobile)
        {
            echo "
                margin-top: 20%;
    margin-left: 5%;
    padding: 5% 5% 20%;";
        } else {
        echo "margin-top: 20%;
margin-left: 5%;
padding: 5% 30% 50%;";
        }

?>
    }
</style>
<div style="border: 1px solid #666">
    <div id="divUserLogin">
        <form id="formUserLogin" enctype="multipart/form-data" action="?act=userLogin" method="post">
            <div><span>账户:</span><input id="uid" name="uid" type="text" value="<?php echo $uid ?>"/></div>
            <div><span>密碼:</span><input id="password" name="password" type="password" value="<?php echo $pwd ?>"/></div>
            <div></div>
            <div><input type="submit" name="btnUserLogin" id="btnUserLogin" value="登入系统" style="float: right;"></div>
        </form>
    </div>
</div>