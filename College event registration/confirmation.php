<?php
include("config.php");

$latest = "SELECT uid FROM user ORDER BY uid DESC LIMIT 1";

$result = $conn->query($latest);

if ($result) {
    $row = $result->fetch_assoc();
    $latestUid = $row['uid'];
} else {
    echo $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parichay 2k24</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="confirm">
        <div class="">
            <div class="confirm-container p-2">
                <div class="printer-top"></div>

                <div class="paper-container">
                    <div class="printer-bottom"></div>

                    <div class="paper">
                        <div class="main-contents">
                            <div class="success-icon">&#10004;</div>
                            <div class="success-title">
                                Registration Complete
                            </div>
                            <div class="success-description">
                                Your registration for Parichay 2K24 is confirmed! See you at the event.
                            </div>
                            <div class="order-details">
                                <div class="order-number-label">UID</div>
                                <div class="order-number"><?php echo $latestUid; ?></div>
                            </div>
                            <div class="order-footer">Thank you!</div>

                        </div>
                        <div class="jagged-edge"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = "/";
        }, 10000);
    </script>

</body>

</html>