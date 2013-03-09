<div class="span5 offset3">
    <h2>Reset Password</h2>

    <form id="passwordForm" action='' method="post" class="form-horizontal">
        <div class="control-group">
            <label for="password" class="control-label">Password: </label>

            <div class="controls">
                <input type="password" name="password" id="password"/>
            </div>
        </div>

        <div class="control-group">
            <label for="confirm_password" class="control-label">Confirm Password: </label>

            <div class="controls">
                <input type="password" name="confirm_password" id="confirm_password"/>
            </div>
        </div>

        <input type="hidden" name="campus_id" value="<?php echo $campusInfo['campus_id']; ?>"/>
        <input type="hidden" name="family_id" value="<?php echo $familyInfo['family_id']; ?>"/>
        <input type="hidden" name="resetPassword" value="1"/>
        <input type="submit" class="btn btn-primary" value="Save Password"/>
    </form>
</div>
<script type="text/javascript">
    $("#passwordForm").submit(function () {
        var formData = $(this).serialize();
        $.post(window.location, formData, function (data) {
            if (data == "1") {
                parent.window.location = parent.window.location;
            }
        });
        return false;
    });
</script>