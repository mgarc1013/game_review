<?php
    session_start(); 
     
    include 'connection_script.php'; 

    if(isset($_SESSION['logged_in'])) {
		$review_id = (int)$_GET['review_id'];
		$delete_reviews_query = "DELETE FROM a6_reviews 
								 WHERE review_id='".$review_id."'"; 
		$mysqli->query($delete_reviews_query); 
		
        $reviews_query = "SELECT q.access_level, w.review_id, w.game_name, w.game_review, w.game_rating, w.game_image_url, w.review_creation_date 
                                 FROM a6_users q, a6_reviews w
								 WHERE q.user_id = w.user_id";
        $reviews_result = $mysqli->query($reviews_query);
	}
	

?> 

<!DOCTYPE html> 
    <html> 
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="http://sulley.cah.ucf.edu/~mi853358/dig3134/assignment06/css/styles.css">
        <title><?php print $_SESSION['logged_in_first_name']; ?>  <?php print $_SESSION['logged_in_last_name']; ?></title> 
    </head> 
     
    <body> 
        <p>Logged in as: <?php print $_SESSION['logged_in_username']; ?></p> 
        <p>Click <a href="admin.php">HERE</a> to go back to the home page.</p> 
        <hr /> 
        <p> 
            <table border="1"> 
               <tr> 
                    <th>Game Name</th> 
                    <th>Review</th> 
                    <th>Rating</th> 
                    <th>Image</th> 
                    <th>Creation Date</th> 
                    <th>Access Level</th>
					<th>Review ID</th>
					<th>Delete Review</th>
                </tr> 
				
            <?php
			if ($_SESSION['logged_in_access_level'] == 'administrator') {
                while($row = $products_result->fetch_object()) { 
                    print "<tr>"; 
                    print "<td>".$row->game_name."</td>";  
                    print "<td>".$row->game_review."</td>";  
                    print "<td>".$row->game_rating."</td>";  
                    print "<td><img src='" .$row->game_image_url ."' style='width: 80px; height: 100px;'/></td>";  
                    print "<td>".$row->review_creation_date."</td>";  
                    print "<td>".$row->access_level."</td>";
					print "<td>".$row->review_id."</td>";
					print "<td> <a href=\"delete.php?review_id=".$row->review_id."\">DELETE</a></td>";
                    print "</tr>"; 
                }
			}
            ?> 
            </table> 
        </p> 
		
        <br /> 
    </body> 
</html> 

<?php $mysqli->close(); ?>