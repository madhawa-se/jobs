<?php

include_once 'wp-config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}





echo 'removing email templates and meta data ... <br>';

$query_post = "select ID from wp_posts where post_type='jh-templates'";
$result = $conn->query($query_post);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $post_id = $row["ID"];

        ////////////////////////////////////////////////////
        $del_terms = "delete from wp_terms where term_id=(select term_id from wp_term_taxonomy where term_taxonomy_id=(select term_taxonomy_id from  wp_term_relationships where object_id='$post_id'))";
        $result1 = $conn->query($del_terms);
        echo "del terms $result1 <br>";
////////////////////////////////////////////////////
////////////////////////////////////////////////////
        $del_term_taxonomy = "delete from wp_term_taxonomy where 'term_taxonomy_id'=(select term_taxonomy_id from  wp_term_relationships where 'object_id'='$post_id')";
        $result2 = $conn->query($del_term_taxonomy);
        echo "del term taxonomy $result2 <br>";
////////////////////////////////////////////////////
////////////////////////////////////////////////////
        $del_term_relationships = "delete from  wp_term_relationships where object_id='$post_id'";
        $result3 = $conn->query($del_term_relationships);
        echo "del term relationships $result3 <br>";
////////////////////////////////////////////////////
////////////////////////////////////////////////////
        $del_postmeta = "delete from  wp_postmeta where post_id='$post_id'";
        $result4 = $conn->query($del_postmeta);
        echo "query $del_postmeta <br>";
        echo "del postmeta $result4 <br>";
////////////////////////////////////////////////////
////////////////////////////////////////////////////
        $del_posts = "delete from  wp_posts where ID='$post_id'";
        $result5 = $conn->query($del_posts);
        echo "del post $result5 <br>";
////////////////////////////////////////////////////


        $up_options = "UPDATE wp_options SET option_value=0 WHERE option_name='templates_already_created'";

        if ($conn->query($up_options) === TRUE) {
            echo "updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "0 results";
}



$conn->close();
echo '<br>finish';
