<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sort.css">
    <title>Timo Sorting Hat</title>
</head>
<body>
    <?php
        include "./includes/db_util.php";
    ?>
    <div id="background">
        <header id="header">
            <h3 id="logo">Sorting Hat</h3>
            <div id="home-icon-wrapper"><a href="index.php"><img id="home-icon" src="./assets/images/home.svg" alt="Home"></a><div>
        </header>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // set session id and student index
                $student_index = $_POST['student-index'];
                if ($_POST['session-id'] !== null) {
                    $session_id = $_POST['session-id'];
                }
            }
            else {
                $session_id = random_int(0, 10000);
            }
            // get all students
            $students_sql = "SELECT * FROM students";
            $students = getQuery($students_sql);

            // Sorting the previous student
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $previous_student_id = $student_index;
                $previous_student_house = $_POST['submit']; // Takes house name from submit button
                insertQuery("INSERT INTO sortings VALUES ('','$previous_student_id', '$previous_student_house','$session_id');");
            }

            // if student index is invalid, revert to first student
            if (is_numeric($student_index)) {
                $current_student_index = $student_index;
            }
            else {
                $current_student_index = '0';
            }

        ?>
        <?php // page content
          
            if ($current_student_index < count($students)) {
                // sort a student
                ?>
                <div id="body" class="rating-body">
                    <div class="infobox">
                        <h3>
                            <?php echo $students[$current_student_index]['first_name'];?>, <?php echo $students[$current_student_index]['age']; ?>
                        </h3>
                        <div><?php echo $students[$current_student_index]['gender']; ?></div>
                        <br>
                        <div><em>Interests:</em> <?php echo $students[$current_student_index]['interests']; ?></div>
                        <div><em>Favorite animal:</em> <?php echo $students[$current_student_index]['favorite_animal']; ?></div>
                    </div>
                    <div class="row">
                        <label id="gryffindor-button"  class="dislike button-style-label icon-wrapper" for="submit-gryffindor">
                        </label>
                        <input hidden type="submit" name="submit" id="submit-gryffindor" value="Gryffindor" form="hidden-user-details-form">

                        <label id="slytherin-button" class="like button-style-label icon-wrapper" for="submit-slytherin" style="background-image: url('./assets/images/slytherin.jpeg');background-position: center;background-repeat: no-repeat;background-size: cover;";>
                        </label>
                        <input hidden type="submit" name="submit" id="submit-slytherin" value="Slytherin" form="hidden-user-details-form">
                    </div>

                    <div class="row">
                        <label id="ravenclaw-button"  class="like button-style-label icon-wrapper" for="submit-ravenclaw">
                        </label>
                        <input hidden type="submit" name="submit" id="submit-ravenclaw" value="Ravenclaw" form="hidden-user-details-form">

                        <label id="hufflepuff-button"  class="like button-style-label icon-wrapper" for="submit-hufflepuff">
                        </label>
                        <input hidden type="submit" name="submit" id="submit-hufflepuff" value="Hufflepuff" form="hidden-user-details-form">
                    </div>
                    <!-- -->
                    <form id="hidden-user-details-form" action="./sort.php" method="POST">
                        <input hidden type="number" name="session-id" id="session-id" value="<?php echo intval($session_id)?>">
                        <input hidden type="number" name="student-index" id="student-index" value="<?php echo intval($current_student_index) + 1?>">
                    </form>
                </div>
                <div id="footer">
                </div>
                <?php
            }
            else {
                // results page
                function generate_results_sql($house, $session_id){
                    return "SELECT * FROM students WHERE student_id IN (SELECT sorted_student_id FROM sortings WHERE session_id = '{$session_id}' AND house = '{$house}')";  
                }
                $gryffindor_results = getQuery(generate_results_sql('Gryffindor', $session_id));
                $slytherin_results = getQuery(generate_results_sql('Slytherin', $session_id));
                $ravenclaw_results = getQuery(generate_results_sql('Ravenclaw', $session_id));
                $hufflepuff_results = getQuery(generate_results_sql('Hufflepuff', $session_id));
                ?>
                    <div id="body">
                        <h3>Here is your summary:</h3>
                        <?php
                            if (count($gryffindor_results) === 0) {
                                echo "<p>Gryffindor gained no members<p>";
                            }
                            else {
                                ?>
                                <div> Gryffindor members:
                                    <ul>
                                        <?php
                                        foreach ($gryffindor_results as $gryffindor_result){
                                            $name = $gryffindor_result['first_name'];
                                            echo "<li>{$name}</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            if (count($slytherin_results) === 0) {
                                echo "<p>Slytherin gained no members<p>";
                            }
                            else {
                                ?>
                                <div> Slytherin members:
                                    <ul>
                                        <?php
                                        foreach ($slytherin_results as $slytherin_result){
                                            $name = $slytherin_result['first_name'];
                                            echo "<li>{$name}</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            if (count($ravenclaw_results) === 0) {
                                echo "<p>Ravenclaw gained no members<p>";
                            }
                            else {
                                ?>
                                <div> Ravenclaw members:
                                    <ul>
                                        <?php
                                        foreach ($ravenclaw_results as $ravenclaw_result){
                                            $name = $ravenclaw_result['first_name'];
                                            echo "<li>{$name}</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            if (count($hufflepuff_results) === 0) {
                                echo "<p>Hufflepuff gained no members<p>";
                            }
                            else {
                                ?>
                                <div> Hufflepuff members:
                                    <ul>
                                        <?php
                                        foreach ($hufflepuff_results as $hufflepuff_result){
                                            $name = $hufflepuff_result['first_name'];
                                            echo "<li>{$name}</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div id="footer">
                    </div>
                <?php
            }
        ?>
    </div>
    <script type="text/javascript">
        // disableButtonAndSubmit() {
        //     document.getElementById('submit-like').disabled = true;
        //     this.form.submit();
        // }
    </script>
</body>
</html>
