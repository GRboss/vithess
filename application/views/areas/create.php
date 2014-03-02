<link href="<?php echo base_url(); ?>css/homepage.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/areas/create.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>js/jquery-ui-1.10.4.custom/css/start/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/timepicker.css" rel="stylesheet">

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?php echo base_url(); ?>js/map.js"></script>
<script src="<?php echo base_url(); ?>js/areas/create.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?php echo base_url(); ?>js/timepicker.js"></script>
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
						<a href="<?php echo base_url("index.php/homepage"); ?>" class="btn btn-default">Περιοχές</a>
						<a href="<?php echo base_url("index.php/enterprises/logout"); ?>" class="btn btn-default">Αποσύνδεση</a>
						<a href="<?php echo base_url("index.php/areas/create"); ?>" class="btn btn-lg btn-primary">
							<span class="glyphicon glyphicon-plus"></span> Δημιουργία</a>
					</span>
				</h1>
			</div>
		</div>
		<div class="row">
			<?php echo validation_errors(); ?>

			<?php echo form_open('areas/create'); ?>
			<div class="col-md-6">
				<label>Όνομα περιοχής</label>
				<input type="text" name="area_name" value="<?php echo set_value('area_name'); ?>" class="form-control input-md" />
				<label>Στιγμή ενεργοποίησης</label>
				<input type="text" name="area_timestamp_start" id="area_timestamp_start" value="<?php echo set_value('area_timestamp_start'); ?>" class="form-control input-md" />
				<label>Στιγμή απενεργοποίησης</label>
				<input type="text" name="area_timestamp_finish" id="area_timestamp_finish" value="<?php echo set_value('area_timestamp_finish'); ?>" class="form-control input-md" />
				<input type="hidden" name="tiles" id="tiles" value=""/>
				<span id="totalMoneySpan">€ <span id="totalMoneyAmount">0</span></span>
			</div>
			<div class="col-md-6">
				<label>Τίτλος μηνύματος</label>
				<input type="text" name="message_title" value="<?php echo set_value('message_title'); ?>" class="form-control input-md" />
				<label>Σύντομη περιγραφή</label>
				<input type="text" name="message_teaser" value="<?php echo set_value('message_teaser'); ?>" class="form-control input-md" />
				<label>Κείμενο μηνύματος</label>
				<textarea name="message_text" class="form-control input-md" rows="5"><?php echo set_value('message_text'); ?></textarea>
			</div>			

			<div style="text-align: right;"><button type="submit" class="btn btn-primary" style="margin: 10px 20px 10px 0;">Αποθήκευση</button></div>

			</form>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="map-canvas" style="height:500px;"></div>
			</div>
		</div>
	</div>
	<div class="">
		<?php
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
		
		?>
		<script type="text/javascript">
			$( document ).ready(function() {
				TILES = [];
				var rectangle = null;
				<?php
				for($i=1; $i<count($pin); $i++) {
					for($j=1; $j<count($pin[0]); $j++) {
				?>
						rectangle = new google.maps.Rectangle({
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
						});
						
						 TILES.push(rectangle);
				<?php
					}
				}
				?>		
				
				var TileManager = function() {
					var pin = [];

					this.handle = function(tile_id,price) {
						var i=0;
						var found = false;
						var found_pos = -1;

						for(i=0; i<pin.length; i++) {
							if(pin[i].tile_id===tile_id) {
								found = true;
								found_pos = i;
							}
						}

						if(!found) {
							pin.push({
								tile_id: tile_id,
								price: price
							});
							return 'in';
						} else {
							if(found_pos!==-1) {
								pin.splice(found_pos,1);
								return 'out';
							}
						}
					};
					
					this.updateTotalMoneyAmount = function(){
						var i=0;
						var sum = 0;
						for(i=0; i<pin.length; i++) {
							sum += pin[i].price;
						}
						$("#totalMoneyAmount").html(sum);
					};
					
					this.updateTiles = function(){
						var i=0;
						var ids = []
						for(i=0; i<pin.length; i++) {
							ids.push(pin[i].tile_id);
						}
						$("#tiles").val(ids.join("|"));
					};
				};

				var manager = new TileManager();

				function addClickEvent(tile) {
					var result = '';
					google.maps.event.addListener(tile, 'click', function() {
						result = manager.handle(tile.GL.tile_id,tile.GL.price);
						if(result==='in') {
							tile.setOptions({fillOpacity: 0.5});
						} else if(result==='out') {
							tile.setOptions({fillOpacity: 0.1});
						}
						manager.updateTotalMoneyAmount();
						manager.updateTiles();
					});
				}
				
				var i=0;
				for(i=0; i<TILES.length; i++) {
					addClickEvent(TILES[i]);
				}
				
				
			});
		</script>
	</div>
		<?php
	}
