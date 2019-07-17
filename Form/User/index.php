<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/12
 * Time: 19:16
 */

if(empty($method)) $method = "login";

/*****************************參數定義***************************/
$result = false;        //搜索結果

/*****************************表單參數定義***********************/
$newFunName = __get("newFunName");      //新建功能的名稱
$newRoleName = __get('newRoleName');    //新建角色名稱
$role = __get('role');                  //當前處理的角色ID
$userId = __get('userId');              //當前處理的用戶ID

$newUid = __get('uid');                 //新增的賬號名
$newName = __get('uname');              //新增的用戶名
$newPwd = __get('password');            //新增的密碼
$newMail = __get('mail');               //新增的郵件

switch ($method)
{
    case 'logout':
        $user->logout();
        header('Location:'. $homeUrl);
        break;

    case 'fun':
        $funIds = array();

        if(!empty($newFunName) && !empty(__get('btnCreateFun')))     //新增
        {
            if($user->funAdd($newFunName))
            {
                __showMsg("功能新增成功.");
            } else {
                __showMsg("功能新增失敗.");
            }
        }

        foreach ($_POST as $key=>$val)      //獲取所有上傳的功能ID
        {
            if(substr($key,0,4) == 'FID_')
            {
                array_push($funIds, $val);
            }
        }

        if(!empty(__get('btnFunDel')) && !empty($funIds))
        {
            foreach ($funIds as $item)
            {
                $user->funDelete($item);
            }
        }

        $result = $conn->getAllRow("select code,name from fun order by name");
        break;

    case 'roles':
        //新增一個角色
        if(!empty($newRoleName) && !empty(__get('btnRoleCreate')))
        {
            if($user->roleAdd($newRoleName))
            {
                __showMsg('角色創建成功.');
            } else {
                __showMsg('角色創建失敗.' . $user->uconn->getErr());
            }
        }

        //刪除一個角色
        if(!empty(__get('btnRoleDel')))
        {
            if($user->roleDelete($role))
            {
                __showMsg('角色刪除成功.');
            } else {
                __showMsg('角色刪除失敗.' . $user->uconn->getErr());
            }
        }

        //從角色刪除功能
        if(!empty('btnDelFunByRole'))
        {
            foreach ($_POST as $key=>$val)
            {
                if(substr($key,0,5)=='EFID_')
                {
                    $user->delRoleFun($role, $val);
                }
            }
        }

        //從角色增加功能
        if(!empty('btnAddFunByRole'))
        {
            foreach ($_POST as $key=>$val)
            {
                if(substr($key,0,5)=='RFID_')
                {
                    $user->addRoleFun($role, $val);
                }
            }
        }

        //獲取所有功能
        $allFun = $conn->getAllRow("select code,name from fun order by name");
        //獲取角色所有的功能
        $allRoleFun = $conn->getLine("select fid from rfid where rid='{$role}'");
        if(empty($allRoleFun)) $allRoleFun = array();

        break;

    case 'man':
        //新增
        if(!empty($newUid) &&
            !empty($newName) &&
            !empty($newPwd)
        ) {
            $userInfo = $user->sampleUserInfo;
            $userInfo['uid'] = $newUid;
            $userInfo['pwd'] = $newPwd;
            $userInfo['name'] = $newName;
            $userInfo['mail'] = $newMail;
            if($user->userAdd($userInfo))
            {
                __showMsg("用戶添加成功.");
            }
        }

        //刪除
        if(!empty(__get('btnUserDel')) && $userId != 'NULL')
        {
            if($user->userDelete($userId)) {
                __showMsg("用戶刪除成功.");
            }
        }

        //增加角色
        foreach ($_POST as $key=>$val)
        {
            if(substr($key, 0 ,5) == 'RRID_')
            {
                $user->addByUserToURID($userId, $val);
            }
        }

        //刪除角色
        foreach ($_POST as $key=>$val)
        {
            if(substr($key, 0 ,5) == 'ERID_')
            {
                $user->delByUserFromURID($userId, $val);
            }
        }

        $allRole = $conn->getAllRow("select code,name from role order by name");
        $allUserRole = $conn->getLine("select rid from urid where uid='{$userId}'");
        if(empty($allUserRole)) $allUserRole = array();

        break;

    default:
    case 'login':

        break;
}

require_once("Libs/checkMobileLoadPage.php");