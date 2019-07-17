<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 10:12
 */

$oldPwd = __get('oldPwd');
$newPwd = __get('newPwd');
$newPwd2 = __get('newPwd2');

if(!empty(__get('btnChangePwd'))) {
    if ($newPwd == $newPwd2) {
        if ($user->changePassword($user->uid,$oldPwd, $newPwd)) {
            __showMsg("密碼修改成功");
        } else {
            __showMsg("密碼修改失敗");
        }
    } else {
        __showMsg("兩次輸入的密碼不一樣.");
    }
}
?>
<style>
    #tabChangePwd,#tabUserDetail {
        display: inline-block;
    }

    #tabUserDetail{
        border-collapse: collapse;
        width: 400px;
    }

    #tabChangePwd {
        border-collapse: collapse;
    }

    #tabUserDetail tr td {
        border: 1px solid #666;
        padding: 0.2em 0.5em 0.2em;
    }

    #tabUserDetail tr td:first-child, #tabChangePwd tr td:first-child{
        text-align: right;
    }

    #tabUserDetail tr td:nth-child(2), #tabChangePwd tr td:nth-child(2){
        text-align: left;
    }
    #tabChangePwd input[type='password'] {
        width: 100%;
    }
</style>
<div style="margin-top: 5px;">
    <form method="post" action="?act=user/detail">
    <table>
        <tr>
            <td>
                <table id="tabUserDetail">
                  <tr>
                    <td>id:</td>
                    <td><?php echo $user->uid ?></td>
                  </tr>
                  <tr>
                    <td>賬戶名:</td>
                    <td><?php echo $user->name ?></td>
                  </tr>
                  <tr>
                    <td>郵件:</td>
                    <td><?php echo $user->mail ?></td>
                  </tr>
                  <tr>
                    <td>最後登錄時間:</td>
                    <td><?php echo $user->lastLogin ?></td>
                  </tr>
                  <tr>
                    <td>最後登錄地址:</td>
                    <td><?php echo $user->loginAddr ?></td>
                  </tr>
                  <tr>
                    <td>總登錄次數:</td>
                    <td><?php echo $user->loginTimes ?></td>
                  </tr>
                </table>
            </td>
            <td valign="top">
                <table id="tabChangePwd">
                    <tr>
                        <td>舊密碼:</td>
                        <td><input type="password" name="oldPwd"/></td>
                    </tr>        <tr>
                        <td>新密碼:</td>
                        <td><input type="password" name="newPwd"/></td>
                    </tr>      <tr>
                        <td>確認密碼:</td>
                        <td><input type="password" name="newPwd2"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="btnChangePwd" value="變更密碼" class="button" /></td>
                        </td>
                    </tr>
                </table>
        </tr>
    </table>
    </form>
</div>
