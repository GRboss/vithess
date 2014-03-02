<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/areas/details.css" rel="stylesheet">

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
						<?php if($user_company_id=="") { ?>
						<a href="<?php echo base_url("index.php/dashboard"); ?>" class="btn btn-default">Περιοχές</a>
						<?php } else { ?>
						<a href="<?php echo base_url("index.php/homepage"); ?>" class="btn btn-default">Περιοχές</a>
						<?php } ?>
						<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a>
						<a href="<?php echo base_url("index.php/areas/create"); ?>" class="btn btn-lg btn-primary">
							<span class="glyphicon glyphicon-plus"></span> Δημιουργία</a>
					</span>
				</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $message['message_title']; ?></h3>
					</div>
					<div class="panel-body">
						<i><?php echo $message['message_teaser']; ?></i>
						<hr>
						<?php echo $message['message_text']; ?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group">
					<a href="http://www.jquery2dotnet.com" class="list-group-item visitor">
						<h3 class="pull-right">
							<i class="fa fa-eye"></i>
						</h3>
						<h4 class="list-group-item-heading count">
							<?php echo $message['message_views']; ?></h4>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="map-canvas" style="height:500px;"></div>
			</div>
		</div>
	</div>
	<div class="">
		<?php
		function is_in_area($area_tiles,&$pin) {
			for($i=0; $i<count($pin); $i++) {
				for($j=0; $j<count($pin[0]); $j++) {
					for($k=0; $k<count($area_tiles); $k++) {
						if($pin[$i][$j]['tile_id']==$area_tiles[$k]['tile_id']) {
							$pin[$i][$j]['in_area'] = 1;
							break;
						}
					}
				}
			}
		}
		
		$pin=array();
		for($i=0; $i<count($tiles); $i++) {
			if(!isset($pin[intval($tiles[$i]['tile_pos_row'])])) {
				$pin[intval($tiles[$i]['tile_pos_row'])] = array();
				$i--;
			} else {
				$pin[intval($tiles[$i]['tile_pos_row'])][intval($tiles[$i]['tile_pos_col'])] = array(
					'point' => $tiles[$i]['tile_lat'].','.$tiles[$i]['tile_long'],
					'price' => $tiles[$i]['tile_price'],
					'tile_id' => $tiles[$i]['tile_id'],
					'in_area' => 0
				);
			}
		}
		
		is_in_area($area_tiles, $pin);
		
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
							fillOpacity: <?php echo $pin[$i-1][$j]['in_area']==1 ? 0.5 : 0.1 ?>,
							map: MAP,
							bounds: new google.maps.LatLngBounds(
								new google.maps.LatLng(<?php echo $pin[$i][$j-1]['point']; ?>),
								new google.maps.LatLng(<?php echo $pin[$i-1][$j]['point']; ?>)
							),
							GL: {
								tile_id: <?php echo $pin[$i-1][$j]['tile_id']; ?>,
								price: <?php echo $pin[$i-1][$j]['price']; ?>,
								in_area: <?php echo $pin[$i-1][$j]['in_area']; ?>
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
