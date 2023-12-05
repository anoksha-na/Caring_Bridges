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

// Fetch data from the child_reg table
$query = "SELECT * FROM child_reg";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching data: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Registration Data</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('su1.jpg') center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: black;
            text-align: center;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            overflow: hidden; /* Added to hide overflowing border-radius */
            border-radius : 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: black;
        }

        th {
            background-color: white;
        }

        tbody tr {
            background-color: white; /* Background color for table rows */
        }

        tbody tr:nth-child(even) {
            background-color: white; /* Alternate background color for even rows */
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>

    <h2>Child Registration Data</h2>

    <table>
        <thead>
            <tr>
                <th>Child ID</th>
                <th>Scheme ID</th>
                <th>Scheme Name</th>
                <th>Child Name</th>
                <th>Mother's Name</th>
                <th>Age</th>
                <th>Age Proof Image</th>
                <th>Gender</th>
                <th>Vaccination Status</th>
                <th>Education Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['child_id']}</td>";
                echo "<td>{$row['sch_id']}</td>";
                echo "<td>{$row['sch_name']}</td>";
                echo "<td>{$row['cname']}</td>";
                echo "<td>{$row['womname']}</td>";
                echo "<td>{$row['age']}</td>";
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['age_imgs']) . "' alt='Age Proof'></td>";
                echo "<td>{$row['gender']}</td>";
                echo "<td>{$row['vacc']}</td>";
                echo "<td>{$row['edu']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
mysqli_close($con);
?>
