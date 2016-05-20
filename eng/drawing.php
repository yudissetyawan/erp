<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php {include "prosesupload.php";}?>
<form method="post" enctype="multipart/form-data" name="form" class="General" id="form4">
  <table width="700" border="1" cellspacing="0" cellpadding="2">
    <tr>
      <td class="General"><table width="700" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td class="General"> Attachment File:
            <input name="file" type="file" style="cursor:pointer;" />
            <input type="submit" name="submit" value="Upload" /></td>
        </tr>
      </table>
       </td>
    </tr>
  </table>
</form>
</body>
</html>