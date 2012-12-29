      <br style="width: 1000px; clear: both;" />
      </div>
      <div id="footerWrapper">
        <div id="footerContents">
        &copy; <?php echo date("Y"); ?> <a href="http://www.takesixmedia.com/" target="_blank">Take Six Media</a>
        <?php echo "Peak Memory: ".memory_get_peak_usage(true); ?> - <?php echo $tsm->db->getNumQueries(); ?>
        </div>
      </div>
      <div style="clear: both; width: 100%;">
			<?php
			/*
				if($_SERVER['SERVER_NAME'] == "localhost"){
					echo "Page created in: " . xdebug_time_index() . " seconds.<br />";
					echo "<b><u>THE SESSION:</b></u> ";
					var_dump($_SESSION);
					echo "<br><b><u>THE COOKIES:</b></u> ";
					var_dump($_COOKIE);;
					echo "<br><b><u>THE POST:</b></u> ";
					var_dump($_POST);
					echo "<br><b><u>THE GET:</b></u> ";
					var_dump($_GET);
					//echo "<br /><b><u>Page Headers:</u></b> ";
					//var_dump(xdebug_get_headers());
					echo "<br /><b><u>Memory Used:</u></b> ".xdebug_peak_memory_usage(); 
					//var_dump(xdebug_get_code_coverage());
					echo "<br /><br><b><u>THE CURRENTLY DECLARED VARIABLES:</b></u> ";
					var_dump(xdebug_get_declared_vars());
				}
				*/
			?>
			</div>
    </div>

	</body>
</html>
