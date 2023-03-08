<?php

session_start();
if (isset($_POST['logout'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
}
// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// Connect to MySQL database
$conn = mysqli_connect("localhost", "root", "", "testbase");

// Retrieve all videos from database
$result = mysqli_query($conn, "SELECT * FROM testcase");
// Loop through video records and output HTML5 video tag for each one

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="www/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>TestStorm</title>
    <style>
        div.scroll {
            height: 90vh;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: center;
            padding: 20px;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            fetch('http://safwane.ddns.net/teststorm/api/statistics/result.php')
                .then(response => response.json())
                .then(data => {
                    const result = data; // assuming the API response is {"Passed":"27","Failed":"26"}
                    var data = google.visualization.arrayToDataTable([
                        ['Tests', 'Count'],
                        ['Passed', parseInt(result.Passed)],
                        ['Failed', parseInt(result.Failed)]
                    ]);


                    var options = {
                        title: 'Tests Result',
                        colors: ['#68B984', '#FC5185']
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                })
                .catch(error => console.error(error));

        }
    </script>



</head>

<body class="container-fluid">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cloud-lightning-rain-fill" viewBox="0 0 16 16">
                    <path d="M2.658 11.026a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.5 1.5a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.105-1.25A.5.5 0 0 1 7.5 11h1a.5.5 0 0 1 .474.658l-.28.842H9.5a.5.5 0 0 1 .39.812l-2 2.5a.5.5 0 0 1-.875-.433L7.36 14H6.5a.5.5 0 0 1-.447-.724l1-2zm6.352-7.249a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 10H13a3 3 0 0 0 .405-5.973z" />
                </svg>
                Test Storm

            </a>
            <code class="fs-6">Raining Bugs and Errors</code>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarSupportedContent">
                <form method="post">
                    <span>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo $_SESSION['user_name'];
                        } ?>
                    </span>
                    <button class="btn btn-light btn-sm rounded" name="logout" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div>
                <div id="piechart" style="height: 500px;"></div>
            </div>
        </div>
        <div class="col-md-8 scroll">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Test name" aria-label="Test name" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary rounded" type="button" id="button-addon2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </div>
            <?php
            while ($row = mysqli_fetch_array($result)) : ?>

                <div class="accordion accordion-flush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">

                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $row['Name'] ?>" aria-expanded="false" aria-controls="<?= $row['Name'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;" width="32" height="32" fill="currentColor" class="bi bi-unity mb-2" viewBox="0 0 16 16">
                                    <path d="M15 11.2V3.733L8.61 0v2.867l2.503 1.466c.099.067.099.2 0 .234L8.148 6.3c-.099.067-.197.033-.263 0L4.92 4.567c-.099-.034-.099-.2 0-.234l2.504-1.466V0L1 3.733V11.2v-.033.033l2.438-1.433V6.833c0-.1.131-.166.197-.133L6.6 8.433c.099.067.132.134.132.234v3.466c0 .1-.132.167-.198.134L4.031 10.8l-2.438 1.433L7.983 16l6.391-3.733-2.438-1.434L9.434 12.3c-.099.067-.198 0-.198-.133V8.7c0-.1.066-.2.132-.233l2.965-1.734c.099-.066.197 0 .197.134V9.8L15 11.2Z" />
                                </svg>
                                <legend class="fs-5">
                                    <?= $row['Name'] ?>
                                </legend>
                                <?php
                                if ($row['ResultState'] == 'Passed') {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16">
                                    <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                  </svg>';
                                } else {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cloud-lightning-rain-fill" viewBox="0 0 16 16">
                                    <path d="M2.658 11.026a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.5 1.5a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm9.5 0a.5.5 0 0 1 .316.632l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.316zm-7.105-1.25A.5.5 0 0 1 7.5 11h1a.5.5 0 0 1 .474.658l-.28.842H9.5a.5.5 0 0 1 .39.812l-2 2.5a.5.5 0 0 1-.875-.433L7.36 14H6.5a.5.5 0 0 1-.447-.724l1-2zm6.352-7.249a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 10H13a3 3 0 0 0 .405-5.973z"/>
                                  </svg>';
                                }
                                ?>

                                <span class="badge <?php if ($row['ResultState'] == 'Passed') {
                                                        echo 'bg-success';
                                                    } else {
                                                        echo 'bg-danger';
                                                    } ?> ms-5"> <?= $row['ResultState'] ?></span>
                            </button>
                        </h2>
                        <div id="<?= $row['Name'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 alert alert-light">
                                            <div class="alert alert-light rounded" role="alert">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-filetype-mp4" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM.706 15.849v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026L.805 11.85H0v3.999h.706Zm5.278-3.999h-1.6v3.999h.792v-1.342h.803c.287 0 .53-.057.732-.173.203-.117.357-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.237.241.794.794 0 0 1-.375.082h-.66V12.48h.66c.219 0 .39.06.513.181.123.122.184.296.184.522Zm1.505-.032c.266-.434.53-.867.791-1.301h1.14v2.62h.49v.638h-.49v.741h-.741v-.741H7.287v-.648c.235-.44.484-.876.747-1.31Zm-.029 1.298v.02h1.219v-2.021h-.041c-.201.318-.404.646-.607.984-.2.338-.391.677-.571 1.017Z" />
                                                </svg>
                                                <span>
                                                    VIDEO
                                                </span>

                                            </div>
                                            <?php
                                            $video = base64_encode($row['Video']); // encode video data as base64
                                            echo "<video controls style=\"width:100%\">";
                                            echo "<source src='data:video/mp4;base64,$video' type='video/mp4'>";
                                            echo "Your browser does not support the video tag.";
                                            echo "</video>";
                                            ?>
                                        </div>
                                        <div class="col-sm-6 alert alert-light rounded">
                                            <div class="alert alert-light" role="alert">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-filter-square" viewBox="0 0 16 16">
                                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    <path d="M6 11.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                                                <span>
                                                    Details!
                                                </span>
                                            </div>
                                            <div>
                                                <div class="badge <?php if ($row['ResultState'] == 'Passed') {
                                                                        echo 'bg-success';
                                                                    } else {
                                                                        echo 'bg-danger';
                                                                    } ?> text-wrap " style="width: 6rem;">
                                                    <span>Result:</span>
                                                    <?= $row['ResultState'] ?>
                                                </div>
                                            </div>


                                            <table class="table table-striped table-bordered ">
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-clipboard2-check-fill"></i>
                                                    </td>
                                                    <td class="text-break">
                                                        <?= $row["Name"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-filetype-cs"></i>
                                                    </td>
                                                    <td class="text-break">
                                                        <?= $row["TestClassId"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-clipboard2-data"></i>
                                                    </td>
                                                    <td class="text-break">
                                                        <?= $row["FullName"] ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["ResultState"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-info-circle-fill"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["TestStatus"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-clock"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["Duration"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-calendar"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["StartTime"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-calendar-check"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["EndTime"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-chat-dots-fill"></i>
                                                    </td>
                                                    <td>
                                                        <textarea style="width:100%" class="text-break"><?= $row["Message"] ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-terminal-fill"></i>
                                                    </td>
                                                    <td>
                                                        <textarea style="width:100%" class="text-break"><?= $row["StackTrace"] ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-shield-check"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["AssertCount"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["FailCount"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-check-circle"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["PassCount"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-arrows-collapse"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["SkipCount"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-question-circle-fill"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["InconclusiveCount"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-file-earmark-code"></i>
                                                    </td>
                                                    <td>
                                                        <?= $row["HasChildren"] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-journal-code"></i>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $row['Name'] ?>output" aria-expanded="false" aria-controls="<?= $row['Name'] ?>output">
                                                                Verbose log
                                                            </button>
                                                        </p>
                                                        <div class="collapse" id="<?= $row['Name'] ?>output">

                                                            <textarea style="width:100%" class="text-break" disabled> <?= $row['Output'] ?> </textarea>

                                                        </div>



                                                    </td>
                                                </tr>

                                            </table>













                                            <figure>
                                                <blockquote class="blockquote">
                                                    <p>.</p>
                                                </blockquote>
                                                <figcaption class="blockquote-footer">
                                                    created by <cite title="Source Title"><code>safwane@abxrengine.com</code></cite>
                                                </figcaption>
                                            </figure>
                                            <div>
                                                <div class="form-floating mt-3">
                                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                                                    <label for="floatingTextarea">Comments</label>
                                                    <div class="fs-6 d-grid gap-2 col-12 mx-auto">
                                                        <button class="mt-2 rounded btn btn-primary" type="button">post</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile ?>;

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>