<?php 
    session_start(); 
     
    include 'connection_script.php';
	
	$review_id = (int)$_GET['review_id'];
	
	if(isset($_SESSION['logged_in'])) {
		if(isset($_POST['submit'])) { 
            $insert_comments_query = "INSERT INTO a6_comments(review_id, comment, comment_creation_date) 
                                     VALUES ('".$review_id."', '".$_POST['comment']."', CURRENT_TIMESTAMP)"; 
            $mysqli->query($insert_comments_query);                 	
        }
	}
	
	$reviews_query = "SELECT e.review_id, e.comment_id, e.comment, e.comment_creation_date   
						  FROM a6_comments e 
						  WHERE e.review_id='".$review_id."'";
    $reviews_result = $mysqli->query($reviews_query);
	
	$game_review_query = "SELECT *   
						  FROM a6_reviews WHERE review_id='".$review_id."'";
    $game_review_result = $mysqli->query($game_review_query);
	

?> 

<!DOCTYPE html> 
    <html> 
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="http://sulley.cah.ucf.edu/~mi853358/dig3134/assignment06/css/styles.css">
        <title>Comment Section</title> 
    </head> 
     
    <body>  
        <p>Click <a href="admin.php">HERE</a> to go back to the home page.</p> 
        <hr />
		
		<div class="gameReview">
			<?php 
				$row = $game_review_result->fetch_object();
				print "<h1>".$row->game_name."</h1>";
				print "<h2><img src='" .$row->game_image_url ."' alt='game image' style='width: 205px; height: 235px;'/></h2>";
				print "<h3> Game Rating: ".$row->game_rating."</h3>";    
				print "<p>".$row->game_review."</p>";  
            ?> 
		</div>
		<table border="1"> 
		   <tr>  
				<th>Review ID</th>
				<th>Comment ID</th>
				<th>Comment</th>
				<th>Comment Creation Date</th>
			</tr> 
			
		<?php 
			while($row = $reviews_result->fetch_object()) { 
				print "<tr>"; 
				print "<td>".$row->review_id."</td>"; 
				print "<td>".$row->comment_id."</td>";    
				print "<td>".$row->comment."</td>";  
				print "<td>".$row->comment_creation_date."</td>";
				print "</tr>"; 
			}
		?> 
		
		</table> 
		
		<?php
		if($_SESSION['logged_in']) {
		?>
		
		<br><br>
		
		<form method="post" action=""> 
				<label for="comment">Add a new comment:</label> 
				<input name="comment" id="comment" type="text" /><br /> 
				<input name="submit" id="submit" type="submit" value="Submit Comment" /> 
				</form> 
				
				<br>
		
		<?php } ?>
		
        <br /> 
    </body> 
</html> 

<? $mysqli->close(); ?>