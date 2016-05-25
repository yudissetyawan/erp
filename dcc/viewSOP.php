<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
    session_start();
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

mysql_select_db($database_core, $core);
$query_rsdoc = "SELECT d_sop.id, d_sop.id_dept, d_sop.doc_no, d_sop.rev, d_sop.efect_date, d_sop.title, d_sop.dsop_note, d_sop.interval_review, dms.idms, dms.fileupload, dms.inisial_pekerjaan, h_department.id AS dept_id, h_department.department, h_department.urutan FROM d_sop, dms, h_department WHERE d_sop.id=dms.idms AND dms.inisial_pekerjaan='SOP' AND d_sop.id_dept = h_department.id AND d_sop.id_dept <> 6 ORDER BY h_department.urutan ASC, d_sop.doc_no ASC";
$rsdoc = mysql_query($query_rsdoc, $core) or die(mysql_error());
$row_rsdoc = mysql_fetch_assoc($rsdoc);
$totalRows_rsdoc = mysql_num_rows($rsdoc);
mysql_select_db($database_core, $core);
$query_rsdoc = "SELECT d_sop.id, d_sop.id_dept, d_sop.doc_no, d_sop.rev, d_sop.efect_date, d_sop.title, d_sop.dsop_note, d_sop.interval_review, dms.idms, dms.fileupload, dms.inisial_pekerjaan, h_department.id AS dept_id, h_department.department, h_department.urutan FROM d_sop, dms, h_department WHERE d_sop.id=dms.idms AND dms.inisial_pekerjaan='SOP' AND d_sop.id_dept = h_department.id AND d_sop.id_dept <> 6 ORDER BY h_department.urutan ASC, d_sop.doc_no ASC";
$rsdoc = mysql_query($query_rsdoc, $core) or die(mysql_error());
$row_rsdoc = mysql_fetch_assoc($rsdoc);
$totalRows_rsdoc = mysql_num_rows($rsdoc);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>View SOP</title>
    <link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css"/>
    <link href="/css/induk.css" rel="stylesheet" type="text/css"/>
    <link href="/css/table.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.datatables.js"></script>
    <script type="text/javascript" src="/js/jquery.jeditable.js"></script>
    <script type="text/javascript" src="/js/jquery.blockui.js"></script>

    <!-- <script type="text/javascript" src="/js/jquery-214.js"></script> -->

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $("#celebs");
            var oTable = table.dataTable({"sPaginationType": "full_numbers", "bStateSave": true});

            $(".editable", oTable.fnGetNodes()).editable("php/ajax.php?r=edit_celeb", {
                "callback": function (sValue, y) {
                    var fetch = sValue.split(",");
                    var aPos = oTable.fnGetPosition(this);
                    oTable.fnUpdate(fetch[1], aPos[0], aPos[1]);
                },
                "submitdata": function (value, settings) {
                    return {
                        "row_id": this.parentNode.getAttribute("id"),
                        "column": oTable.fnGetPosition(this)[2]
                    };
                },
                "height": "14px"
            });

            $(document).on("click", ".delete", function () {
                var celeb_id = $(this).attr("id").replace("delete-", "");
                var parent = $("#" + celeb_id);
                $.ajax({
                    type: "get",
                    url: "php/ajax.php?r=delete_celeb&id=" + celeb_id,
                    data: "",
                    beforeSend: function () {
                        table.block({
                            message: "",
                            css: {
                                border: "none",
                                backgroundColor: "none"
                            },
                            overlayCSS: {
                                backgroundColor: "#fff",
                                opacity: "0.5",
                                cursor: "wait"
                            }
                        });
                    },
                    success: function (response) {
                        table.unblock();
                        var get = response.split(",");
                        if (get[0] == "success") {
                            $(parent).fadeOut(200, function () {
                                $(parent).remove();
                            });
                        }
                    }
                });
            });
        });
        function MM_openBrWindow(theURL, winName, features) { //v2.0
            window.open(theURL, winName, features);
        }
    </script>

</head>

<body>
<?php
if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager') 
    ?>
    <p><a href="#" onclick="MM_openBrWindow('inputselection.php','','width=520,height=480')" id="dialog_link"
          class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add SOP</a></p>
<?php } ?>

<table width="100%" border="0" class="table" id="celebs">
    <thead>
    <tr height="40" class="tabel_header">
        <td width="25">No.</td>
        <td width="100">Department</td>
        <td width="80">Doc. No.</td>
        <td width="40">Rev.</td>
        <td width="300">Title</td>
        <td width="80">Effective<br/>Date</td>
        <td>Remark</td>
        <td width="80">Interval<br/>Review</td>
        <?php
        if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager')
            ?>
            <td width="70">Edit | Delete</td>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    {
        require_once "../dateformat_funct.php";
    }
    $a = 0;
    do { ?>
        <tr class="tabel_body"><? $a = $a + 1; ?>
            <td align="center"><?php echo $a; ?></td>
            <td><?php echo $row_rsdoc['department']; ?></td>
            <td><?php echo $row_rsdoc['doc_no']; ?></td>
            <td align="center"><?php echo $row_rsdoc['rev']; ?></td>
            <td><?php
                //if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'dcc')) {
                //echo '<a class="fancybox" href="../dcc/upload/'.$row_rsdoc[fileupload].'" data-fancybox-type="iframe">'.$row_rsdoc['title'].'</a>';
                //}
                //else { echo $row_rsdoc[title]; }
                ?>
                <a href="../dcc/upload/<?php echo $row_rsdoc['fileupload']; ?>"
                   target="_blank"><?php echo $row_rsdoc['title']; ?></a></td>
            <td align="center"><?php echo functddmmmyyyy($row_rsdoc['efect_date']); ?></td>
            <td><?php echo $row_rsdoc['dsop_note']; ?></td>
            <td align="center"><?php echo $row_rsdoc['interval_review']; ?></td>

            <?php
            if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager')
                ?>
                <td align="center">
                    <a href="#"
                       onclick="MM_openBrWindow('editSOP.php?data=<?php echo $row_rsdoc['idms']; ?>','','scrollbars=yes,resizable=yes,width=520,height=480')"><img
                            src="images/icedit.png" width="15" height="15"></a> |
                    <a href="delsop.php?data=<?php echo $row_rsdoc['idms']; ?>"
                       onclick="return confirm('Delete Document No. <?php echo $row_rsdoc['doc_no']; ?> ?')"
                       title="Delete Data"><img src="images/icdel.png" width="15" height="15"></a>
                </td>
            <?php } ?>

        </tr>
    <?php } while ($row_rsdoc = mysql_fetch_assoc($rsdoc)); ?>
    </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($rsdoc);
?>
