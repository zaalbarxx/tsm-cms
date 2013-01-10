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
      <?php foreach ($campusFees as $fee) { ?>
            <div class="smallItem">
                <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
      <span class="buttons">
      <a href="index.php?com=registration&view=courses&action=addFee&course_id=<?php echo $course_id; ?>&addFee=<?php echo $fee['fee_id']; ?>&program_id=<?php echo $program_id; ?>"
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
                    alert("There was an error adding the fee. It may already be added to <?php echo $courseName; ?>.");
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