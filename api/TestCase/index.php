<?php
require_once('controller/TestcaseController.php');
try {
    $controller = new TestcaseController();
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        echo $controller->index($name);
    } else {
        echo $controller->index();
    }
} catch (Throwable $th) {
    echo $th;
}
