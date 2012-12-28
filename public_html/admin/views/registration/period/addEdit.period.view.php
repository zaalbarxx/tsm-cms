<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="contentWithSideBar">
  <h1><?php echo $pageTitle; ?></h2>
  <form method="post" id="periodForm" style="" action="">
    <fieldset>
      <label for="day">Period Day: </label><select name="day" id="day" >
        <option value="">Choose a Day</option>
        <?php for($i=1;$i<8;$i++){ ?>
        	<option value="<?php echo $i; ?>" <?php if($period['day'] == $i){ echo "selected=selected"; } ?>><?php echo $tsm->intToDay($i); ?></option>
        <?php } ?>
      </select><br />
      <label for="start_time">Start Time: </label><select name="start_hour" id="start_hour" >
        <option value="">Hour</option>
        <?php for($i=1;$i<13;$i++){ ?>
        	<option value="<?php echo $i; ?>"><?php echo $i ?></option>
        <?php } ?>
      </select>
      <select name="start_minute" id="start_minute" >
        <option value="">Minute</option>
        <?php for($i=0;$i<60;$i++){ ?>
        	<option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
        <?php } ?>
      </select>
            <select name="start_am_pm" id="start_am_pm">
      	<option value="AM">AM</option>
      	<option value="PM">PM</option>
      </select>
      <br />
      <label for="end_time">End Time: </label><select name="end_hour" id="end_hour" >
        <option value="">Hour</option>
        <?php for($i=1;$i<13;$i++){ ?>
        	<option value="<?php echo $i; ?>"><?php echo $i ?></option>
        <?php } ?>
      </select>
      <select name="end_minute" id="end_minute" >
        <option value="">Minute</option>
        <?php for($i=0;$i<60;$i++){ ?>
        	<option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
        <?php } ?>
      </select>
      <select name="end_am_pm" id="end_am_pm">
      	<option value="AM">AM</option>
      	<option value="PM">PM</option>
      </select>
    </fieldset>
    <input type="hidden" name="start_time" id="start_time" value="<?php echo $period['start_time']; ?>" />
    <input type="hidden" name="end_time" id="end_time" value="<?php echo $period['end_time']; ?>" />
    
    <input type="hidden" name="period_id" value="<?php echo $period['period_id']; ?>" />
    <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>" />
    <input type="hidden" name="campus_id" value="<?php echo $reg->getCurrentCampusId(); ?>" />
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>" />
    <input type="hidden" name="<?php echo $submitField; ?>" value="1" />
    <input type="submit" class="submitButton" style="margin-top: 20px;" value="Save Period" />
  </form>
</div>
<script type="text/javascript">
$(document).ready( function(){
		var start_time = $("#start_time").val();
		var end_time = $("#end_time").val();
		
		start_hour = parseInt(start_time.split(":")[0]);
		start_minute = start_time.split(":")[1];
		if(start_hour > 12){
			start_am_pm = "PM";
			if(start_hour > 12){
				start_hour = start_hour - 12;
			}
		} else {
			if(start_hour == 0){
				start_hour = 12;
			}
			start_am_pm = "AM";
		}
		$("#start_hour").val(start_hour);
		$("#start_minute").val(start_minute);
		$("#start_am_pm").val(start_am_pm);
		
		
		end_hour = parseInt(end_time.split(":")[0]);
		end_minute = end_time.split(":")[1];
		if(end_hour >= 12){
			end_am_pm = "PM";
			if(end_hour > 12){
				end_hour = end_hour - 12;
			}
		} else {
			if(end_hour == 0){
				end_hour = 12;
			}
			end_am_pm = "AM";
		}
		$("#end_hour").val(end_hour);
		$("#end_minute").val(end_minute);
		$("#end_am_pm").val(end_am_pm);
});
$("#periodForm").submit( function(){
		var start_hour = $("#start_hour").val();
		var start_minute = $("#start_minute").val();
		var start_am_pm = $("#start_am_pm").val();
		var end_hour = $("#end_hour").val();
		var end_minute = $("#end_minute").val();
		var end_am_pm = $("#end_am_pm").val();
		
		if($("#day").val() != "" && start_hour != "" && start_minute != "" && end_hour != "" && end_minute != ""){
			if(start_am_pm == "PM" && start_hour < 12){
				start_hour = parseInt(start_hour) + 12;
			}
			if(end_am_pm == "PM" && end_hour < 12){
				end_hour = parseInt(end_hour) + 12;
			}
			if(start_am_pm == "AM" && start_hour == 12){
				start_hour = parseInt(start_hour) - 12;
			}
			if(end_am_pm == "AM" && end_hour == 12){
				end_hour = parseInt(end_hour) - 12;
			}
			
			var start_time = start_hour + ":" + start_minute + ":00";
			var end_time = end_hour + ":" + end_minute + ":00";

			$("#start_time").val(start_time);
			$("#end_time").val(end_time);
			
			$("#periodForm").unbind("submit");
			$("#periodForm").submit();
		} else {
			alert("You must fill out all the fields.");
		}
		
		return false;
});
</script>