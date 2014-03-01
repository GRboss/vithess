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
							<a href="#" class="btn btn-lg btn-primary">
								<span class="glyphicon glyphicon-plus"></span> Δημιουργία</a>
						</span>   
					</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="span5">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Όνομα</th>
								<th>Ενεργοποίηση</th>
								<th>Απενεργοποίηση</th>
								<th>Πλακάκια</th>                                          
								<th>Κόστος</th>                                          
								<th>Κατάσταση</th>                                          
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($areas as $area) {
								echo '<tr>';
								echo '<td><a href="'.base_url('index.php').'/areas/details/'.$area['area_id'].'">'.$area['area_name'].'</a></td>';
								echo '<td>'.$area['area_timestamp_start'].'</td>';
								echo '<td>'.$area['area_timestamp_finish'].'</td>';
								echo '<td>'.$area['total_tiles'].'</td>';
								echo '<td>€ '.$area['sum_price'].'</td>';
								echo '<td>';
								$date_start = new DateTime($area['area_timestamp_start'], new DateTimeZone('Europe/Athens'));
								$date_finish = new DateTime($area['area_timestamp_finish'], new DateTimeZone('Europe/Athens'));
								if(time() < $date_start->format("U")) {
									echo '<span class="label label-warning">Εκκρεμεί</span>';
								} else if(($date_start->format("U") <= time()) && (time() <= $date_finish->format("U"))) {
									echo '<span class="label label-success">Ενεργή</span>';
								} else if($date_finish->format("U") < time()) {
									echo '<span class="label label-danger">Έληξε</span>';
								}
								echo '</td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
					<?php echo $pagination; ?>
				  </div>
			</div>
		</div>
			<?php
		}
