<?php 
    session_start(); 

    include("connection_script.php"); 
     
    if(isset($_POST['submit']) && (!isset($_SESSION['logged_in']))) { 

        $select_query = "SELECT * FROM TABLE";
        $select_result = $mysqli->query($select_query); 
        if($mysqli->error) { 
            print "Select query error!  Message: ".$mysqli->error; 
        } 

        while($row = $select_result->fetch_object()) { 
            if ((($_POST['username']) == ($row->username)) && (md5($_POST['password']) == (md5($row->password)))) { 
                $_SESSION['logged_in'] = true; 
                $_SESSION['logged_in_username'] = $row->username; 
                $_SESSION['logged_in_user_id'] = $row->user_id;
				$_SESSION['logged_in_first_name'] = $row->first_name;
				$_SESSION['logged_in_last_name'] = $row->last_name;
                $_SESSION['logged_in_access_level'] = $row->access_level;
            } else { 
				
            } 
        } 
    } 
     
    if (isset($_SESSION['logged_in'])) { 
        header("Location: admin.php"); 
		exit;
    }

?> 

<!DOCTYPE html> 
    <html> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<link rel="stylesheet" type="text/css" href="">
        <title>LOGIN</title> 
    </head> 
     
    <body class="login"> 
        <form method="post" action="login.php"> 
            <label for="username">Username</label> 
            <input name="username" id="username" type="text" /><br /> 
            <label for="password">Password</label> 
            <input name="password" id="password" type="password" /><br /> 
            <input name="submit" id="submit" type="submit" value="Login" /> 
    </body> 
</html> 

<?php $mysqli->close(); ?>