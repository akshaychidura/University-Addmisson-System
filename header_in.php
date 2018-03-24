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
					<li><a href="#"><span class="glyphicon glyphicon-user">&nbsp;</span><?php echo $_SESSION['name'];?></a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out">&nbsp;</span>logout</a></li>
				</ul>
			</div>
		</nav>
	</body>
	
</html>