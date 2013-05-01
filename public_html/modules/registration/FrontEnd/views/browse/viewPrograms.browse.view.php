<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h1>
    <input id="searchItems" style="float: right; margin-top: -40px; position: relative; right: 40px;" rel="bigItem"
           value="Search..."/>
  <?php if ($eligiblePrograms) { ?>
  <?php foreach ($eligiblePrograms as $program) { ?>
        <div class="bigItem" style="margin-left: auto; margin-right: auto;">
            <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                     style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?>
                - <span
                        style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>

            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($program['description']); ?>
                </div>

                <div style="text-align: center; position: relative; top: 20px;">
                    <a href="index.php?mod=registration&browseOfferings=1&campus_id=<?php echo $campus_id; ?>&action=viewCourses&program_id=<?php echo $program['program_id']; ?>"
                       class="med_button fb" style="margin-left: -30px;">Browse Courses</a>
                </div>

            </div>
        </div>
    <?php } ?>
  <?php } else { ?>
    <span>This student is not eligible for any programs.</span><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bigItem .title").click(function () {
            $(this).parent().children(".itemDetails").slideToggle();
        });
    });
</script>