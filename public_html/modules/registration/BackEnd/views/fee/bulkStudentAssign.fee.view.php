<div class="span9">
  <input id="searchItems" rel="smallItem" class="search-query" value="Search..."/>

  <h1>Bulk Assign</h1>

  <span class="right"><label class="checkbox"><input id="checkAll" type="checkbox" checked=checked> Check All</label></span>
  <br style="width: 100%; clear: both; "/>
  <br style="width: 100%; clear: both; "/>
  <form id="bulkAssign" method="post" action="index.php?mod=registration&ajax=bulkAssignFeeToStudents&fee_id=<?php echo $fee_id; ?>">
    <input type="submit" class="btn btn-primary" value="Assign Fee" style="float: right;" />
    <br /><br />
    <?php
    if ($students) {
      foreach ($students as $student) {
        ?>
        <div class="smallItem well well-small">
          <span class="title"><?php echo $student['last_name'].", ".$student['first_name']; ?></span>
            <span class="buttons">

            <input type="checkbox"
                   name="assignTo[]"
                   value="<?php echo $student['student_id']; ?>" checked=checked/>

            </span>
        </div>
      <?php
      }
    }
    ?>
    <input type="submit" class="btn btn-primary" value="Assign Fee" style="float: right;" />
    <br /><br />
  </form>
</div>
<script type="text/javascript">
  $('#checkAll').click(function(){
    if($(this).attr('checked') == 'checked'){
      $('input:checkbox').attr('checked','checked');
    } else {
      $('input:checkbox').removeAttr('checked');
    }
  });
  $("#bulkAssign").submit( function(){
    var data = $("#bulkAssign").serialize();
    $.post($(this).attr("action"), data, function (data) {
      var response = JSON.parse(data);
      if (response.alertMessage != null) {
        alert(response.alertMessage);
      }
      if (response.success == true) {
        parent.window.location.reload();
      }
    });
    return false;
  });
</script>