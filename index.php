
<?php require 'head.php';?>
<?php 
	$f_err=$l_err=$email_err=$username_reg_err=$password_reg_err=$gender_err=$login_err="";
	$bol=false;
	function text_input($text)
		{
			$text=trim($text);
			$text=stripslashes($text);
			$text=htmlspecialchars($text);
			return $text;
		}
		function istext($text)
		{
			if(preg_match("/^[a-zA-Z ]*$/",$text))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	if(isset($_POST['signup_submit']))
	{
		$f_name = $_POST['f_name'];
		$l_name = $_POST['l_name'];
		$email = $_POST['email'];
		$username_reg=$_POST['username_reg'];
		$password_reg = $_POST['password_reg'];
		$gender=$_POST['gender'];
		$uppercase = preg_match('@[A-Z]@', $password_reg);
		$lowercase = preg_match('@[a-z]@', $password_reg);
		$number    = preg_match('@[0-9]@', $password_reg);
		
		if(empty($f_name))
		{
			$f_err = "FirstName is mandatory";
		}
		else
		{
			$f_name=text_input($f_name);
			if(istext($f_name)==false)
			{
				$f_err="Invalid FirstName";
			}
		}
		if(empty($l_name))
		{
			$l_err="LastName is mandatory";
		}
		else
		{
			$l_name = text_input($l_name);
			if(istext($l_name)==false)
			{
				$l_err="Invalid LastName";
			}
		}
		if(empty($email))
		{
			$email_err="E-MAIL is mandatory";
		}
		else
		{
			$email=text_input($email);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$email_err="Invalid E-MAIL";
			}
		}
		if(empty($username_reg))
		{
			$username_reg_err="Username is mandatory";
		}
		else
		{
			$username_reg=text_input($username_reg);
			if(istext($username_reg)==false)
			{
				$username_reg_err="Invalid Username";
			}
		}
		if(empty($password_reg))
		{
			$password_reg_err="Password is mandatory";
		}
		else
		{
			$password_reg=text_input($password_reg);
			if(!$uppercase || !$lowercase || !$number || strlen($password_reg)<8)
			{
				$password_reg_err="Invalid Password";
			}
		}
		if(empty($f_err) && empty($l_err) && empty($email_err) && empty($username_reg_err) && empty($password_reg_err) && empty($gender_err))
		{
			$con = mysqli_connect("127.0.0.1","root","","akhi");
			if(mysqli_connect_errno())
			{
				echo "Error : Couldn't connect to database";
			}
			else
			{
				$insert_user_courses = mysqli_query($con , "insert into courses (username) values ('$username_reg')");
				$insert_user_exam = mysqli_query($con , "insert into exam (username) values ('$username_reg')");
				$insert_reg=mysqli_query($con,"insert into reg (f_name , l_name , email , username , password , gender) values ('$f_name' , '$l_name' , '$email' ,'$username_reg','$password_reg','$gender' )");
				if($insert_reg == false)
				{
					echo "Error : Couldn't insert";
					echo mysqli_error($con);
				}
				else
				{
					$bol=true;
				}
			}
		}
	}
	if(isset($_POST['signin_submit']))
	{
		$username_log=$_POST['username_log'];
		$password_log=$_POST['password_log'];
		$con = mysqli_connect("127.0.0.1","root","","akhi");
		if(mysqli_connect_errno())
		{
			echo "ERROR : Couldn't connect to database";
		}
		else
		{
			
			$result = mysqli_query($con,"select * from reg where username ='$username_log'");
			if($result != null)
			{
				
				while($row=mysqli_fetch_array($result))
				{ 
					if((strcmp($row['username'] ,$username_log ) == 0) && (strcmp($row['password'],$password_log) == 0))
					{
						
						session_start();
						$_SESSION['username'] = $row['username'];
						$_SESSION['name']=$row['f_name'];
						if($_SESSION['username'] == "admin")
						{
							header("location:admin.php");
						}
						else
						{
						echo'<script> window.location="main.php"; </script> ';
						}
						
					}
					else
					{
						
						$login_err = "Incorrect Username or Password";
					}
				}
			}
			else
			{
				$login_err = "ERROR : Enter correct username";
			}
		}
	}
	
	
