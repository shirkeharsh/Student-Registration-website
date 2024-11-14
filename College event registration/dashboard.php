<?php
include('config.php');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$select_fymca_registrations = mysqli_query($conn, "SELECT * FROM `user` WHERE course = 'FY MCA'") or die('query failed');
$fymca_registrations = mysqli_num_rows($select_fymca_registrations);

$select_symca_registrations = mysqli_query($conn, "SELECT * FROM `user` WHERE course = 'SY MCA'") or die('query failed');
$symca_registrations = mysqli_num_rows($select_symca_registrations);

$select_fymba_registrations = mysqli_query($conn, "SELECT * FROM `user` WHERE course = 'FY MBA'") or die('query failed');
$fymba_registrations = mysqli_num_rows($select_fymba_registrations);

$select_symba_registrations = mysqli_query($conn, "SELECT * FROM `user` WHERE course = 'SY MBA'") or die('query failed');
$symba_registrations = mysqli_num_rows($select_symba_registrations);

// Query for the total number of users
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM `user`") or die('query failed');
$total_users_row = mysqli_fetch_assoc($total_users_query);
$total_users = $total_users_row['total_users'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Parichay 2k24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            position: relative;
            margin: 0;
            padding: 0;
            overflow: auto; /* Allow scrolling */
        }

        .animated-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff7b7b, #3498db, #8e44ad, #f39c12);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            z-index: -1;
            filter: blur(10px);
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        h1 {
            font-size: 2.5rem;
            color: #2d3436;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        .total-users {
            font-size: 1.5rem;
            color: #1abc9c;
            margin-left: 20px;
            vertical-align: middle;
        }

        .container {
            max-width: 100%; /* Full width on all screens */
            margin-top: 60px;
            position: relative;
            z-index: 1;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid transparent;
            outline: 2px solid transparent;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            outline: 2px solid #1abc9c;
        }

        .card-title {
            font-size: 1.8rem;
            color: #444;
            font-weight: 600;
        }

        .card-text {
            font-size: 2.2rem;
            font-weight: 500;
            color: #333;
        }

        .d-flex {
            margin-top: 30px;
        }

        .course-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .course-title-mca {
            color: #3498db;
        }

        .course-title-mba {
            color: #e74c3c;
        }

        .card-columns {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card-columns .card {
            width: 48%;
        }

        .card-columns .card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .card-columns .card {
                width: 100%;
            }
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="animated-background"></div>
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="text-center mb-5">
                <h1>Users Dashboard <span class="total-users">(Total Users: <?php echo $total_users; ?>)</span></h1>
            </div>

            <div class="text-center mb-5">
                <div class="course-title course-title-mca">
                    MCA
                </div>
                <div class="card-columns">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">First Year</h5>
                            <p class="card-text"><?php echo $fymca_registrations; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Second Year</h5>
                            <p class="card-text"><?php echo $symca_registrations; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="course-title course-title-mba">
                    MBA
                </div>
                <div class="card-columns">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">First Year</h5>
                            <p class="card-text"><?php echo $fymba_registrations; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Second Year</h5>
                            <p class="card-text"><?php echo $symba_registrations; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
