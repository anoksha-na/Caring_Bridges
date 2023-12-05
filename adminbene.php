<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'women';

$con = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno()) {
    echo "Connection Error: " . mysqli_connect_errno();
    exit();
}

if (isset($_POST['submit'])) {
    $name            = $_POST['name'];
    $dob             = $_POST['dob'];
    $ph_no           = $_POST['ph_no'];
    $addr            = $_POST['addr'];
    $prgm_name       = $_POST['prgm_name'];

    // Check if the phone number already exists
    $check_query = mysqli_query($con, "SELECT * FROM beneficiary WHERE ph_no = '$ph_no'");
    if (mysqli_num_rows($check_query) > 0) {
        echo "Registration unsuccessful: Phone number already exists.";
        echo "<script>setTimeout(function() { window.location.href = 'bene.html'; }, 1500);</script>";
    } else {
        // Phone number doesn't exist, proceed with the insertion
        $query = mysqli_query($con, "INSERT INTO beneficiary (name, dob, ph_no, addr, prgm_name) 
                                      VALUES ('$name', '$dob', '$ph_no', '$addr', '$prgm_name')");

        if ($query) {
            echo "Registration successful";
            echo "<script>setTimeout(function() { window.location.href = 'home.html'; }, 1500);</script>";
        } else {
            echo "Registration unsuccessful: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>
