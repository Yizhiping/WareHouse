<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 13:21
 */
/*******************************加載庫*********************************/
require_once "Libs/Shelf.php";
$shelf = new Shelf();

/******************************變量參數********************************/
$result = false;

/******************************表單參數********************************/
$shelfSearch = __get('shelfSearch');

//刪除
if(!empty(__get('btnBatchDel')))
{
    foreach ($_POST as $k=>$v)
    {
        if(substr($k,0,4)=='SID_')
        {
            $shelf->Del($v);
        }
    }
}

//創建
$newShelfID = strtoupper(__get('newShelfID'));
$newShelfName = __get('newShelfName');

if(!empty(__get('btnShelfCreate')) )
{
    if(preg_match('/^[1-9A-Z][A-Z][0-9][0-9][0-9][0-9][A-Z]$/',$newShelfID)==1)
    {
        if ($shelf->Add($newShelfID,$newShelfName)) {
            __showMsg("創建成功.");
            $newShelfID = $newShelfName = null;
        } else {
            __showMsg("創建失敗." . $conn->getErr());
        }
    } else {
        __showMsg("創建失敗,儲位編號格式不正確..");
    }
}

if(!empty($shelfSearch))
{
    $result = $conn->getAllRow("select shelfId as code,Description as name from shelfs where ShelfID like '%{$shelfSearch}%'");
}

//是否顯示創建
$showShelfCreate = !empty(__get('btnShelfCreate')) ? 'block' : 'none';

?>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#btnShowShelfBatchCreate').click(function (e) {      //顯示批量上傳
            $('#divShelfCreate').hide();
            $('#divShelfSearchResult').hide();
            $('#divShelfBatchCreate').show();
        });

        $('#btnShelfSearch').click(function (e) {               //搜索
            if($('#shelfSearch').val() =="")
            {
                alert("搜索條件不能為空.")
                return false;
            } else {
                $('#formShelf').submit();
            }
        });

        $('#btnShowShelfCreate').click(function (e) {           //顯示創建
            $('#divShelfSearchResult').hide();
            $('#divShelfBatchCreate').hide();
            $('#divShelfCreate').show();
        });

        $('#selAll').click(function (e) {                       //全部选中或取消选择
            if($(this).is(':checked')) {
                $('.shelfChkbox').prop('checked',true);
            } else {
                $('.shelfChkbox').prop('checked', false);
            }
        });
    });
</script>

<form id="formShelf" name="formShelf" method="post" action="?act=shelf/index">
    <div class="divSearch">
            <label for="textfield">查詢條件</label>
              <input type="text" name="shelfSearch" id="shelfSearch" value="<?php echo $shelfSearch ?>"/>
          <?php __createButton('submit','btnShelfSearch','btnShelfSearch',null,'查詢',null,null) ?>
          <?php __createButton('button','btnShowShelfCreate','btnShowShelfCreate',null,'創建儲位',null,null) ?>
          <?php __createButton('submit','btnShowShelfBatchCreate','btnShowShelfBatchCreate',null,'批量創建',null,null) ?>
          <?php __createButton('submit','btnBatchDel','btnBatchDel',null,'刪除選中儲位',null,null) ?>

    </div>
    <div style="display:none;" id="divShelfBatchCreate">

        <label for="textfield2"></label>
        <input type="file" name="textfield2" id="textfield2" />
          <?php __createButton('submit','btnBatchUpload','btnBatchUpload',null,'批量上傳',null,null) ?>

    </div>
    <div id="divShelfCreate" style="display: <?php echo $showShelfCreate ?>;">
        <label for="newShelfId">儲位編號</label>
        <input type="text" name="newShelfId" id="newShelfId" value="<?php echo $newShelfName ?>" />
        <label for="newShelfName">儲位說明</label>
        <input type="text" name="newShelfName" id="newShelfName" value="<?php echo $newShelfName ?>" />
          <?php __createButton('submit','btnShelfCreate','btnShelfCreate',null,'創建',null,null) ?>

    </div>
    <div class="divResult" id="divResult" style="display: <?php echo $res ? 'block' : 'none' ?>">
        <?php
        if(!$result)
        {
            echo "沒有數據可顯示.";
        } else {
            //shelfId,palletId,model,item,so,qty,customer,uidIn,dateIn
            //表頭部分
            echo "<table class='resultTable'>";
            echo "<tr class='resultTitle'>";
            foreach (array('序號','儲位代碼','儲位名稱','') as $item) echo "<td>{$item}</td>";
            echo "</tr>";
            //表格部分
            $idx = 0;
            foreach ($result as $item)
            {
                $idx++;
                print "<tr class='resultContent selRow'>";
                printf( "<td>%d</td>", $idx);
                printf( "<td>%s</td>", $item['code']);
                printf( "<td>%s</td>", $item['name']);
                printf( "<td><input type='checkbox' name='SID_%s' class='clsSelPallet' value='%s'/></td>", $item['code'],$item['code']);
                print "</tr>";
            }
            print "</table>";
        }
        ?>
    </div>
</form>