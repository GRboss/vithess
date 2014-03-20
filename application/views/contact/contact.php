<link href="<?php echo base_url(); ?>css/landing.css" rel="stylesheet">
<style>
	.well {
		background-color: rgba(245, 245, 245, 0.4);
		border: none;
	}
</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<p style="text-align: center; font-size: 40px;">
				<a href="<?php echo base_url(); ?>" class="site-name"><img src="<?php echo base_url('css/images/logo.png'); ?>" /></a>
			</p>
		</div>
		<div class="container">
			<div class="row">
				<?php
				$stefanos = base_url('css/images/stefanos-kapiris.jpg');
				$georgia = base_url('css/images/georgia-latsiou.jpg');
				$pin = array();
				$pin[0] = '<div class="col-md-6">
						<div class="span3 well">
							<center>
								<a href="http://www.linkedin.com/in/stefanoskapiris" data-toggle="modal">
									<img src="'.$stefanos.'" name="aboutme" width="140" height="140" class="img-circle">
								</a>
								<h3>
									Στέφανος Καπίρης
								</h3>
								<em>
									Web & API Development
								</em>
							</center>
						</div>
					</div>';
				$pin[1] = '<div class="col-md-6">
					<div class="span3 well">
						<center>
							<a href="http://www.linkedin.com/pub/georgia-latsiou/79/4b9/367" data-toggle="modal">
								<img src="'.$georgia.'" name="aboutme" width="140" height="140" class="img-circle">
							</a>
							<h3>
								Γεωργία Λάτσιου
							</h3>
							<em>
								Android Development
							</em>
						</center>
					</div>
				</div>';
				shuffle($pin);
				foreach ($pin as $pos) {
					echo $pos;
				}
				?>
			</div>
			<div class="row">
				<div class="col-md-12">
					Ευχαριστούμε την κα <b><a target="_blank" href="http://www.csd.auth.gr/faculty-details.php?id=11">Αθηνά Βακάλη</a></b> και την ομάδα <b><a target="_blank" href="http://oswinds.csd.auth.gr/">OSWINDS</a></b> για την υποστήριξη και τη διαδικτυακή φιλοξενία.
				</div>
			</div>
		</div>
	</div>

</div>
