<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h1>
    <input id="searchItems" rel="bigItem"
           value="Search..."/>
  <?php if (isset($courseList)) { ?>
  <?php foreach ($courseList as $course) { ?>
        <div class="bigItem" style="margin-left: auto; margin-right: auto;">
            <span class="title"><?php echo $course['name']; ?> - <span
                    style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>

            <div style="float: right; position: relative; top: -20px;">
                <span class="label">Tuition: $<?php echo $course['tuition_total']; ?></span>
            </div>
            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($course['description']); ?>
                </div>
                <h4>Available Periods</h4>
              <?php
              if (isset($course['periods'])) {
                foreach ($course['periods'] as $period) {
                  ?>
                  <?php echo $reg->displayPeriod($period); ?><br/>
                  <?php
                }
              }?>
              <?php if (isset($course['tuition_total'])) { ?>
                <h4>Applicable Fees</h4>
                <b>Course Tuition:</b>
                $<?php echo $course['tuition_total']; ?>
              <?php } ?>
            </div>

        </div>

    <?php } ?>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bigItem .title").click(function () {
            $(this).parent().children(".itemDetails").slideToggle();
        });
    });
</script>