<?php

include 'config/db_connect.php';

// retrieve pizzas from db
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

// make query and get results
$result = mysqli_query($conn, $sql); // makes the query on the db

// fetch the resulting rows as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC); //return the result as an associative array

// free from memory
mysqli_free_result($result);

// close db connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
    <?php include "templates/header.php";?>

    <div class="home-info">
    <h2>Pizzas!</h2>

        <div class="pizza-container">
            <div class="row">

                <!-- cycle through the pizzas retrieved from db and display -->
                <?php foreach ($pizzas as $pizza): ?>

                    <div class="pizza">
                        <div class="card">
                            <img src="images/pizza.png" alt="pizza icon" class="pizza-img">
                            <h3><?php echo htmlspecialchars($pizza['title']); ?></h3>
                            <ul>
                                <!-- split ingredients to array items after a character -->
                                <?php foreach (explode(',', $pizza['ingredients']) as $ing): ?>
                                    <li><?php echo htmlspecialchars($ing); ?></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <hr>
                        <div class="card-btn">
                            <a href="details.php?id=<?php echo $pizza['id'] ?>">More info</a>
                        </div>
                    </div>

                <?php endforeach;?>

            </div>
        </div>
    </div>

    <?php include "templates/footer.php";?>
</html>