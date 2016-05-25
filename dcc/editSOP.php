<?php require_once('../Connections/core.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE d_sop SET id_dept=%s, doc_no=%s, rev=%s, efect_date=%s, title=%s WHERE id=%s",
        GetSQLValueString($_POST['id_dept'], "int"),
        GetSQLValueString($_POST['doc_no'], "text"),
        GetSQLValueString($_POST['rev'], "text"),
        GetSQLValueString($_POST['efect_date'], "date"),
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_core, $core);
    $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if ($_POST['nama_fileps'] == '') {
        $nfile = $_POST['nama_fileps2'];
    } else {
        $nfile = $_POST['nama_fileps'];
    }
    /* echo "<script>alert(\"$nfile\");</script>"; */

    $updateSQL2 = sprintf("UPDATE dms SET idms=%s, id_departemen=%s, inisial_pekerjaan=%s, `date`=%s, fileupload=%s, keterangan=%s WHERE id=%s",
        GetSQLValueString($_POST['id'], "text"),
        GetSQLValueString($_POST['id_dept'], "text"),
        GetSQLValueString($_POST['inisial_pekerjaan'], "text"),
        GetSQLValueString($_POST['efect_date'], "text"),
        GetSQLValueString($nfile, "text"),
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_core, $core);
    $Result1 = mysql_query($updateSQL2, $core) or die(mysql_error());

    // on update close window handler
    // --> by yudis
    echo "<script>
  	alert(\"Document has been saved\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_department ORDER BY department ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
    $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM d_sop WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
    $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM dms WHERE idms = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM d_sop ORDER BY id ASC LIMIT 1"));
$cekQ = $ceknomor[id];
#menghilangkan huruf
$awalQ = substr($cekQ, 3 - 5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next = (int)$awalQ + 1;
$nextpracode = sprintf($next);
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Edit SOP</title>

        <link href="/css/induk.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="General">
    <?php {
        include "../date.php";
        include "uploadsop.php";
    } ?>
    <table width="496" border="0" cellpadding="3" cellspacing="3">
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td width="130">Attachment File</td>
            <td width="3">:</td>
            <td class="contenthdr">
                <form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
                    <input name="fileps" type="file" style="cursor:pointer;"/>
                    <input type="submit" name="submit" value="Upload"/>
                </form>
            </td>
        </tr>
    </table>

    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
        <table width="496" cellpadding="3" cellspacing="3">
            <tr>
                <td width="130">Department</td>
                <td width="3">:</td>
                <td><select name="id_dept" id="id_dept" title="<?php echo $row_Recordset2['id_dept']; ?>">
                        <option value="">- Select Department -</option>
                        <?php
                        do {
                            ?>
                            <option
                                value="<?php echo $row_Recordset1['id'] ?>" <?php if ($row_Recordset1['id'] == $row_Recordset2['id_dept']) { ?> selected="selected" <?php } ?>><?php echo $row_Recordset1['department'] ?></option>
                            <?php
                        } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
                        $rows = mysql_num_rows($Recordset1);
                        if ($rows > 0) {
                            mysql_data_seek($Recordset1, 0);
                            $row_Recordset1 = mysql_fetch_assoc($Recordset1);
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td>Document No.</td>
                <td>:</td>
                <td><input type="text" name="doc_no" value="<?php echo $row_Recordset2['doc_no']; ?>" size="32"/></td>
            </tr>
            <tr>
                <td>Revision</td>
                <td>:</td>
                <td><input type="text" name="rev" value="<?php echo $row_Recordset2['rev']; ?>" size="32"/></td>
            </tr>
            <tr>
                <td>Effective Date</td>
                <td>:</td>
                <td><input type="text" name="efect_date" id="tanggal18"
                           value="<?php echo $row_Recordset2['efect_date']; ?>" size="32"/></td>
            </tr>
            <tr>
                <td>Title</td>
                <td>:</td>
                <td><textarea name="title" id="title" cols="45"
                              rows="5"><?php echo $row_Recordset2['title']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="submit" value="Submit"/>
                </td>
            </tr>
        </table>
        <input type="hidden" name="nama_fileps" id="nama_fileps" value="<?php echo $nama_file; ?>"/>
        <input type="hidden" name="nama_fileps2" id="nama_fileps2"
               value="<?php echo $row_Recordset3['fileupload']; ?>"/>
        <input type="hidden" name="inisial_pekerjaan" id="inisial_pekerjaan" value="SOP"/>
        <input type="hidden" name="id" id="id" value="<?php echo $row_Recordset2['id']; ?>"/>

        <!-- <input type="text" name="vidms" id="vidms" value="<?php //echo $row_Recordset3['id']; ?>" /> -->
        <input type="hidden" name="MM_update" value="form1"/>
    </form>

    </body>
    </html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
?>