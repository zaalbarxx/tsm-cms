<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h1>
    <input id="searchItems" style="float: right; margin-top: -40px; position: relative; right: 40px;" rel="bigItem"
           value="Search..."/>
  <?php if ($courseList) { ?>
  <?php foreach ($courseList as $course) { ?>
        <div class="bigItem" style="margin-left: auto; margin-right: auto;">
            <span class="title"><?php echo $course['name']; ?> - <span
                    style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>

            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($course['description']); ?>
                </div>
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