<?php

$j = 0;

foreach($results as $result){

  $records[$j] = array('id' => $result->id,
                       'label' => $result->$item,
                       'value' => $result->$item
                     );
 $j++;                  
}

echo json_encode($records);
?>