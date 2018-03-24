<?php
session_start();
if(!isset($_SESSION["username"]))
	header("location:index.php");
else
	require "head.php";
	require "header_in.php";
	require_once "DB.php";
?>
<html>
	<body>
		<div class="col-md-12">
			<div class="main-nav">
				<ul class="nav">
					<li><a href="#" class="home_nav"><span class=" glyphicon glyphicon-chevron-right"></span> HOME</a></li>
					<li><a href="#" class="exam_nav"><span class="glyphicon glyphicon-chevron-right"></span> EXAM</a></li>
					<li><a href="#" class="result_nav"><span class="glyphicon glyphicon-chevron-right"></span> RESULT</a></li>
					<li><a href="#" class="councelling_nav"><span class="glyphicon glyphicon-chevron-right"></span> COUNCELLING</a></li>
				</ul>
			</div>
			<div class="main-body">
			<center>
				<div class="home">
				</div>
				<div class="exam">
					<center>
						<h3 class="heading">INSTRUCTIONS</h3>
						<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
							<p><a href="exam.php" class="link_but">Submit</a></p>
						</form>
					</center>
				</div>
				<div class="result">
					<center>
						<div class="result_info">
							<?php
								$username = $_SESSION["username"];
								
								if(mysqli_connect_errno())
								{
									echo "ERROR : Couldn't connect to DataBase";
								}
								else
								{
									$select_result = mysqli_query($con , "select * from exam where username = '$username'");
									if(!$select_result)
									{
										echo "ERROR : Couldn't select the table Exam";
									}
									else
									{
										while($row = mysqli_fetch_array($select_result))
										{
											if($row["marks"] == null)
											{
												echo "<p>Attempt Exam First</p>";
											}
											else
											{
												$marks = $row["marks"];
												if($row["rank"] == 0)
												{
													$rank = "-";
												}
												else
												{
													$rank = $row["rank"];
												}
												echo "<p>Marks&nbsp;&nbsp;&nbsp;	:	&nbsp;&nbsp;&nbsp;$marks</p>";
												echo "<p>Rank&nbsp;&nbsp;&nbsp;	:	&nbsp;&nbsp;&nbsp;$rank</p>";
											}
										}
										
									}
								}
								
							?>
						</div>
					</center>
				</div>
				<div class="councelling">
					<div class="councelling_info">
						<?php
							$select_result = mysqli_query($con , "select * from exam where username = '$username'");
									if(!$select_result)
									{
										echo "ERROR : Couldn't select the table Exam";
									}
									else
									{
										while($row = mysqli_fetch_array($select_result))
										{
											if(($row["marks"] == null) || ($row["rank"] == 0))
											{
												echo "<p>Attempt Exam First</P>";
											}
											else
											{
												$select_courses = mysqli_query($con , "select * from courses where username = '$username'");
													if(!$select_courses)
													{
														echo mysqli_error($select_courses);
													}
													else
													{
														while($row = mysqli_fetch_array($select_courses))
														{
															$status_courses = $row["status"];
														}
														if($status_courses = 1)
														{
															echo "<p>You have already selected Course</p>";
														}
														else
														{
						?>
						<table width="493" height="292" class="course_form" align='center'>
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="courseform">
								<tr>
									<td>COMPUTER SCIENCE</td>
									<td><input name="crc" type="Radio" value="cse" id="crc" class="pot" /><td>
								</tr>
								<tr>
									<td>MECHANICAL ENGINEERING	</td>
									<td><input name="crc" type="Radio" value="me" id="crc" class="pot"/><td>
								</tr>
								<tr>
									<td>MS SOFTWARE ENGINEERING</td>
									<td><input name="crc" type="Radio" value="ms" id="crc" class="pot"/><td>
								</tr>
								<tr>
									<td>CIVIL ENGINEERING</td>
									<td><input name="crc" type="Radio" value="ce" id="crc" class="pot"/><td>
								</tr>
								<tr>
									<td>ELECTRONICS & COMUNICATION ENGINEERING</td>
									<td><input name="crc" type="Radio" value="ece" id="crc" class="pot"/><td>
								</tr>
								<tr>
									<td><input name="course_submit" type="submit" value="Submit"  class='btn btn-default'  align="center"/></td>
								</tr>
							</form>
						</table>
					</div>
					<?php
					
															if(isset($_POST["course_submit"]))
															{
																
																	$course = $_POST["crc"];
																	$insert_course = mysqli_query($con , "update courses set course = '$course' where username = '$username'");
																	$update_course_status = mysqli_query($con , "update courses set status = 1");
																	$select_course_seat = mysqli_query($con ,"select * from course_count where course = '$course'");
																	if(!$select_course_seat)
																	{
																		echo "ERROR : Couldn't select course_count Table";
																	}
																	else
																	{
																		while($row = mysqli_fetch_array($select_course_seat))
																		{
																			$seats = $row['seats'];
																		}
																		$seats = $seats-1;
																		$update_course_seat = mysqli_query($con , "update course_count set seats =$seats");
																	}
															}
														}
													}
											}
										}
									}			
					?>
				</div>
			</div>
			</center>
			</div>
		</div>
		<script>
			$(".home").show();
			$(".exam").hide();
			$(".result").hide();
			$(".councelling").hide();
			$(".home_nav").click(function(){
				$(".home").show();
				$(".exam").hide();
				$(".result").hide();
				$(".councelling").hide();
			});
			$(".exam_nav").click(function(){
				$(".home").hide();
				$(".exam").show();
				$(".result").hide();
				$(".councelling").hide();
			});
			$(".result_nav").click(function(){
				$(".home").hide();
				$(".exam").hide();
				$(".result").show();
				$(".councelling").hide();
			});
			$(".councelling_nav").click(function(){
				$(".home").hide();
				$(".exam").hide();
				$(".result").hide();
				$(".councelling").show();
			});
			
		</script>
	</body>
</html>