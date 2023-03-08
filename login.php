<?php
session_start();
require_once 'api/TestCase/db_connection.php';

// If the user is already logged in, redirect them to the home page
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// If the login form was submitted
if (isset($_POST['submit'])) {
    // get the email and password from the form
    $email = $_POST['username'];
    $password = $_POST['password'];

    // query the database to find the user with the matching email and hashed password
    $query = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password')";
    $result = mysqli_query($conn, $query);

    // check if a matching user was found
    if (mysqli_num_rows($result) == 1) {

        // log the user in by storing their user ID in the session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        // redirect the user to the home page
        header('Location: index.php');
        exit();
    } else {

        // display an error message if the email or password is incorrect
        $error = 'Invalid email or password';
    }

    // close the database connection
    //mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="www/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>TestStorm | Login</title>
    <style>
        .bg {
            /*background-image: url("../TestStorm/www/img/background.jpg");*/
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;

        }


        div.scroll {
            height: 90vh;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: center;
            padding: 20px;
        }

        .wiggle {
            /* Start the shake animation and make the animation last for 0.5 seconds */
            animation: shake 5s;
            transition-timing-function: ease;

            /* Also the same as */
            transition-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
            /* When the animation is finished, start again */
            animation-iteration-count: infinite;
        }

        @keyframes shake {
            0% {
                transform: translate(1px, -90px) rotate(-3deg);
            }

            10% {
                transform: translate(-1px, -90px) rotate(-1deg);
            }

            20% {
                transform: translate(-3px, -90px) rotate(1deg);
            }

            30% {
                transform: translate(40px, -70px) rotate(0deg);
            }

            40% {
                transform: translate(35px, -70px) rotate(1deg);
            }

            50% {
                transform: translate(30px, -70px) rotate(-1deg);
            }

            60% {
                transform: translate(-3px, -80px) rotate(0deg);
            }

            70% {
                transform: translate(3px, -90px) rotate(-1deg);
            }

            80% {
                transform: translate(-1px, -90px) rotate(1deg);
            }

            90% {
                transform: translate(1px, -90px) rotate(-2deg);
            }

            100% {
                transform: translate(1px, -90px) rotate(-3deg);
            }
        }
    </style>
</head>

<body class="bg">


    <div style="height:100vh " class="d-flex justify-content-center d-flex align-content-center flex-wrap rounded">
        <div class="w-50 shadow-lg p-3 mb-2 bg-body rounded">
            <a class="navbar-brand" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="black" class="wiggle bi bi-cloud-lightning-rain-fill m-3" viewBox="0 0 16 16">
                    <path d="M2.658 11.026a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.5 1.5a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.105-1.25A.5.5 0 0 1 7.5 11h1a.5.5 0 0 1 .474.658l-.28.842H9.5a.5.5 0 0 1 .39.812l-2 2.5a.5.5 0 0 1-.875-.433L7.36 14H6.5a.5.5 0 0 1-.447-.724l1-2zm6.352-7.249a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 10H13a3 3 0 0 0 .405-5.973z" />
                </svg>
            </a>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="username" class="form-control" id="username">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="w-50 mx-auto d-flex justify-content-center d-flex align-content-center flex-wrap">
                    <button name="submit" type="submit" class="btn btn-primary">Sign in</button>
                </div>
                <?php if (isset($error)) {
                    echo "<p>$error</p>";
                } ?>
            </form>

        </div>
    </div>
</body>

</html>