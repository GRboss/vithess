<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?php echo base_url(); ?>js/map.js"></script>
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
							<a href="#" class="btn btn-default">Manage categories</a> 
							<a href="enterprises/logout" class="btn btn-default">Logout</a> 
							<a href="#" class="btn btn-lg btn-primary">
								<span class="glyphicon glyphicon-plus"></span> Create new</a>
						</span>
					</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="map-canvas" style="height:500px;"></div>
				</div>
			</div>
		</div>
			<?php
		}
