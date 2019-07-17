<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 17:11
 */

?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#btnUserAdd').click(function (e) {
            if($('#uid').val() =="" || $('#uname').val()=="" || $('#password').val()=="")
            {
                alert('賬號,用戶名,密碼不能為空.');
                return false;
            }
        });
    });
</script>
<div id="divUserAdd" class="divSearch">
    <form action="?act=user/man" method="post" enctype="multipart/form-data" id="formUserAdd">
        <label for="uid">賬號名</label>
        <input type="text" name="uid" id="uid" style="width: 100px;" />
        <label for="uname">用戶名</label>
        <input type="text" name="uname" id="uname" style="width: 100px;" />
        <label for="password">密碼</label>
        <input type="text" name="password" id="password" style="width: 100px;" />
        <label for="mail">郵件</label>
        <input type="text" name="mail" id="mail" style="width: 100px;" />
<!--        <label for="description">說明</label>-->
<!--        <input type="text" name="description" id="description" style="width: 100px;" />-->
        <input type="submit" name="btnUserAdd" id="btnUserAdd" value="創建用戶" />
    </form>
</div>

<form action="?act=user/man" method="post" enctype="multipart/form-data" name="formUserManagement" id="formUserManagement">
    <div id="divUserManagement" >

            <div class="divSearch">
                <label>選擇用戶
                <select name="userId" id="userId">
                    <option value="NULL">選擇用戶</option>
                    <?php
                        foreach ($conn->getAllRow("select uid,name from users order by name") as $item)
                        {
                            $html = "<option value='%s'>%s</option>";
                            if($userId == $item['uid']) $html = "<option value='%s' selected='selected'>%s</option>";
                            printf($html, $item['uid'], $item['name']);
                        }
                    ?>
                </select>
                </label>
                <input type="submit" name="btnUserDel" id="btnUserDel" value="刪除用戶" />
                <input type="submit" name="btnGetRole" id="btnGetRole" value="獲取用戶角色" />
            </div>
            <div></div>

    </div>
    <div>
        <table class="resultTable">
            <tr class="resultTitle">
                <td style="width: 200px;">剩餘權限</td>
                <td>操作</td>
                <td style="width: 200px;">已有權限</td>
            </tr>
            <tr>
                <td valign="top" align="right">
                    <table>
                        <?php
                        foreach ($allRole as $item)
                        {
                            if(!in_array($item['code'],$allUserRole)) {
                                print "<tr>";
                                printf("<td>%s</td>", $item['name']);
                                printf("<td><input name='RRID_%s' value='%s' type='checkbox'/></td>", $item['code'], $item['code']);
                                print "</tr>";
                            }
                        }
                        ?>
                    </table>
                </td>
                <td>
                    <input class="button" type="submit" name="btnAddRoleByUser" value="增加角色"/><br />
                    <input class="button" type="submit" name="btnDelRoleByUser" value="刪除角色"/>
                </td>
                <td valign="top" align="left">
                    <table>
                        <?php
                        foreach ($allRole as $item)
                        {
                            if(in_array($item['code'],$allUserRole)) {
                                print "<tr>";
                                printf("<td>%s</td>", $item['name']);
                                printf("<td><input name='ERID_%s' value='%s' type='checkbox'/></td>", $item['code'], $item['code']);
                                print "</tr>";
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</form>