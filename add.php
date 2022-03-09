<?php

include 'config/db_connect.php';

$title = $email = $ingredients = '';

$errors = array('email' => '', 'title' => '', 'ingredients' => ''); //for holding form errors

//check for form submission
if (isset($_POST["submit"])) {
    // check email field
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required <br>";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        }
    }

    // check title
    if (empty($_POST['title'])) {
        $errors['title'] = "Title is required <br>";
    } else {
        $title = $_POST['title'];

        //define a regexp containing the expected format of the title
        // then match the title with the regexp
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = 'Title must be made up of letters and spaces only';
        }
    }

    // check ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = "At least one ingredient is required <br>";
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) { //check for comma-separated items
            $errors['ingredients'] = 'Ingredients must be a comma-separated list';
        }
    }

    // if errors dont exist, redirect to home page
    if (array_filter($errors)) { //array_filter cycles through the error array to check if values are contained
        // if errors exist

    } else {
        // if no errors exist, save to db

        //mysqli_real_escape_string prevents against sql injections
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        //create sql
        $sql = "INSERT INTO pizzas (title, email, ingredients) VALUES ('$title', '$email', '$ingredients')";

        // save to db and check
        if (mysqli_query($conn, $sql)) { //if successful

        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

        // redirect to index.php
        header('Location: index.php');
    }
}
// end of POST check

?>

<!DOCTYPE html>
<html>
    <?php include "templates/header.php";?>

    <section class="add-form">
        <h4 class="add-title">Add a Pizza</h4>
        <form action="add.php" method="POST">
            <input type="text" name="email" id="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email) ?>"> <!-- value is used to persist the user input -->
            <div class="red-text" style='color:red; margin-top:-20px; font-size:13px'><?php echo $errors['email'] ?></div>

            <input type="text" name="title" id="title" placeholder="Pizza Title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text" style='color:red; margin-top:-20px; font-size:13px'><?php echo $errors['title'] ?></div>

            <input type="text" name="ingredients" id="ingredients" placeholder="Ingredients (comma separated)" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text" style='color:red; margin-top:-20px; font-size:13px'><?php echo $errors['ingredients'] ?></div>

            <input type="submit" value="submit" name="submit">
        </form>
    </section>

    <?php include "templates/footer.php";?>
</html>