<!-- for establishing database connection -->

<?php

// connect to mysql db
$conn = mysqli_connect('localhost', 'uduak', 'test1234', 'ninja_pizza'); //host_name, username, pwd, db_name

// check connection
if (!$conn) { //if connection is unsuccessful
    echo 'Connection error: ' . mysqli_connect_error(); // function displays the error name
}

?>