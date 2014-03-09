<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>js/reported.js"></script>
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
							<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a> 
						</span>
						<span class="pull-right">
							<a href="<?php echo base_url("index.php/dashboard"); ?>" class="btn btn-default">Πίσω</a> 
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
							Αναφορές <span class="label label-info"><?php echo count($reports); ?></span></h3>
						
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<?php
							foreach($reports as $report) {
							?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<a href="<?php echo base_url('index.php/areas/details/'.$report['area_id']); ?>">
											<img src="http://1.s3.envato.com/files/54262369/Map-Generator-with-Real-3D-Markers-preview-80-x-80.png" class="img-circle img-responsive" alt="" /></div>
										</a>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="<?php echo base_url('index.php/areas/details/'.$report['area_id']); ?>">
												<?php echo $report['area_name']; ?></a>
											<div class="mic-info">
												Από: <a href="<?php echo base_url('index.php/company/info/'.$report['company_id']); ?>"><?php echo $report['company_name']; ?></a> στις <?php echo $report['message_creation_timestamp']; ?>
											</div>
										</div>
										<div class="comment-text">
											<i><?php echo $report['message_teaser']; ?></i><br/>
											<?php echo $report['message_text']; ?>
										</div>
										<div class="action">
											<button type="button" class="btn btn-success btn-xs reportButton" content="yes_<?php echo $report['message_id'].'_'.$report['report_id']; ?>" title="Αποδοχή αναφοράς και διαγραφή μηνύματος">
												<span class="glyphicon glyphicon-ok"></span>
											</button>
											<button type="button" class="btn btn-danger btn-xs reportButton" content="no_<?php echo $report['message_id'].'_'.$report['report_id']; ?>" title="Διαγραφή αναφοράς">
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
					</div>
				</div>
			</div>
		</div>
		<?php
	}