?>
<html>
	<body>
		<nav class="header col-md-12">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sign_nav">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand" href="#">StartUp</a>
			</div>
			<div class="collapse navbar-collapse" id="sign_nav">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" id="signup_click"><span class="glyphicon glyphicon-user"></span> SignUp</a></li>
					<li><a href="#" id="signin_click"><span class="glyphicon glyphicon-log-in"></span> SignIn</a></li>
				</ul>
			</div>
		</nav>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home_body">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="instructions">
			</div>
			
			<div class="sign col-lg-3 col-md-3 col-sm-12 col-xs-12" id="sign">
				<div class="signup" id="signup">
					<center>
					<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<br>
					<h2 class="heading">SignUp</h2>
					<p><input type="text" name="f_name"  class='form-control txtbx' id="f_name" placeholder="FIRST NAME"/><?php if(isset($_POST['signup_submit'])){if(!empty($f_err) && isset($f_err)){echo "<span class='glyphicon glyphicon-remove tool'></span>";}else {echo "<span class='glyphicon glyphicon-ok'></span>";}}?></input></p>
					<p><input type="text" name="l_name" class='form-control txtbx' id="l_name" placeholder="LAST NAME"/><?php if(isset($_POST['signup_submit'])){if(!empty($l_err) && isset($l_err)){echo "<span class='glyphicon glyphicon-remove tool'></span>";}else {echo "<span class='glyphicon glyphicon-ok'></span>";}}?></p>
					<p>I'am 
					<input name="gender" type="radio" value="male" checked/>MALE
					<input name="gender" type="radio" value="female" />FEMALE </p>
					<p><input type="text" name="email" value="" class='form-control txtbx' id="email" placeholder="E-MAIL"/><?php if(isset($_POST['signup_submit'])){if(!empty($email_err) && isset($email_err)){echo "<span class='glyphicon glyphicon-remove tool'></span>";}else {echo "<span class='glyphicon glyphicon-ok'></span>";}}?></p>
					<p><input type="text" name="username_reg" id="username_reg" placeholder="USERNAME" class='form-control txtbx' value=""/><?php if(isset($_POST['signup_submit'])){if(!empty($username_reg_err) && isset($username_reg_err)){echo "<span class='glyphicon glyphicon-remove tool'></span>";}else {echo "<span class='glyphicon glyphicon-ok'></span>";}}?></p>
					<p><input type="password" name="password_reg" id="password_reg" class='form-control txtbx' placeholder="PASSWORD"/><?php if(isset($_POST['signup_submit'])){if(!empty($password_reg_err) && isset($password_reg_err)){echo "<span class='glyphicon glyphicon-remove tool'></span>";}else {echo "<span class='glyphicon glyphicon-ok'></span>";}}?></p>
					<p><button type="submit" class="btn btn-default btnw" data-toggle="modal" name="signup_submit">Submit</button></p>
					</form>
					</center>
					<div style="color:white"></div>
				</div>
				<div class="signin" id="signin">
					<center>
					<br>
					<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<h2 class="heading">SignIn</h2>
					<p><input type="text" name="username_log" id="username_log" placeholder="USERNAME" class='form-control txtbx' value=""/></p>
					<p><input type="password" name="password_log" id="password_log" class='form-control txtbx' placeholder="PASSWORD"/></p>
					<p><button type="submit" class="btn btn-default btnw" name="signin_submit">Submit</button></p>
					<br>
					
					
					
					
					<p class="login_error">
					<?php 
					if(isset($_POST['signin_submit']))
					{
						
						if(!empty($login_err))
						{
							
							echo $login_err;
						}
					}?></p>
					
					</form>
					</center>
				</div>
			</div>
		</div>
		
	</body>
</html>
