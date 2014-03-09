<script type="text/javascript" src="<?php echo base_url(); ?>js/enterprises.js"></script>
<link href="<?php echo base_url(); ?>css/enterprises.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<p style="text-align: center; font-size: 40px;">
				<a href="<?php echo base_url(); ?>" class="site-name">ViThess</a>
			</p>
			<div class="col-md-12">
				<div class="pr-wrap">
					<div class="pass-reset">
						<label>
							Enter the email you signed up with</label>
						<input type="email" placeholder="Email" />
						<input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
					</div>
				</div>
				<div class="wrap">
					<p class="form-title">
						Sign In</p>
					<?php echo validation_errors(); ?>
					<?php echo form_open('enterprises/login',array(
						'class' => 'login'
					)); ?>
						<input type="text" placeholder="Username" name="username" value="<?php echo set_value('username'); ?>" />
						<input type="password" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>" />
						<input type="submit" value="Sign In" class="btn btn-success btn-sm" />
						<div class="remember-forgot">
							<div class="row">
								<div class="col-md-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="rememberme" />
											Remember Me
										</label>
									</div>
								</div>
								<div class="col-md-6 forgot-pass-content">
									<a href="javascription:void(0)" class="forgot-pass">Forgot Password</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="posted-by">2014 - Apps for Greece</div>
	</div>
