<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($periods) { ?>
  <?php foreach ($periods as $period) { ?>
        <div class="smallItem well well-small">
            <span class="title"><?php echo $reg->displayPeriod($period); ?></span>
            <a href="#myModal<?php echo $period['period_id']; ?>" class="btn btn-primary pull-right" title="Add Period"
               data-toggle="modal">Select</a>

            <div id="myModal<?php echo $period['period_id']; ?>" class="modal hide fade" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 id="myModalLabel">Select a Teacher</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <caption>You must select a teacher for the period to continue.</caption>
                      <?php foreach ($teachers as $teacher) { ?>
                        <tr>
                            <td>
                              <?php echo $teacher['first_name']." ".$teacher['last_name']; ?></td>
                            <td><a
                                    href="index.php?mod=registration&view=courses&action=addPeriod&course_id=<?php echo $courseInfo['course_id']; ?>&teacher_id=<?php echo $teacher['teacher_id']; ?>&addPeriod=<?php echo $period['period_id']; ?>"
                                    class="addPeriod btn btn-small btn-primary pull-right">Choose</a></td>
                        </tr>
                      <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    <?php } ?>
  <?php } else { ?>
    <span>This student is not eligible for any courses in <?php $programInfo['name']; ?>.</span><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
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
    });
</script>