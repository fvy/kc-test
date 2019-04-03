<?php

use fvy\Korus\Utils\HtmlHelpers;

?>
<form autocomplete="off" action="<?= $_SERVER["PHP_SELF"]; ?>" method="post" class="form-inline sandbox-form"
      id="sandbox-container">
    <div class="row form-horizontal">
        <div class="span5 col-md-8" id="sandbox-container">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-sm form-control" name="startDate"
                       value="<?= HtmlHelpers::sanitizeDate('startDate'); ?>">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="endDate"
                       value="<?= HtmlHelpers::sanitizeDate('endDate'); ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </div>
</form>
