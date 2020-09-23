<?php
    include('config/db_connect.php');
    $errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');
    $email = $title = $ingredients = "";

    // POST Validation
    if(isset($_POST['submit'])){ // This checks if the submit value is not null

        // Check email
        if(empty($_POST['email'])){
            $errors['email'] =  "An email is required";
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = "Email must be a valid email address";
            }
        }

        //Check title
        if(empty($_POST['title'])){
            $errors['title'] = "A title is required";
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
                $errors['title'] = "Title can not contain special characters";
            }
        }

        // Check ingredients
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = "At least one ingredient is required";
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingredients)){
                $errors['ingredients'] = "Ingredients must be a comma seperated list";
            }

        }
        if(!array_filter($errors)){ // Check if error strings are all "" and if so redirect
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            // Create SQL statement
            $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

            // save to db and check
            if(mysqli_query($conn, $sql)){
                // success
            } else {
                echo "Query error: " . mysqli_error($conn);
            }

            header('Location: index.php');
        }
    } // End of POST validation


?>

<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>
            <label>Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label>Ingredients (comma seperated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input class="btn brand z-depth-0" type="submit" name="submit" value="submit">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</html>