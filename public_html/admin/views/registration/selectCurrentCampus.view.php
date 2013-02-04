<h1>Select a Campus</h1>
<p>To continue, you must select a campus to work on.</p>
<form action="" method="post" id="selectCampusForm" style="text-align: center;">
    <select name="setCurrentCampusId" id="selectCampusId"
            style="font-size: 16px; padding: 10px; background: none; border: 1px solid #000; ">
        <option value="">Choose a Campus</option>
      <?php
      if ($campusList != NULL) {
        foreach ($campusList as $array) {
          echo "  <option value='".$array['campus_id']."'>".$array['name']."</option>\n";
        }
      } else {

      }
      ?>
    </select>
</form>
<script type="text/javascript">
    $("#selectCampusId").change(function () {
        $("#selectCampusForm").submit();
    });
</script>