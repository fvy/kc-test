<?php

use fvy\Korus\Utils\HtmlHelpers;

?>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Иерархия<br> подчинения</th>
        <th scope="col">Имя</th>
        <th scope="col">Email</th>
        <th scope="col">ID <br>Нач-ка</th>
        <th scope="col">Списаное время</th>
        <th scope="col">Время с учетом<br>подчиненных</th>
        <th scope="col">Недоработка</th>
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

    $row_header = '<div class="row">
    <div class="col-xs-6">Дата</div>
    <div class="col-xs-6">Время</div>
    </div>';

    foreach ($this->properties['data'] as $val) {
        ?>
        <tr data-toggle="tooltip" data-placement="top" title="<?= HtmlHelpers::rawHtml($val['Info']); ?>">
            <th scope="row"><?= $val['Id'] ?></th>
            <td><?= $prntArrows($val['path']); ?></td>
            <td><?= HtmlHelpers::textOnly($val['Name']); ?></td>
            <td <?= $checkBadEmails($val['Email']); ?>><?= $val['Email'] ?></td>
            <td><?= $val['EmployerId'] ?? '-' ?></td>
            <td><?= $val['utime'] ?></td>
            <td><?= $val['totalsum']; ?></td>
            <th scope="col" data-placement="top" data-toggle="popover-hover"
                data-content='<?=$row_header?><?= isset($this->properties['dataOfTs'][$val['Id']]) ? $this->properties['dataOfTs'][$val['Id']] : ""; ?>'>
                <?=isset($this->properties['dataOfTs'][$val['Id']])?"<button>недоработка</button>":"";?>
            </th>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>