<?php
session_start();
if((!isset($_SESSION["username"])) || ($_SESSION["username"] != "admin"))
	header("location:index.php");
else
	require "head.php";
	require "header_in.php";
?>
<html>
	<body>
		<div class="col-md-12">
			
			<div class="main-body">
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<p><span class="qno"> TEST DETAILS </span></p>
				<p><input type="text" name="Test_Info" id="Test_Info" class='txtbx'></p><br> 
				<?php
					$no=$_SESSION["no-questions"];
					for($i=0;$i<$no;$i++)
					{
						$qno = $i+1;
						echo "<span class='qno'><b>Question : $qno</b></span> <p><textarea name='$i' class='txtarea'></textarea></p>";
						echo "<p class='selections'><input type='radio' name='crct$i' value='a$i' class= 'rad' checked> <input type='text' name='a$i' class='txtbx'></p>";
						echo "<p class='selections'><input type='radio' name='crct$i' value='b$i' class= 'rad'> <input type='text' name='b$i' class='txtbx'></p>";
						echo "<p class='selections'><input type='radio' name='crct$i' value='c$i' class= 'rad'> <input type='text' name='c$i' class='txtbx'></p>";
						echo "<p class='selections'><input type='radio' name='crct$i' value='d$i' class= 'rad'> <input type='text' name='d$i' class='txtbx'></p><br><br>";
					}
				?>
				<p><button type="submit" class="btn btn-default btnw" id="q_btn" name="ques-sub">Submit</button></p>
			</form>
			</div>	
		</div>
		<?php
		if(isset($_POST["ques-sub"]))
		{
			require_once "DB.php";
			if(mysqli_connect_errno())
			{
				echo "ERROR : Couldn't connect to database";
			}
			else
			{
				$select_count = mysqli_query($con,"select * from tablecount");
				if($select_count != null)
				{
					$row=mysqli_fetch_array($select_count);
					$table_count = $row["count"];
					$table_update_count = $table_count+1;
					$update_count = mysqli_query($con , "update tablecount set count = $table_update_count where count = $table_count");
					if(!$update_count)
					{
						echo "ERROR : Couldn't update count";
					}
					else
					{
						$Test_Info = $_POST["Test_Info"];
						$insert_tablename = mysqli_query($con , "insert into tables (tablename , info) values ('table$table_update_count' , '$Test_Info')");
						if($insert_tablename == false)
						{
							echo "tablenames not inserted";
							echo mysqli_error($con);
						}
						$create = mysqli_query($con,"CREATE TABLE table$table_update_count
							(
							qNo int NOT NULL AUTO_INCREMENT PRIMARY KEY,
							Test_Info varchar(255) NOT NULL,
							question varchar(255) NOT NULL,
							option1 varchar(255) NOT NULL,
							option2 varchar(255) NOT NULL,
							option3 varchar(255) NOT NULL,
							option4 varchar(255) NOT NULL,
							correct varchar(255) NOT NULL
							)");
						if(!$create)
						{
							echo "not Created";
							echo mysqli_error($con  );
						}
						else
						{
							for($i=0;$i<$no;$i++)
							{
								
								$question = $_POST["$i"];
								$option1 = $_POST["a$i"];
								$option2 = $_POST["b$i"];
								$option3 = $_POST["c$i"];
								$option4 = $_POST["d$i"];
								$correct = $_POST["crct$i"];
								$result = mysqli_query($con , "insert into table$table_update_count (Test_Info , question , option1 , option2 , option3 , option4 , correct) values ('$Test_Info' , '$question' , '$option1' , '$option2' , '$option3' , '$option4' , '$correct') ");
								
							}
							header("location:admin.php");	
						}
					}
				}
				else
				{
					echo "ERROR : Couldn't select the count from DB";
				}
			}
		}
		?>
		
	</body>
</html>