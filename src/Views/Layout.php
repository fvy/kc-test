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
            <form autocomplete="off" action="<?=$_SERVER["PHP_SELF"];?>" method="post" class="form-inline sandbox-form" id="sandbox-container">
                <div class="row form-horizontal">
                    <div class="span5 col-md-8" id="sandbox-container">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="startDate" value="<?=$_POST["startDate"]??'';?>">
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="endDate" value="<?=$_POST["endDate"]??'';?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <h3><?= $this->properties["name"]; ?></h3>
                <?php
                $view = new Template();
                echo $view->render('TableView', $this->properties["data"]);
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