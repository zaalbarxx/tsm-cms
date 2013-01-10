<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
      <?php if ($eligiblePrograms) { ?>
        <?php foreach ($eligiblePrograms as $program) { ?>
                <div class="smallItem">
                    <span class="title"><?php echo $program['name']; ?></span>
				<span class="buttons">
				<a href="index.php?com=registration&view=student&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>&enrollInProgram=<?php echo $program['program_id']; ?>"
           class="addButton24" title="Add to <?php echo $studentInfo['first_name']; ?>"></a>
				</span>
                </div>
          <?php } ?>
        <?php } else { ?>
            <span>This student is not eligible for any programs.</span><br/><br/>
        <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error enrolling <?php $studentInfo['first_name']; ?> in the program. They may already be enrolled.");
                    parent.window.location.reload();
                } else {
                    parent.window.location.reload();
                }
            });

            return false;
        });
        $("#searchField").focus(function () {
            if ($(this).val() == "Search...") {
                $(this).val('');
            }
        }).blur(function () {
                    if ($(this).val() == "") {
                        $(this).val('Search...');
                    }
                });
    });
</script>