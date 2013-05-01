<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($paymentPlans) { ?>
  <?php foreach ($paymentPlans as $paymentPlan) { ?>
        <div class="bigItem" style="margin-left: auto; margin-right: auto;">
            <span class="title"><?php echo $paymentPlan['name']; ?> - <span
                    style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>

            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($paymentPlan['description']); ?>
                </div>
            </div>
        </div>
    <?php
  }
}
  ?>
</div>
<script type="text/javascript">
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>