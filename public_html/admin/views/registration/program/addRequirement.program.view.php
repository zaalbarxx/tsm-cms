<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
        <form name="searchBox" method="post" style="float: right; margin-top: -45px; margin-right: 20px;"><input
                id="searchField" type="text" name="searchq" value="<?php if (isset($searchq)) {
          echo $searchq;
        } else {
          echo "Search...";
        } ?>"/></form>
      <?php if (isset($campusRequirements)) {
        foreach ($campusRequirements as $requirement) {
          ?>
            <div class="smallItem">
                <span class="title"><?php echo $requirement['name']; ?></span>
      <span class="buttons">
      <a href="index.php?com=registration&view=programs&action=addRequirement&program_id=<?php echo $program_id; ?>&addRequirement=<?php echo $requirement['requirement_id']; ?>"
         class="addButton24" title="Add to <?php echo $programName; ?>"></a>
      </span>
            </div>
          <?php
        }
      } else {
        echo "There are no requirements available.";
      } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error adding the requirement. It may already be added to <?php echo $programName; ?>.");
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