<?php

use fvy\Korus\Template;

?>
<!doctype html>
<html lang="ru">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
    <title><?= $this->properties["title"]; ?></title>
</head>
<body>

<div class="container">
    <div class="col-12">
        <div class="col-6">
            <?php
            $view = new Template();
            echo $view->render('FormView');
            ?>
        </div>
        <div class="row">
            <div class="col-12">
                <h3><?= $this->properties["name"]; ?></h3>
                <?php
                $view->data = $this->properties["data"];
                $view->dataOfTs = $this->properties["dataOfTs"];
                echo $view->render('TableView');
                ?>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"
        crossorigin="anonymous"></script>
<script src="/assets/js/main.js"
        crossorigin="anonymous"></script>

</body>
</html>