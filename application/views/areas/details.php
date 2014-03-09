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
						<?php if($user_company_id!="") { ?>
						<a href="<?php echo base_url("index.php/areas/create"); ?>" class="btn btn-lg btn-primary">
							<span class="glyphicon glyphicon-plus"></span> Δημιουργία</a>
						<?php } ?>
					</span>
				</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $message['message_title']; ?> <small><?php echo $state_name; ?></small></h3>
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
					<a href="#" class="list-group-item visitor">
						<h3 class="pull-right">
							<i class="fa fa-eye"></i>
						</h3>
						<h4 class="list-group-item-heading count">
							<?php echo $message['message_views']; ?></h4>
					</a>
					<table border="0" width="100%">
						<tr>
							<td width="50%">
								<p class="bg-primary" align="center">
									Αρέσει σε<br/>
									<span class="dis-likes"><?php echo $votes_up; ?></span>
								</p>
							</td>
							<td width="50%">
								<p class="bg-danger" align="center">
									Δεν αρέσει σε<br/>
									<span class="dis-likes"><?php echo $votes_down; ?></span>
								</p>
							</td>
						</tr>
					</table>
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
				for($k=0; $k<count($area_tiles); $k++) {
					if($pin[$i]['tile_id']==$area_tiles[$k]['tile_id']) {
						$pin[$i]['in_area'] = 1;
						break;
					}
				}
			}
		}
		
		for($i=0; $i<count($tiles); $i++) {
			$tiles[$i]['in_area'] = 0;
		}
		
		is_in_area($area_tiles, $tiles);
		
		?>
		<script type="text/javascript">
			$( document ).ready(function() {
				TILES = [];
				var rectangle = null;
				<?php
				for($i=0; $i<count($tiles); $i++) {
				?>
					rectangle = new google.maps.Rectangle({
						strokeColor: '#FF0000',
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: '#FF0000',
						fillOpacity: <?php echo $tiles[$i]['in_area']==1 ? 0.5 : 0.1 ?>,
						map: MAP,
						bounds: new google.maps.LatLngBounds(
							new google.maps.LatLng(<?php echo $tiles[$i]['tile_bl_lat'].','.$tiles[$i]['tile_bl_long']; ?>),
							new google.maps.LatLng(<?php echo $tiles[$i]['tile_tr_lat'].','.$tiles[$i]['tile_tr_long']; ?>)
						),
						GL: {
							tile_id: <?php echo $tiles[$i]['tile_id']; ?>,
							price: <?php echo $tiles[$i]['tile_price']; ?>,
							in_area: <?php echo $tiles[$i]['in_area']; ?>
						}
					});

					TILES.push(rectangle);
				<?php
				}
				?>		
				
				
				
				
			});
		</script>
	</div>
		<?php
	}
