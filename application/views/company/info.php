<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">
</head>
<body>
	<?php
	if ($this->session->userdata('authenticated') !== 1) {
		header("Location: " . base_url());
	} else {
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1><a href="<?php echo base_url(); ?>">ViThess</a>
					<span class="pull-right">
						<a href="<?php echo base_url("index.php/dashboard"); ?>" class="btn btn-default">Περιοχές</a>
						<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a>
						<a href="<?php echo base_url("index.php/areas/create"); ?>" class="btn btn-lg btn-primary">
							<span class="glyphicon glyphicon-plus"></span> Δημιουργία</a>
					</span>
				</h1>
			</div>
		</div>
	</div>
		<?php
	}
