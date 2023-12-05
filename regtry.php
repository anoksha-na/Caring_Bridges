<?php
session_start(); // Start the session

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'women';

$con = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno()) {
    echo "Connection Error: " . mysqli_connect_errno();
    exit();
}

if (isset($_SESSION['user_id'])) {
    $women_id = $_SESSION['user_id']; 

    // Associating scheme names with IDs
    $schemes = [
        'Stree Shakthi' => 1,
        'Shanthwana' => 2,
        'Swayam Siddha' => 3,
        'Mahila Udyam Nidhi' => 4,
        'Bhagyalakshmi' => 5,
        'Dena Shakti' => 6
    ];

    if (isset($_POST['submit'])) {
        $scheme_name = $_POST['scheme_name'];
        $name = $_POST['field_1'];
        $age = $_POST['field_2'];
        $district = $_POST['field_3'];
        $taluk = $_POST['field_4'];
        $phone = $_POST['field_5'];
        $marital_status = $_POST['field_6'];

        if (array_key_exists($scheme_name, $schemes)) {
            $scheme_id = $schemes[$scheme_name];

            $check_query = mysqli_query($con, "SELECT * FROM scheme_reg WHERE Phone_No = '$phone'");
            if (mysqli_num_rows($check_query) > 0) {
                echo "Registration unsuccessful: Phone number already exists.";
                echo "<script>setTimeout(function() { window.location.href = 'regtry.html'; }, 1500);</script>";
            } else {
                $unique_name = ''; // Initialize $unique_name

                if ($marital_status === 'married' && isset($_FILES['image'])) {
                    $image_tmp = $_FILES['image']['tmp_name'];
                    $image_name = $_FILES['image']['name'];
                    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                    $valid_extensions = array('jpg', 'jpeg', 'png');
                    if (!in_array($image_ext, $valid_extensions)) {
                        echo "Invalid file type. Please upload a valid image.";
                        echo "<script>setTimeout(function() { window.location.href = 'regtry.html'; }, 1500);</script>";
                        exit();
                    }

                    $unique_name = time() . '_' . uniqid() . '.' . $image_ext;
                    $upload_path = 'uploads/';

                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, true);
                    }

                    $upload_result = move_uploaded_file($image_tmp, $upload_path . $unique_name);

                    if (!$upload_result) {
                        echo "Error uploading image. Please try again.";
                        echo "<script>setTimeout(function() { window.location.href = 'regtry.html'; }, 1500);</script>";
                        exit();
                    }
                } elseif ($marital_status === 'married') {
                    echo "Image not uploaded.";
                    echo "<script>setTimeout(function() { window.location.href = 'regtry.html'; }, 1500);</script>";
                    exit();
                }

                if (isset($_FILES['age_proof'])) {
                    $age_proof_tmp = $_FILES['age_proof']['tmp_name'];
                    $age_proof_name = $_FILES['age_proof']['name'];
                    $age_proof_ext = strtolower(pathinfo($age_proof_name, PATHINFO_EXTENSION));

                    $valid_extensions = array('jpg', 'jpeg', 'png');
                    if (!in_array($age_proof_ext, $valid_extensions)) {
                        echo "Invalid file type. Please upload a valid image.";
                        echo "<script>setTimeout(function() { window.location.href = 'regtry.html'; }, 1500);</script>";
                        exit();
                    }

                    $age_proof_data = file_get_contents($age_proof_tmp);
                }

                $query = mysqli_prepare($con, "INSERT INTO scheme_reg (s_id, Scheme_name, Name, Age, age_img, District, Taluk, Phone_No, Marital_status, Image, women_id) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                mysqli_stmt_bind_param($query, "sssssssssss", $scheme_id, $scheme_name, $name, $age, $age_proof_data, $district, $taluk, $phone, $marital_status, $unique_name, $women_id);

                if (mysqli_stmt_execute($query)) {
                    echo "Registration successful";
                    echo "<script>setTimeout(function() { window.location.href = 'scheme.html'; }, 1500);</script>";
                } else {
                    echo "Registration unsuccessful: " . mysqli_stmt_error($query);
                }

                mysqli_stmt_close($query);
            }
        } else {
            echo "Invalid scheme name";
        }
    }
} else {
    echo "User ID not found in session";
}

mysqli_close($con);
?>
