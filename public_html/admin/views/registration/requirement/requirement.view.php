<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1>Requirements</h2>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=requirements&action=addEditRequirement" class="addButton"
                title="Add a Requirement"></a></span>
      <?php
      if ($reqList) {
        foreach ($reqList as $req) {
          ?>
            <div class="smallItem">
                <span class="title"><?php echo $req['name']; ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&view=requirements&action=addEditRequirement&requirement_id=<?php echo $req['requirement_id']; ?>"
                        class="editButton" title="Edit This Requirement"></a><a
                        href="index.php?com=registration&view=fees&action=deleteFee&fee_id=<?php echo $req['requirement_id']; ?>"
                        class="deleteButton" title="Delete Requirement"></a></span>
            </div>
          <?php
        }
      }
      ?>
</div>