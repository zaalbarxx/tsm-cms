<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
      <?php if ($periods) { ?>
        <?php foreach ($periods as $period) { ?>
                <div class="smallItem">
                    <span class="title"><?php echo $reg->displayPeriod($period); ?></span>
				<span class="buttons">
				<a href="#" class="addButton24" title="Add Period"></a>
				</span>

                    <div class="periods" style="display: none;">
                        <h3>Select a Teacher for this Period</h3>
                      <?php foreach ($teachers as $teacher) { ?>
                      <?php echo $teacher['first_name']." ".$teacher['last_name']; ?> - <a
                                href="index.php?com=registration&view=courses&action=addPeriod&course_id=<?php echo $courseInfo['course_id']; ?>&teacher_id=<?php echo $teacher['teacher_id']; ?>&addPeriod=<?php echo $period['period_id']; ?>"
                                class="addPeriod">Choose</a><br/>
                      <?php } ?>
                    </div>
                </div>

          <?php } ?>
        <?php } else { ?>
            <span>This student is not eligible for any courses in <?php $programInfo['name']; ?>.</span><br/><br/>
        <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            var docHeight = $(document).height();
            $("body").append("<div id='overlay'></div>");
            $("#overlay").height(docHeight);
            $(this).parent().parent().children(".periods").clone().addClass("activePeriod").prependTo("body").css({left:$(window).width() / 2 - 180}).show();

            return false;
        });
        $(".addPeriod").live('click', function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error adding this period.");
                    parent.window.location.reload();
                } else {
                    parent.window.location.reload();
                }
            });

            return false;
        });
        $(document).mouseup(function (e) {
            var container = $("body .activePeriod");
            if (container.has(e.target).length === 0) {
                container.remove();
                $("#overlay").remove();
            }
        });
    });
</script>