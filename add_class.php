
<html>
	<head>
		<title>Add Class</title>
		<link rel="stylesheet" type="text/css" href="includes/myStyle.css">
	</head>
	
	<body>
		
		<?php
		session_start();
		if(empty($_SESSION)){
			//user has not logged in. redirect to the login papge
			echo "<script>window.open('login.php', '_SELF')</script>";
			exit();
        }
			include "includes/functions.php";
			navigation();
		?>
		
		<div id="container">
		
		<?php 
			// php code to processing the form data
			if($_SERVER['REQUEST_METHOD']=='POST'){  //true if form is submitted
                //retrieve data from $_POST
                $classcode = $_POST['classcode'];
				$classname = $_POST['classname'];
				$location = $_POST['location'];
                $instructor = $_POST['instructor'];
                $time = $_POST['time'];
                $type = $_POST['type'];

				// validate form data

				// create an array to store errors
                $err = array();
                
                // validate classcode. DONE
                // LL-ddd-dd; ex. SE-357-50
				if (!preg_match("/^[A-Z]{2}-[0-9]{3}-[0-9]{2}$/", $classcode)) {
					$err['classcode'] = "Invalid class code";
				}

                // validate classname. DONE
                // Letters and spaces only; ex. Intro to SE
				if (!preg_match("/^[A-Za-z]+[A-Za-z ]*$/", $classname)) {
					$err['classname'] = "Invalid class name";
                }
                
                // validate location. DONE
                // L-ddd or LL-ddd; ex. G-103, HH-206
				if (!preg_match("/^[A-Z][A-Z]?-[0-9]{3}$/", $location)) {
					$err['location'] = "Invalid location";
				}

                // validate instructor. DONE
                // Last name only; ex. Wang
				if (!preg_match("/^[A-Z][A-Za-z]+$/", $instructor)) {
					$err['instructor'] = "Invalid instructor name";
                }
                
                // validate time. DONE
                // YY dd:ddKM-dd:ddKM; ex. MO 11:40AM-01:00PM
				if(!preg_match("/^(MO|TU|WE|TH|FR) [0-9]{2}:[0-9]{2}(AM|PM)-[0-9]{2}:[0-9]{2}(AM|PM)$/", $time)) {
					$err['time'] = "Invalid class time";
				}
                
				// validation results
                if (empty($err)) {			// no error
                    echo"<p class='err'>Form is validated.</p>";
                    $myConn = db_connection();

                    $q = "INSERT INTO classes (classcode, classname, location, instructor, time, type) VALUE ('$classcode', '$classname', '$location', '$instructor', '$time', '$type')";

                    $r = mysqli_query($myConn, $q);

                    if ($r) {
                        $_POST = array(); // clean up $_POST and thus the form
                        
                    } else
                        echo "<p class='err'>Data insertion is failed.</p>";
                        
				} else {
					foreach ($err as $e) 
						echo "<p class='err'>$e</p>";
				}

			}

			
		?>
		<br>
		<fieldset>
		
		<legend>Input class information:</legend>
		<p class="err">* required field</p>
		<form action="" method="POST">
			<label for="classcode">Class Code: </label>
			<input type="text" id="classcode" name="classcode" value="<?php echo $_POST['classcode']; ?>"
				placeholder="In form LL-ddd-dd; ex. SE-357-50" required>
			<span class="err">*</span><br>
			
			<label for="classname">Class Name: </label>
			<input type="text" id="classname" name="classname" value = "<?php echo $_POST['classname'] ?>"
				placeholder="Letters and spaces only; ex. Intro to SE" required>
            <span class="err">*</span><br>

            <label for="location">Location: </label>
			<input type="text" id="location" name="location" value="<?php echo $_POST['location']; ?>"
				placeholder="In form L-ddd or LL-ddd; ex. G-103, HH-206" required>
            <span class="err">*</span><br>
            
            <label for="instructor">Instructor: </label>
			<input type="text" id="instructor" name="instructor" value = "<?php echo $_POST['instructor'] ?>"
				placeholder="Last name only; ex. Wang" required>
            <span class="err">*</span><br>
			
			<label for="time">Time: </label>
			<input type="text" id="time" name="time" value = "<?php echo $_POST['time'] ?>"
				placeholder="In form YY dd:ddKM-dd:ddKM; ex. MO 11:40AM-01:00PM"} required>
            <span class="err">*</span> <br>

            <label for="type">Choose a class type:</label>
			<select id="type" name="type" required>
				<?php
					$types = array(""=>"Please select an option",
								"inclass"=>"In-class",
								"hybrid"=>"Hybrid",
                                "onsync"=>"Online Sync",
                                "onasync"=>"Online Async");
					dropdown_menu($types, $_POST['type']);
				?>
            </select>
            <span class="err">*</span>
            <br><br>
			<input type="submit" value="Submit">
		</form>
		</fieldset>
		
		</div> <!-- container -->
	</body>
	
	<footer>
		Copyright@Monmouth University 2020
	</footer>
</html>