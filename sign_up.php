<!--
	page for user sign up, from home work assignment 3
	user does not need to log in to access this page
-->

<html>
	<head>
		<title>Sign Up</title>
		<link rel = "stylesheet" type = "text/css" href = "includes/myStyle.css" />
	</head>

	<body>		
	<?php
		include "includes/functions.php";   //all functiona
		navigation();
		
		echo '<div id="container">';
		
		//process form data
		//if no problem, insert them to database and then display the data in the users table
		if ($_SERVER['REQUEST_METHOD'] =='POST'){
			$err = array();   //to store all error messages

			//retrieve form data
			$userid = $_POST['userid'];
			$psword = $_POST['psword'];
			$pwconfirm = $_POST['pwconfirm'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$role = $_POST['role'];

			//english letters and numbers only. numbers optional.
			//this pattern ensures at least one letter
			If(!preg_match("/^[A-Za-z0-9]+$/", $userid)
				|| !preg_match("/[A-Za-z]/", $userid)){
				$err['userid']="Invalid User Name";
			}

			//at least seven english letters and at least one "_"
			//"/^([A-Z]|[a-z]|_){8,}$/" ensures at least 8 of letters and _ in total.
			if(!preg_match("/^([A-Z]|[a-z]|_){8,}$/", $psword)){
				$err['psword']="Invalid password";
			}
			else{
				$underscore=substr_count($psword,'_');  //# of _
				$len=strlen($psword);   //total # of letters and _'s
				$letters=$len-$underscore;   //total # of letters
				if($underscore==0 || $letters<7){  //make sure #letters>7 and #_'s>0
					$err['psword']="Invalid password";
				}
			}

				
			//two passwords matach?
			if($psword!=$pwconfirm){
				$err['pwconfirm']="Does not match the password.";
			}
			
			//if first letter starts uppercase the code begins with [A-Z]([A-Z]|[a-z])
			//contains enlgish letters only
			if(!preg_match("/^([A-Z]|[a-z])+$/", $fname)){
				$err['fname']="Invalid first name.";
			}
			
			// contains english letters only
			if(!preg_match("/^([A-Z]|[a-z])+$/", $lname)){
				$err['lname']="Invalid last name.";
			}
			
			//in the form xxx@gmail.com, where xxx must start with an english letter
			//may have digits 
			$email=$_POST['email'];
			if(!preg_match("/^[A-Za-z]([A-Za-z0-9])+@gmail\.com$/", $email)){
				$err['email']="Invalid email.";
			}

			
			if (empty($err)){
					//form data okay. insert to the users table.
					
					//connect to the server
					$myConn=db_connection();
					
					//define the insert query
					$q="INSERT INTO users (userid, psword, fname, lname, email, role)
					VALUES ('$userid','$psword', '$fname', '$lname', '$email', '$role')";
					
					//execute the query
					$r=mysqli_query($myConn, $q);

					//if data inserted successfully, display the users table
					//this is for testing only. removed it when the code is finalized.
					//it can be implemented as view_users.php
					if($r){
					
						//clean up the form data
						$_POST=array();
						
						echo "Data insertion completed.";		
					}
					else {
						//the insertion action is failed
						echo "Inserting data to table is failed.";
					}
			}

		}
	?>
<!-- // above ends the php code  -->

<!-- // below sets up the input setup for the data and notes all info is required -->
		<h3> The New MU Users Form</h3>

		<p class="err">* All fields required</p>

		<!-- //allows data to be inputed throughout  -->
		<form action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
<!-- //creates data for userID input and the
The * reminds user it is required  -->
			<input type="text" name="userid" value="<?php echo $_POST['userid'];?>"
			placeholder="userid..." required>
				<span class="err">*<?php echo $err['userid'] ?></span><br>
				
<!-- //creates data for password  -->
			<input type="text" name="psword" value="<?php echo $_POST['psword'];?>"
			placeholder="password..." required>
				<span class="err">*<?php echo $err['psword']; ?><br>
				
<!-- //creates data to re-confirm the passsword  -->
			<input type="text" name="pwconfirm" value="<?php echo $_POST['pwconfirm'];?>"
			placeholder="confirm password..." required>
				<span class="err">*<?php echo $err['pwconfirm']; ?><br>
				
<!-- //creates data for first name input  -->
			<input type="text" name="fname" value="<?php echo $_POST['fname'];?>"
			placeholder="first name..." required>
				<span class="err">*<?php echo $err['fname']; ?><br>
				
<!-- //creates data for last name input  -->
			<input type="text" name="lname" value="<?php echo $_POST['lname'];?>"
			placeholder="last name..." required>
				<span class="err">*<?php echo $err['lname']; ?><br>
				
<!-- //creates data for email input  -->
			<input type="text" name="email" value="<?php echo $_POST['email'];?>"
			placeholder="email..." required>
				<span class="err">*<?php echo $err['email'] ?></span><br>

<!-- //creates dropdwon menu -->
				<?php
					$role=array("admin"=>"admin", "instructor"=>"instructor",
						"student"=>"student");
					echo '<select name="role">';
					dropdown_menu($role, $_POST['role']);
					echo '</select><br>';
				?>

<!-- //what is this thing  -->
				<span class="err"><?php echo $err['role'] ?></span><br>

<!-- //creates submit button -->
				<input type="submit" name='submit' value="Submit"><br>

		</form>
	</div> <!-- container -->
</body>
<footer>&copy Monmouth University</footer>
</html>
