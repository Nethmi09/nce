<?php
include '../../function.php';

extract($_GET);

$db = dbConn();
$sql = "SELECT * FROM sub_modules WHERE module_id='$ModuleId'";
$result = $db->query($sql);
?>
<select name="sub_module" id="sub_module" class="form-control">
   <option value="" disabled selected>Select Sub Module</option>  
    <?php
    while ($row = $result->fetch_assoc()) {
        ?>
        <option value="<?= $row['Id'] ?>" <?= @$selsubmodule == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
        <?php
    }
    ?>
</select>
