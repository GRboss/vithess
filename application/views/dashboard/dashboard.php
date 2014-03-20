<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">
<style>
	html,
	body {
		height: 100%;
		background-color: #333;
		background: url(<?php echo base_url(); ?>css/images/white-tower-blured.jpg) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
</style>

<script src="<?php echo base_url(); ?>js/dashboard.js"></script>
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
					<h1><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('css/images/logo.png'); ?>" width="100" /></a>
						<span class="pull-right">
							<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a> 
						</span>
						<span class="pull-right">
							<a href="<?php echo base_url("index.php/reported"); ?>" class="btn btn-default">Αναφορές</a> 
						</span>
					</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="panel panel-default widget">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-comment"></span>
							Περιοχές προς έγκριση <span class="label label-info"><?php echo $totalAreas; ?></span></h3>
						
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<?php
							foreach($areas as $area) {
							?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<a href="<?php echo base_url('index.php/areas/details/'.$area['area_id']); ?>">
											<img src="http://1.s3.envato.com/files/54262369/Map-Generator-with-Real-3D-Markers-preview-80-x-80.png" class="img-circle img-responsive" alt="" /></div>
										</a>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="<?php echo base_url('index.php/areas/details/'.$area['area_id']); ?>">
												<?php echo $area['area_name']; ?></a>
											<div class="mic-info">
												Από: <a href="<?php echo base_url('index.php/company/info/'.$area['company_id']); ?>"><?php echo $area['company_name']; ?></a> στις <?php echo $area['message_creation_timestamp']; ?>
											</div>
										</div>
										<div class="comment-text">
											<i><?php echo $area['message_teaser']; ?></i><br/>
											<?php echo $area['message_text']; ?>
										</div>
										<div class="action">
											<button type="button" class="btn btn-success btn-xs actionButton" content="yes_<?php echo $area['area_id']; ?>" title="Αποδοχή">
												<span class="glyphicon glyphicon-ok"></span>
											</button>
											<button type="button" class="btn btn-danger btn-xs actionButton" content="no_<?php echo $area['area_id']; ?>" title="Διαγραφή">
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
