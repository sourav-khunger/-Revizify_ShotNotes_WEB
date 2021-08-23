<?php

$ids = array(28, 31, 53, 65);

$ids = join(', ', $ids);
$query = "SELECT * FROM user_info WHERE id IN ($ids)";
// $query => SELECT * FROM business WHERE business_id IN (1, 2, 3, 4)
echo $query;
?>