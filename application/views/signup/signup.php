
<style>
	.well {
		background-color: rgba(245, 245, 245, 0.4);
		border: none;
	}
</style>
<style>
	html,
	body {
		height: 100%;
		background-color: #333;
		background: url(<?php echo base_url(); ?>css/images/thess.jpg) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	body
	{
		padding-top: 40px;
	}


	.input-group-addon
	{
		background-color: rgb(50, 118, 177);
		border-color: rgb(40, 94, 142);
		color: rgb(255, 255, 255);
	}
	.form-control:focus
	{
		background-color: rgb(50, 118, 177);
		border-color: rgb(40, 94, 142);
		color: rgb(255, 255, 255);
	}
	.form-signup input[type="text"],.form-signup input[type="password"] { border: 1px solid rgb(50, 118, 177); }
	.panel-body {
		background-color: rgba(245, 245, 245, 0.4);
		border: none;
	}
</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<p style="text-align: center; font-size: 40px;">
				<a href="<?php echo base_url(); ?>" class="site-name"><img src="<?php echo base_url('css/images/logo.png'); ?>" /></a>
			</p>
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h5 class="text-center">
							SIGN UP</h5>
						<form class="form form-signup" role="form" method="post" action="<?php echo base_url('index.php/signup/save'); ?>">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input type="text" name="username" class="form-control" placeholder="Username" />
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
									</span>
									<input type="text" name="email" class="form-control" placeholder="Email Address" />
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input type="password" name="password" class="form-control" placeholder="Password" />
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
									<select name="type" class="form-control">
										<option value="2">Επιχείρηση</option>
										<option value="3">Δημοτική Αρχή</option>
									</select>
								</div>
							</div>
					</div>
					<input type="submit" class="form-control" value="Submit" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div> 