<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/11
 * Time: 10:42
 */

 ?>
<script type="text/javascript">
    $(document).ready(function(e){
        $('#btnRoleCreate').click(function(e){
            if($('#iptRoleDesc').val()=="")
            {
                alert('角色描述不能爲空.');
                return false;
            } else {
                return true;
            }
        });
    });
</script>
 <form action="?act=user/roles" method="post" enctype="multipart/form-data" name="formRole">
   <div class="divSearch">
        <label for="iptRoleDesc">角色描述</label>
        <input type="text" name="newRoleName" id="newRoleName" />
        <input type="submit" name="btnRoleCreate" id="btnRoleCreate" value="創建角色" />
   </div>
   <div class="divSearch">
        <label for="role">角色</label>
        <select name="role" id="role">
        <option>選擇角色</option>
        <?php
            foreach ($conn->getAllRow("select code,name from role order by name ") as $item)
            {
                $html = "<option value='%s'>%s</option>";
                if($role == $item['code'])  $html = "<option selected='selected' value='%s'>%s</option>";
                printf($html,$item['code'],$item['name']);
            }
        ?>
        </select>
       <input type="submit" name="btnRoleDel" id="btnRoleDel" value="刪除角色" />
       <input type="submit" name="btnGetRoleInfo" id="btnGetRoleInfo" value="獲取角色權限" />
   </div>
     <div style="margin-left: 5px; margin-top: 5px;">
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
                            foreach ($allFun as $item)
                            {
                                if(!in_array($item['code'],$allRoleFun)) {
                                    print "<tr>";
                                    printf("<td>%s</td>", $item['name']);
                                    printf("<td><input name='RFID_%s' value='%s' type='checkbox'/></td>", $item['code'], $item['code']);
                                    print "</tr>";
                                }
                            }
                        ?>
                     </table>
                 </td>
                 <td>
                     <input class="button" type="submit" name="btnAddFunByRole" value="增加功能"/><br />
                     <input class="button" type="submit" name="btnDelFunByRole" value="刪除功能"/>
                 </td>
                 <td valign="top" align="left">
                     <table>
                         <?php
                         foreach ($allFun as $item)
                         {
                             if(in_array($item['code'],$allRoleFun)) {
                                 print "<tr>";
                                 printf("<td>%s</td>", $item['name']);
                                 printf("<td><input name='EFID_%s' value='%s' type='checkbox'/></td>", $item['code'], $item['code']);
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