<?php

include 'config/db_connect.php';

// check GET request id parameter
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    //get query results
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows in an array
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    mysqli_close($conn);

}

// delete a record
if (isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        //success
        header('Location: index.php'); //redirect user
    } else {
        // failure
        echo 'query error: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

    <?php include 'templates/header.php';?>

    <div class="pizza-info">
        <!-- if record exists... -->
        <?php if ($pizza): ?>
            <h3><?php echo htmlspecialchars($pizza['title']); ?></h3>
            <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
            <p>Created at: <?php echo date($pizza['created_at']); ?></p>
            <h5>Ingredients:</h5>
            <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

            <!-- delete btn -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
                <input type="submit" value="Delete" name="delete" class="btn">
            </form>

        <?php else: ?>
            <h2>Oops! Not found</h2>
        <?php endif;?>
    </div>

    <?php include 'templates/footer.php';?>

</html>