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
	<div class="hidden">
		<?php
		$pin=array();
		for($i=0; $i<count($tiles); $i++) {
			if(!isset($pin[intval($tiles[$i]['tile_pos_row'])])) {
				$pin[intval($tiles[$i]['tile_pos_row'])] = array();
			} else {
				$pin[intval($tiles[$i]['tile_pos_row'])][intval($tiles[$i]['tile_pos_col'])-1] = array(
					'point' => $tiles[$i]['tile_lat'].','.$tiles[$i]['tile_long'],
					'price' => $tiles[$i]['tile_price'],
					'tile_id' => $tiles[$i]['tile_id']
				);
			}
		}
		?>
		<script type="text/javascript">
			$( document ).ready(function() {
				TILES = [];
				<?php
				for($i=1; $i<count($pin); $i++) {
					for($j=1; $j<count($pin[0]); $j++) {
				?>
						TILES.push(new google.maps.Rectangle({
							strokeColor: '#FF0000',
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: '#FF0000',
							fillOpacity: 0.1,
							map: MAP,
							bounds: new google.maps.LatLngBounds(
								new google.maps.LatLng(<?php echo $pin[$i][$j-1]['point']; ?>),
								new google.maps.LatLng(<?php echo $pin[$i-1][$j]['point']; ?>)
							),
							GL: {
								tile_id: <?php echo $pin[$i-1][$j]['tile_id']; ?>,
								price: <?php echo $pin[$i-1][$j]['price']; ?>
							}
						  }));
				<?php
					}
				}
				?>
			});
		</script>
	</div>
		<?php
	}
