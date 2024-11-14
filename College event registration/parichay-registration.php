<?php
include("config.php");

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$duplicatePhoneError = false;

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $rollno = mysqli_real_escape_string($conn, $_POST['rollno']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);

    $sql = "INSERT INTO `user` (`uid`, `first_name`, `last_name`, `gender`, `phone`, `email`, `course`, `rollno`) 
            VALUES ('$uid', '$fname', '$lname', '$gender', '$phone', '$email', '$course', '$rollno')";

    if (mysqli_query($conn, $sql)) {
        header('location: confirmation.php');
        exit();
    } else {
        if (mysqli_errno($conn) == 1062 && strpos(mysqli_error($conn), 'phone') !== false) {
            $duplicatePhoneError = true;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parichay Registration</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="bg">
        <video id="background-video" autoplay loop muted>
            <source src="./assets/bg.mp4">
        </video>
        <div class="d-flex container justify-content-center align-items-center">
            <form action="" class="form" method="POST">
                <div class="row justify-content-center align-items-center">
                    <div class="register container col-lg-8 col-10 p-lg-5" style="margin-top: 5rem; margin-bottom: 9rem;">
                        <div class="p-3 text-center">
                            <h2>Parichay - 2024</h2>
                        </div>
                        <div class="row">
                            <div class="py-2 details col-12">
                                <h3><i class="bi bi-person-circle"></i><span><strong>Fill up your details</strong></span></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="form-gender" class="form-label">Gender:</label>
                                <select name="gender" class="form-control" id="form-gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone" required minlength="10" pattern="[1-9]{1}[0-9]{9}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="email" class="form-label">E-Mail:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="form-course" class="form-label">Course:</label>
                                <select name="course" class="form-control" id="form-course" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="FY MCA">FY MCA</option>
                                    <option value="SY MCA">SY MCA</option>
                                    <option value="FY MBA">FY MBA</option>
                                    <option value="SY MBA">SY MBA</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="rollno" class="form-label">Roll Number:</label>
                                <input type="text" class="form-control" id="rollno" name="rollno" required pattern="^[1-9]$|^[1-9][0-9]{2}$">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="uid" class="form-label">Your UID:</label>
                                <?php
                                function generateUniqueUID()
                                {
                                    $current_uid = (int) file_get_contents('uid.txt');
                                    $current_uid++;
                                    $number = str_pad($current_uid % 100000, 5, '0', STR_PAD_LEFT);
                                    $uid = "PARICHAY{$number}";
                                    file_put_contents('uid.txt', $current_uid);
                                    return $uid;
                                }

                                $unique_uid = generateUniqueUID();
                                ?>
                                <input type="text" class="form-control" id="uid" value="<?php echo $unique_uid; ?>" readonly name="uid" required>
                            </div>
                        </div>
                        <div class="py-3">
                            <input class="form-check-input" id="checkbox" type="checkbox" value="" required> I confirm that the
                            information given in this form is true, complete, and accurate.
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="text-center m-2">
                                <button class="btn btn-primary" id="submit-btn" name="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if ($duplicatePhoneError): ?>
    <!-- Modal for duplicate phone error -->
    <div class="modal fade" id="duplicatePhoneModal" tabindex="-1" aria-labelledby="duplicatePhoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="duplicatePhoneModalLabel">Registration Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    User already registered. Please contact admin for support.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='https://parichay.hrshshirke.site'">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var duplicatePhoneModal = new bootstrap.Modal(document.getElementById('duplicatePhoneModal'));
            duplicatePhoneModal.show();
        });
    </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
