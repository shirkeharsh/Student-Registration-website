<?php
session_start();

$correct_password = "jerry123";

if (!isset($_SESSION['logged_in'])) {
    if (isset($_POST['password']) && $_POST['password'] === $correct_password) {
        $_SESSION['logged_in'] = true;
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Password Protected</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
                
                body {
                    background-color: #f0f4f8;
                    font-family: 'Inter', sans-serif;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    overflow: hidden;
                    position: relative;
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
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }

                .container {
                    max-width: 450px;
                    background-color: rgba(255, 255, 255, 0.9);
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    position: relative;
                    z-index: 1;
                }
                form h2 {
                    font-size: 2rem;
                    color: #2d3436;
                    font-weight: 600;
                    margin-bottom: 25px;
                }
                input[type="password"] {
                    font-size: 1.1rem;
                    padding: 15px;
                    width: 100%;
                    border-radius: 10px;
                    border: 2px solid #ddd;
                    margin-bottom: 20px;
                    outline: none;
                    transition: border-color 0.3s;
                }
                input[type="password"]:focus {
                    border-color: #1abc9c;
                    box-shadow: 0 0 10px rgba(26, 188, 156, 0.5);
                }
                button {
                    font-size: 1.2rem;
                    padding: 15px 30px;
                    background-color: #1abc9c;
                    color: #ffffff;
                    border: none;
                    border-radius: 30px;
                    width: 100%;
                    cursor: pointer;
                    transition: background-color 0.3s, transform 0.2s;
                }
                button:hover {
                    background-color: #16a085;
                    transform: translateY(-3px);
                }
                button:active {
                    transform: translateY(1px);
                }
            </style>
        </head>
        <body>
            <div class="animated-background"></div>
            <div class="container">
                <form method="post">
                    <h2>Access Denied</h2>
                    <input type="password" name="password" required placeholder="Enter password">
                    <button type="submit">Enter</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit(); 
    }
}

include('../config.php');

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
            background-color: #ecf0f1;
            font-family: 'Inter', sans-serif;
            color: #333;
            position: relative;
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
            max-width: 1200px;
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
    <?php
    include('navbar.html');
    ?>
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="text-center mb-5">
                <h1>Admin Dashboard <span class="total-users">(Total Users: <?php echo $total_users; ?>)</span></h1>
            </div>

            <div class="text-center mb-5">
                <div class="course-title course-title-mca">
                    MCA
                </div>
                <div class="card-columns">
                    <a href="fymca.php" class="card">
                        <div class="card-body">
                            <h5 class="card-title">First Year</h5>
                            <p class="card-text"><?php echo $fymca_registrations; ?></p>
                        </div>
                    </a>
                    <a href="symca.php" class="card">
                        <div class="card-body">
                            <h5 class="card-title">Second Year</h5>
                            <p class="card-text"><?php echo $symca_registrations; ?></p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="course-title course-title-mba">
                    MBA
                </div>
                <div class="card-columns">
                    <a href="fymba.php" class="card">
                        <div class="card-body">
                            <h5 class="card-title">First Year</h5>
                            <p class="card-text"><?php echo $fymba_registrations; ?></p>
                        </div>
                    </a>
                    <a href="symba.php" class="card">
                        <div class="card-body">
                            <h5 class="card-title">Second Year</h5>
                            <p class="card-text"><?php echo $symba_registrations; ?></p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
