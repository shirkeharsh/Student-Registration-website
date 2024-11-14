<?php
include('../config.php');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reset'])){
    mysqli_query($conn, "UPDATE user SET status = NULL WHERE course = 'FY MBA'");
}

$select_fymba_registrations = mysqli_query($conn, "SELECT * FROM user WHERE course = 'FY MBA'") or die('query failed');
$fymba_registrations = mysqli_num_rows($select_fymba_registrations);

$select_fymba_attended = mysqli_query($conn, "SELECT * FROM user WHERE course = 'FY MBA' AND status = 'approved';") or die('query failed');
$fymba_attended = mysqli_num_rows($select_fymba_attended);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $uid = $_GET['uid'];

    switch ($action) {
        case 'approve':
            mysqli_query($conn, "UPDATE user SET status = 'approved' WHERE uid = '$uid'") or die('Query failed');
            break;

        case 'cancel':
            mysqli_query($conn, "UPDATE user SET status = 'cancelled' WHERE uid = '$uid'") or die('Query failed');
            break;

        case 'wipe':
            mysqli_query($conn, "UPDATE user SET status = NULL WHERE uid = '$uid'") or die('Query failed');
            break;

        case 'remove':
            mysqli_query($conn, "DELETE FROM user WHERE uid = '$uid'") or die('Query failed');
            break;

        default:
            echo "Invalid action.";
            break;
    }
}

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Parichay 2k24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* General Text and Layout Improvements */
        body {
            font-size: 1rem;
        }

        h1, h2, h5 {
            font-size: 1.25rem;
        }

        .card-body {
            font-size: 1rem;
        }

        /* Action Buttons Styling */
        .btn-approve {
            border: 2px solid green;
            color: green;
            font-size: 0.85rem;
            padding: 4px 10px;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-approve.approved {
            background-color: red;
            color: white;
        }

        .btn-approve:hover {
            background-color: lightgreen;
            color: green;
        }

        .btn-cancel {
            border: 2px solid green;
            color: green;
            font-size: 0.85rem;
            padding: 4px 10px;
        }

        .btn-cancel:hover {
            background-color: green;
            color: white;
        }

        .btn-wipe {
            border: 2px solid #4682B4;
            color: #4682B4;
            font-size: 0.85rem;
            padding: 4px 10px;
        }

        .btn-wipe:hover {
            background-color: #ADD8E6;
            color: white;
        }

        .btn-remove {
            border: 2px solid #808080;
            color: #808080;
            font-size: 0.85rem;
            padding: 4px 10px;
        }

        .btn-remove:hover {
            background-color: gray;
            color: white;
        }

        /* Reset Button Styling */
        .btn-outline-danger {
            border: 1px solid red;
            color: red;
            font-size: 0.85rem;
            padding: 6px 16px;
        }

        .btn-outline-danger:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body class="bg-light">
    <?php
    include('navbar.html');
    ?>
    <div class="container py-5">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 animate__animated animate__fadeIn">FYMBA</h1>
            </div>
        </div>
        
        <div class="container text-center">
            <h2 class="animate__animated animate__fadeInUp">Attendance Overview</h2>
            <div class="d-flex flex-lg-row flex-column justify-content-center align-items-center">
                
                <div class="card m-3 shadow-lg animate__animated animate__fadeInUp animate__delay-1s" style="width: 12rem; height: 8rem;">
                    <div class="card-body">
                        <h5 class="card-title">Registered</h5>
                        <p class="card-text">
                            <?php echo $fymba_registrations; ?>
                        </p>
                    </div>
                </div>

                <div class="card m-3 shadow-lg animate__animated animate__fadeInUp animate__delay-1s" style="width: 12rem; height: 8rem;">
                    <div class="card-body">
                        <h5 class="card-title">Attended</h5>
                        <p class="card-text">
                            <?php echo $fymba_attended; ?>
                        </p>
                    </div>
                </div>
            </div>

            <h2 class="animate__animated animate__fadeInUp animate__delay-2s">FY MBA - Registrations</h2>
            <div class="card shadow-lg animate__animated animate__fadeInUp animate__delay-2s">
                <div class="card-body">
                    <div class="d-flex row card-head justify-content-between">
                        <h5 class="col-6 card-title">Total Registrations</h5>
                        <input type="text" class="col form-control me-2" id="fysearchInput" placeholder="Search by UID, Name, Phone, RollNo" aria-label="Search" aria-describedby="search">
                        <span class="col">
                            <a href="?reset"><button type="button" class="w-100 btn btn-outline-danger me-5">Reset</button></a>
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="fytable">
                            <thead>
                                <tr>
                                    <th scope="col">UID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">RollNo</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select_users = mysqli_query($conn, "SELECT * FROM user WHERE course = 'FY MBA' ORDER BY uid ASC") or die('query failed');
                                if (mysqli_num_rows($select_users) > 0) {
                                    while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                                ?>
                                    <tr <?php echo ($fetch_users['status'] == 'approved' ? 'class="table-success"' : ($fetch_users['status'] == 'cancelled' ? 'class="table-danger"' : '')); ?> >
                                        <td><b><?php echo $fetch_users['uid']; ?></b></td>
                                        <td><?php echo $fetch_users['first_name'] . " " . $fetch_users['last_name']; ?></td>
                                        <td><?php echo $fetch_users['phone']; ?></td>
                                        <td><?php echo $fetch_users['rollno']; ?></td>
                                        <td><?php echo $fetch_users['gender']; ?></td>
                                        <td>
                                            <!-- Approve / Cancel button -->
                                            <a href="?action=<?php echo $fetch_users['status'] == 'approved' ? 'cancel' : 'approve'; ?>&uid=<?php echo $fetch_users['uid']; ?>">
                                                <button class="btn btn-approve m-1 <?php echo $fetch_users['status'] == 'approved' ? 'approved' : ''; ?>">
                                                    <?php echo $fetch_users['status'] == 'approved' ? 'Cancel' : 'Approve'; ?>
                                                </button>
                                            </a>

                                            <!-- Clear Status -->
                                            <a href="?action=wipe&uid=<?php echo $fetch_users['uid']; ?>">
                                                <button class="btn btn-wipe m-1">Clear</button>
                                            </a>

                                            <!-- Remove User -->
                                            <a href="?action=remove&uid=<?php echo $fetch_users['uid']; ?>">
                                                <button class="btn btn-remove m-1">Remove</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">No Users Registered yet!</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle approve button color on click
        document.querySelectorAll('.btn-approve').forEach(button => {
            button.addEventListener('click', function() {
                if (this.classList.contains('approved')) {
                    this.classList.remove('approved');
                } else {
                    this.classList.add('approved');
                }
            });
        });

        // Search functionality for the table
        const fysearchInput = document.getElementById('fysearchInput');
        const fytable = document.getElementById('fytable');
        fysearchInput.addEventListener('keyup', function() {
            const filter = fysearchInput.value.toUpperCase();
            const trs = fytable.getElementsByTagName('tr');
            for (let i = 0; i < trs.length; i++) {
                const tds = trs[i].getElementsByTagName('td');
                let isMatch = false;
                for (let j = 0; j < 4; j++) {
                    const txtValue = tds[j] ? tds[j].textContent || tds[j].innerText : '';
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        isMatch = true;
                    }
                }
                trs[i].style.display = isMatch ? '' : 'none';
            }
        });
    </script>

</body>

</html>
