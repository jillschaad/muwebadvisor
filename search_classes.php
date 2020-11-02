
<html>
	<head>
		<title>Search Classes</title>
		<link rel="stylesheet" type="text/css" href="includes/myStyle.css">
	</head>
	
	<body>
		
		<?php

			include "includes/functions.php";
			navigation();
		?>
		
		<div id="container">
		
		<?php 
			// php code to processing the form data
			if($_SERVER['REQUEST_METHOD']=='POST'){  //true if form is submitted
                //retrieve data from $_POST

				$code = $_POST['code'];
				 
				$myConn = db_connection();

				$q = "SELECT * FROM classes";
				$r = mysqli_query($myConn, $q);

				if ($r) {
					 $_POST=array();

                    //define the select query
                    $q="SELECT * FROM `classes` WHERE `classcode` LIKE '%$code%'";
                    
                    //execute the query
                    $r=mysqli_query($myConn, $q);

                    if(mysqli_num_rows($r)>0){
                    //display the users table data
                        echo "<table id='tbl'>";
                        echo "<tr>";
                        echo "<th>classcode</th>";
                        echo "<th>classname</th>";
                        echo "<th>location</th>";
                        echo "<th>Instructor</th>";
                        echo "<th>time</th>";
                        echo "<th>type</th>";
                        echo "</tr>";
                        while($row=mysqli_fetch_assoc($r)){
                                echo "<tr>";
                                echo "<td>".$row['classcode']."</td>";
                                echo "<td>".$row['classname']."</td>";
                                echo "<td>".$row['location']."</td>";
                                echo "<td>".$row['Instructor']."</td>";
                                echo "<td>".$row['time']."</td>";
                                echo "<td>".$row['type']."</td>";
                                echo "</tr>";
                        }
                        echo "</table>";
                    }
                }
                else {
                    //the insertion action is failed
                    echo "Data search has failed.";
                }
			}

			
		?>
		<br>
		<fieldset>
		
		<legend></legend>
		<p class="err">* required field</p>
		<form action="" method="POST">

            <label for="code">Enter program code:</label>
			<select id="code" name="code" value="<?php echo $_POST['classcode']; ?>" required>
				<?php
					$code = array(""=>"Please select an option",
								"CS"=>"CS",
								"SE"=>"SE",
                                "MA"=>"MA",
                                "IT"=>"IT");
					dropdown_menu($code, $_POST['code']);
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