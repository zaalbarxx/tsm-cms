<h1>Registration Portal</h1>
<b>There are two campuses:</b> <br />
<?php
foreach($campuses as $array){
  echo $array['campus_name']."<br />";
}
?>