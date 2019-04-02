<?php

?>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Hierarchy</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Employer</th>
        <th scope="col">Time of Person</th>
        <th scope="col">Sum time</th>
        <th scope="col">Info</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $prntArrows = function ($path) {
        $c = substr_count($path, '/');
        for ($i = 0; $i <= $c; $i++) {
            if ($i == $c) {
                echo "&nbsp;&nbsp;<i class=\"fas fa-level-up-alt fa-rotate-90\"></i>";
            } else {
                echo "&nbsp;&nbsp;&nbsp;";
            }
        }
    };

    $checkBadEmails = function ($email) {
        if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-zа-я0-9_.-]+(?:\.?[a-zа-я0-9]+)?\.[a-zа-я]{2,5})$/iu", $email)) {
            return 'class="danger"';
        }
    };

    foreach ($data as $val) {
        ?>
        <tr>
            <th scope="row"><?= $val['Id'] ?></th>
            <td><?= $prntArrows($val['path']); ?></td>
            <td><?= $val['Name'] ?></td>
            <td <?= $checkBadEmails($val['Email']); ?>><?= $val['Email'] ?></td>
            <td><?= $val['EmployerId'] ?></td>
            <td><?= $val['utime'] ?></td>
            <td><?php/* $val['udate'] */ ?></td>
            <td><?= $val['Info'] ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
