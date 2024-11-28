<?php
 function load_allstatus()
 {
    $sql="select * from status";
    return pdo_query($sql);
 }
 function load_onestatus($id)
 {
    $sql="SELECT * FROM status WHERE id=$id";
    return pdo_query($sql);
 }

?>