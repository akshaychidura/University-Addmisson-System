<?php
session_start();
if(!isset($_SESSION["username"]))
	header("location:index.php");
else
	$username=$_SESSION["username"];
	require_once "DB.php";
	$check_status = mysqli_query($con , "select * from exam where username = '$username'");
	if(!$check_status)
		header("location:main.php");
	else
		$row = mysqli_fetch_array($check_status);
		if($row == null)
			header("location:main.php");
		else
			$status = $row["status"];
			echo "<script>alert($status);</script>";
			if(!$status == 0)
				header("location:main.php");
			else
				require "head.php";
				require "header_in.php";
	
	
?>
<html>
	<body>
		<center>
			<div class="exam-wrapper">
				<h3 class="heading"><b>Examination</b></h3><br>
				
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<?php
					$i = 0;
					
					if(mysqli_connect_errno())
					{
						echo "ERROR : Couldn't connect to database";
					}
					else
					{	
						$table_select = mysqli_query($con , "select * from tables where status = 1");
							if(!$table_select)
							{
								echo "No row has status 1";
							}
							else
							{
								$row = mysqli_fetch_array($table_select);
								$status=$row["status"];
								$tablename = $row["tablename"];
								$table_questions = 	mysqli_query($con , "select * from $tablename");
								if(!$table_questions)
								{
									echo "ERROR : Couldn't Select";
								}
								else
								{
									$marks = 0;
									while($q = mysqli_fetch_array($table_questions))
									{
										$question_no = $q["qNo"];
										$question = $q["question"];
										$option1 = $q["option1"];
										$option2 = $q["option2"];
										$option3 = $q["option3"];
										$option4 = $q["option4"];
										$correct = $q["correct"];
										$_SESSION["correct$i"] = $correct;
										echo "<div class='main_questions'>";
										echo "<p class='ques'><b>$question_no. $question</b></p><br>";
										echo "<p class='selections'><input type='radio' name='crct$i' value='a$i' class= 'rad' checked>$option1 ";
										echo "<p class='selections'><input type='radio' name='crct$i' value='b$i' class= 'rad'>$option2" ;
										echo "<p class='selections'><input type='radio' name='crct$i' value='c$i' class= 'rad'>$option3" ;
										echo "<p class='selections'><input type='radio' name='crct$i' value='d$i' class= 'rad'>$option4" ;
										echo "</div><br><br>";
										$i=$i+1;
									}
									if(isset($_POST["ans-sub"]))
									{	
										
										for($i=0;$i<$question_no;$i++)
										{
										
											$answer = $_POST["crct$i"];
											$cor = $_SESSION["correct$i"];
											if(!empty($answer))
											{
												if($answer == $cor)
												{
													$marks = $marks + 1;
												}
												else
												{
													$marks = $marks;
												}
											}
											else
											{
												$marks = $marks;
											}
											
										}
										echo "<script>alert($marks);</script>";
										$username=$_SESSION["username"];
										$update_marks = mysqli_query($con , "update exam set marks=$marks , status=1 where username = '$username'");
										if(!$update_marks)
										{
											echo "ERROR : Couldn't update marks";
											echo "<br>".mysqli_error($con);
										}
										else
										{
											header("location:main.php");
										}
									}
									
									
									
								}
							}
					}
									
					?>
					<p><button type='submit' class='btn btn-default btnw' id='a_btn' name='ans-sub'>Submit</button></p>
				</form>		
			</div>
		</center>
	</body>
</html>