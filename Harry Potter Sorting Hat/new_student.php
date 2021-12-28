<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/new_student.css">
    <title>Timo Tinder</title>
</head>
<body>
    <?php
        include "./includes/db_util.php";
    ?>
    <div id="background">
        <header id="header">
            <h3 id="logo">Add a new student</h3>
            <div id="home-icon-wrapper"><a href="index.php"><img id="home-icon" src="./assets/images/home.svg" alt="Home"></a><div>
        </header>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['submit'] === "Add a new student")) {
                // send new_student POST data to database
                $new_name = $_POST['new-name'];
                $new_last_name = $_POST['new-last-name'];
                $new_age = $_POST['new-age'];
                $new_gender = $_POST['new-gender'];
                $new_interests = $_POST['new-interests'];
                $new_favorite_animal = $_POST['new-favorite_animal'];
                insertQuery("INSERT INTO students VALUES ('','{$new_name}','{$new_last_name}','{$new_age}','{$new_gender}','{$new_interests}','{$new_favorite_animal}');");
            }
        ?>
        <?php
            if (!($_SERVER["REQUEST_METHOD"] == "POST") && !($_POST['submit'] === "Add a new student")) {
                ?>
                    <div id="body">
                        <form id="student-upload-form" action="./new_student.php" method="POST">
                            <label for="new-name">First name:</label>
                            <input required type="text" name="new-name" id="new-name">

                            <label for="new-last-name">Last name:</label>
                            <input required type="text" name="new-last-name" id="new-last-name">

                            <label for="new-age">Age:</label>
                            <input type="number" name="new-age" min="10" value="12" id="new-age">

                            <label for="new-gender">Gender:</label>
                            <select name="new-gender" id="new-gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                            <label for="new-interests">Interests:</label>
                            <input required type="text" name="new-interests" id="new-interests">

                            <label for="new-favorite_animal">Favorite animal:</label>
                            <input required type="text" name="new-favorite_animal" id="new-favorite_animal">
                        </form>
                    </div>
                    <div id="footer">
                        <input class="no-validate" type="submit" name="submit" form="student-upload-form" value="Add a new student">
                    </div>
                <?php
            }
            else {
                ?>
                    <div id="body">
                        <h3>Student was added successfully</h3>
                    </div>
                    <div id="footer" class="vertical">
                        <a href="new_student.php" class="no-underline">Add another student</a>
                        <a href="sort.php"><button>Start sorting</button></a>
                    </div>
                <?php
            }
        ?>
    </div>
</body>
</html>
