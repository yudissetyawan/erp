   <?php {include "prosesupload.php";}?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

    <form method="POST" enctype="multipart/form-data" name="form" class="General">
      <table width="700" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td class="General"><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
Attachment File:
  <input name="file" type="file" style="cursor:pointer;" />
  <input type="submit" name="submit" value="Upload" /></td>
      </tr>
    </table>
    </form>