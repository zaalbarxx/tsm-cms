<div class="contentArea">
    <h2 style="margin-top: -30px;">Browse Registration Offerings</h2>
    <br/><br/>

    <p style="text-align: center;">Please choose a campus from the list below.</p>

    <form action="" id="chooseCampus" method="get" style="text-align: center;">
        <label for="setCurrentCampusId" style="width: 100px;">Campus:</label> <select id="setCurrentCampusId"
                                                                                      name="campus_id" class="select">
        <option value="">Select a Campus</option>
      <?php if (isset($campuses)) {
      foreach ($campuses as $campus) {
        echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
      }
    } ?>
    </select>
        <input type="hidden" name="browseOfferings" value="1"/>
        <input type="hidden" name="mod" value="registration"/>

    </form>
</div>
<script type="text/javascript">
    $("#setCurrentCampusId").change(function () {
        $("#chooseCampus").submit();
    });
</script>
