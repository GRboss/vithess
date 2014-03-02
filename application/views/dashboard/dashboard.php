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
					<h1>ViThess
						<span class="pull-right">
							<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a> 
						</span>   
					</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="panel panel-default widget">
					<div class="panel-heading">
						<span class="glyphicon glyphicon-comment"></span>
						<h3 class="panel-title">
							Περιοχές προς έγκριση</h3>
						<span class="label label-info">
							<?php echo $totalAreas; ?></span>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<?php
							foreach($areas as $area) {
							?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="http://www.jquery2dotnet.com/2013/10/google-style-login-page-desing-usign.html">
												<?php echo $area['area_name']; ?></a>
											<div class="mic-info">
												Από: <a href="#"><?php echo $area['company_name']; ?></a> στις <?php echo $area['message_creation_timestamp']; ?>
											</div>
										</div>
										<div class="comment-text">
											<i><?php echo $area['message_teaser']; ?></i><br/>
											<?php echo $area['message_text']; ?>
										</div>
										<div class="action">
											<button type="button" class="btn btn-primary btn-xs" title="Edit">
												<span class="glyphicon glyphicon-pencil"></span>
											</button>
											<button type="button" class="btn btn-success btn-xs" title="Approved">
												<span class="glyphicon glyphicon-ok"></span>
											</button>
											<button type="button" class="btn btn-danger btn-xs" title="Delete">
												<span class="glyphicon glyphicon-trash"></span>
											</button>
										</div>
									</div>
								</div>
							</li>
							<?php
							}
							?>
						</ul>
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
