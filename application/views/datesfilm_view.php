<?php
 $json = [];
 foreach ($dates as $valueD) {
        $json[] = [ 'value1' => $valueD, 'value2' => date_format( date_create($valueD), 'd.m.Y') ];
 }
 echo json_encode($json);
?>
