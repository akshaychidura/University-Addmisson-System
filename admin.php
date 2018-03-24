<?php
session_start();
if((!isset($_SESSION["username"])) || ($_SESSION["username"] != "admin"))
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
					<li><a href="#" id="add">Add Test</a></li>
					<li><a href="#" id="activate">Activate Test</a></li>
					<li><a href="#" id="Update">Update Rank</a></li>	
				</ul>
			</div>
			<div class="main-body">
			<center>
				<div class="add_test">
				<center>
					<h3 class="heading">Add Test</h3><br>
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<p><input type="text" placeholder="No.of Questions" name="no-questions" id="no-questions" class="form-control txtbx"><p>
						<p><button type="submit" class="btn btn-default btnw"  name="ques-but">Submit</button></p>
					</form>
				</center>
					<?php
					
						if(isset($_POST["ques-but"]))
						{
							session_start();
							$_SESSION['no-questions']=$_POST["no-questions"];
							echo $_SESSION['no-questions'];
							header("location:questions.php");
						}
					?>
				
				</div>
				<div class="activate_test">
				<center>
				<h3 class="heading">Activate Test</h3><br>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<?php
						
						if(mysqli_connect_errno())
						{
							echo "ERROR : Could'nt connect to DataBase";
						}
						else
						{
							$table_select = mysqli_query($con , "select * from tables");
							if(!$table_select)
							{
								echo "ERROR : Couldn't Select tables";
							}
							else
							{
								while($row = mysqli_fetch_array($table_select))
								{
									$sno = $row["sno"];
									$info = $row["info"];
									echo "<div class='ques_align'>";
									echo "$info <button type='submit' class='btn btn-default'  name='activate$sno'>Activate</button>";
									echo "</div>";
									if(isset($_POST["activate$sno"]))
									{
										$update_zerostatus = mysqli_query($con , "update tables set status = 0");
										$update_status = mysqli_query($con , "update tables set status = 1 where sno = '$sno' ");
									}
								}
							}
						}
						
					?>
				</center>
				</form>
				</div>
				<div class="update_rank">
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method = "post">
						<input type="submit" class="btn btn_default" name="update_btn" value="Update Ranks">
					</form>
					<?php
					if(isset($_POST["update_btn"]))
					{
						$rank = 1;
						$result=mysqli_query($con,"select * from exam order by marks DESC");
							if(!$result)
							{
								echo "ERROR : Couldn't select table Courses";
								
							}
							else
							{
							while($row = mysqli_fetch_array($result))
							{
							$o=$row['username'];
							mysqli_query($con,"UPDATE exam SET rank=$rank where username='$o'");
							$rank=$rank+1;
							}
							}
					}
					
					?>
				</div>
			</center>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			$(".add_test").show();
			$(".activate_test").hide();
			$("#add").click(function(){
				$(".add_test").show();
				$(".activate_test").hide();
			});
			$("#activate").click(function(){
				$(".add_test").hide();
				$(".activate_test").show();
			});
			});
		</script>
	</body>
</html>