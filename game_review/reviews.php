<?php
	session_start();
	include 'connection_script.php';
	
	$result = $mysqli->query("SELECT * FROM a6_reviews ORDER BY game_name ASC");
?>

<!DOCTYPE html>
<html>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<link rel="stylesheet" type="text/css" href="http://sulley.cah.ucf.edu/~mi853358/dig3134/assignment06/css/styles.css">
    <title><?php print $_SESSION['logged_in_first_name']; ?>  <?php print $_SESSION['logged_in_last_name']; ?></title> 
	<body>

			<table border="1"> 
                <tr>
					<th>Game Reviews</th>
				</tr>
					
			<?php
				while($row = $result->fetch_object()) {
					print "<tr>"; 
					print "<td> <a href=\"review.php?review_id=".$row->review_id."\">".$row->game_name." </a></td>";
					print "</tr>";
				}
			?>
			
			</table>

	</body>
</html>