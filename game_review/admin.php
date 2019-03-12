<?php
    session_start(); 
     
    include 'connection_script.php'; 
	
	if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in_access_level'] == 'reviewer')) {
		if(isset($_POST['submit'])) { 
            $insert_reviews_query = "INSERT INTO a6_reviews(review_id, game_name, game_review, game_rating, game_image_url, review_creation_date, user_id) 
                                     VALUES (NULL,'".$_POST['game_name']."', '".$_POST['game_review']."', '".$_POST['game_rating']."', '".$_POST['game_image_url']."', CURRENT_TIMESTAMP, '".$_SESSION['logged_in_user_id']."')"; 
            $mysqli->query($insert_reviews_query); 
                
			$xml = simplexml_load_file("reviews.xml") or die("Error: Cannot create object");
                
               $review = $xml->addChild("review");
               $review->addChild("title", $_POST['game_name']);
               $review->addChild("link", "reviews.php");
               $review->addChild("description", $_POST['game_review']);

               $xml->asXML("reviews.xml");
        }
	}
	
	$reviews_query = "SELECT q.user_id, q.access_level, q.first_name, q.last_name, q.username, q.password, w.review_id, w.game_name, w.game_review, w.game_rating, w.game_image_url, w.review_creation_date 
                                 FROM a6_users q, a6_reviews w
								 WHERE q.user_id = w.user_id";
    $reviews_result = $mysqli->query($reviews_query); 
		      
?> 

<!DOCTYPE html> 
    <html> 
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<link rel="stylesheet" type="text/css" href="http://sulley.cah.ucf.edu/~mi853358/dig3134/assignment06/css/styles.css">
        <title><?php print $_SESSION['logged_in_first_name']; ?>  <?php print $_SESSION['logged_in_last_name']; ?></title> 
    </head> 
     
    <body> 
        <p>Congratulations <?php print $_SESSION['logged_in_username']; ?>, you have successfully logged in!</p> 
        <p>Click <a href="logout.php">HERE</a> to logout.</p> 
        <hr /> 
        <p>
		
		<?php
			if ($_SESSION['logged_in_access_level'] == "reviewer") {
			?> 
					<form method="post" action="admin.php"> 
					<label for="game_name">Game Name</label> 
					<input name="game_name" id="game_name" type="text" /><br /> 
					<label for="game_review">Game Review</label> 
					<input name="game_review" id="game_review" type="text" /><br /> 
					<label for="game_rating">Game Rating</label> 
					<input name="game_rating" id="game_rating" type="text" /><br />
					<label for="game_image_url">Game Image URL</label> 
					<input name="game_image_url" id="game_image_url" type="text" /><br />
					<input name="submit" id="submit" type="submit" value="Submit Review" /> 
					</form> 
					
					<br>
			<?php
			}
			?>	
		
		<?php
		if ($_SESSION['logged_in_access_level'] == "administrator") {
		?>
		<p>Click <a href="delete.php">HERE</a> to delete an existing review.</p>
		<?php
		}
		?>
		
            <table border="1"> 
                <tr>
                    <th>Game Name</th> 
                    <th>Review</th> 
                    <th>Rating</th> 
					<th>Image</th> 
                    <th>Review Date</th>
					<th>Access Level</th>
					<th>Comments</th>
					
					<?php
						if ($_SESSION['logged_in_access_level'] == "administrator") {
						?>
							<div id='admin'>
									<th>Review ID</th>
									<th>User ID</th>
									<th>Username</th>
									<th>Password</th> 
									<th>First Name</th>
									<th>Last Name</th>
							</div>
						<?php
						}
						?>
					</tr>
				
            <?php 
			if ($_SESSION['logged_in_access_level'] == 'administrator') {
                while($row = $reviews_result->fetch_object()) { 
                    print "<tr>"; 
                    print "<td>".$row->game_name."</td>";  
                    print "<td>".$row->game_review."</td>";  
                    print "<td>".$row->game_rating."</td>";  
                    print "<td><img src='" .$row->game_image_url ."' style='width: 80px; height: 100px;'/></td>";  
                    print "<td>".$row->review_creation_date."</td>";
					print "<td>".$row->access_level."</td>";
					print "<td> <a href=\"review.php?review_id=".$row->review_id."\">View Comments</a></td>";
					print "<td>".$row->review_id."</td>";
					print "<td>".$row->user_id."</td>"; 
					print "<td>".$row->username."</td>"; 
					print "<td>".$row->password."</td>"; 
					print "<td>".$row->first_name."</td>"; 
					print "<td>".$row->last_name."</td>";
                    print "</tr>"; 
                }
			}
			
			else if ($_SESSION['logged_in_access_level'] == 'reviewer') {
                while($row = $reviews_result->fetch_object()) { 
                    print "<tr>"; 
                    print "<td>".$row->game_name."</td>";  
                    print "<td>".$row->game_review."</td>";  
                    print "<td>".$row->game_rating."</td>";  
                    print "<td><img src='" .$row->game_image_url ."' style='width: 80px; height: 100px;'/></td>";  
                    print "<td>".$row->review_creation_date."</td>";  
                    print "<td>".$row->access_level."</td>"; 
					print "<td> <a href=\"review.php?review_id=".$row->review_id."\">View Comments</a></td>";
                    print "</tr>"; 
                }
			}	
            ?>

		</table>
		
    </p> 
					
    </body> 
</html> 

<?php $mysqli->close(); ?>
