<!-- menu.php
	- included in the includes folder
	- this is a dynamic navigation menu and there are three cases
	  1. the user is not logged in, 
	  2. the user is logged in and is a student 
	  3. the user is logged in asn is an admin (admin+instructor)
	- the menu is different in each case
	- check session variable to find our which case it is
	
	- notice the logic:
	  1. user not logged-in can log in
	  2. user logged-in can log out
-->


<h1 id="top">Monmouth University Class Registration System</h1>
<ul class = "nav">

        <?php 
            
            session_start();
            
            if(empty($_SESSION)){   //case 1: user not logged in
            	echo '<li class = "nav"> <a href = "index.php">Home</a></li>';
            	echo '<li class = "nav"><a href = "search_classes.php">Search Classes</a></li>';
            	
            	//allow user to log in
            	echo '<li class = "nav"><a href = "login.php">Log In</a></li>';
           	}
           	else { //cases 2&3: user logged in
           		$userid = $_SESSION['userid'];
           		$role = $_SESSION['role'];
           		
            	if ($role == "student") { //case 2: user is a student
            		echo '<li class = "nav"><a href = "my_registration.php">My Registration</a></li>';
            		echo '<li class = "nav"><a href = "register_class.php">Register Class</a></li>';
            		echo '<li class = "nav"><a href = "deregister_class.php">Deregister Class</a></li>';
            	}
            	else {  //case 3: user is an admin
               		echo '<li class = "nav"><a href = "add_class.php">Add Class</a></li>';
            		echo '<li class = "nav"><a href = "manage_classes.php">Manage Class</a></li>';
            		echo '<li class = "nav"><a href = "manage_registration.php">Manage Registration</a></li>';
            		echo '<li class = "nav"><a href = "manage_users.php">Manage Users</a></li>';
            		
            	}  
            	
            	//allow user to log out
            	echo '<li class = "nav"><a href = "index.php">Log Out</a></li>'; 


				//a welcome message for logged-in user
            	echo '<li class = "navWelcome">Welcome, '.$userid.'!</li>';  
            	
            } 
             	
        ?>
            
</ul>
