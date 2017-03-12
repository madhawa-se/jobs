<?php

$db = new mysqli('localhost', 'user', 'pass', 'demo');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$post_ids=array(1,2,3,4,5,6,7,8,9,10);