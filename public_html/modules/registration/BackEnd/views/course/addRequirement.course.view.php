<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>

<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1><?php echo $pageTitle; ?></h1>
  <?php foreach ($campusRequirements as $requirement) { ?>
    <div class="smallItem well well-small">
        <span class="title"><?php echo $requirement['name']; ?></span>
      <span class="buttons">
      <a href="index.php?mod=registration&view=courses&action=addRequirement&course_id=<?php echo $course_id; ?>&addRequirement=<?php echo $requirement['requirement_id']; ?>&program_id=<?php echo $program_id; ?>"
         class="addButton24" title="Add to <?php echo $courseName; ?>"></a>
      </span>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error adding the requirement. It may already be added to <?php echo $courseName; ?>.");
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