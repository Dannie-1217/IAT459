<?php require_once("../../private/functions/initialization.php") ?>

<?php

    if(!isset($_SESSION['user_name'])){
        header("Location: ../staff/general/login.php");
        exit();
    }
  
  $user_name = $_SESSION['user_name'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $q1 = $_POST['q1'];
        $q2 = $_POST['q2'];
        $q3 = $_POST['q3'];
        $q4 = $_POST['q4'];
        if(!empty($q1) && !empty($q2) && !empty($q3) && !empty($q4)){
            if (isset($_SESSION['user_name'])) {
                $user_name = $_SESSION['user_name'];
                $user_query = "SELECT user_id FROM user WHERE user_name = '" . $user_name . "'";
                $user_res = mysqli_query($connection, $user_query);
                $user_id = mysqli_fetch_assoc($user_res)['user_id'];
                $pet_id = $_SESSION['pet_id'];

                date_default_timezone_set('America/Vancouver');
                $date = date('Y-m-d', time());

                $apply = "INSERT INTO adoption_records(user_id, pet_id, adopted_before, other_pets, suitable_living_space, reason_for_adoption, adoption_date, status) 
                    VALUES($user_id, $pet_id, '$q1', '$q2', '$q3', '$q4', '$date', 'Processing')";
                echo $apply;
                $add_res = mysqli_query($connection, $apply);

                if(!$add_res){
                    echo"query faled!";
                    exit;
                }
                else{
                    header("Location: ../staff/adopter/adopter_dashboard.php");
                }

            }
            else{
                header("Location: ../staff/general/login.php");
            }
        }
        else{
            echo "Please Answer ALL Application Questions!";
        }
    }

    require_once(ROOT_PATH . SHARED_PATH.'/header.php');

    echo '<form action="apply_page.php" method="POST" enctype="multipart/form-data">
        <label>Application Form Questions: </label><br>
        <label>Have you adopted a pet before?</label><br>
        <select name="q1">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select> <br>

        <label>Do you have other pets right now?</label><br>
        <select name="q2">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select> <br>

        <label>Do you have a suitable living space for this pet?</label><br>
        <select name="q3">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select> <br>

        <label>Why do you want to adopt this pet?</label><br>
        <input type="text" name="q4" required><br><br>

        <input type="submit" value="Apply">;
    </form>'
?>