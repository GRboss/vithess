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
							78</span>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="http://www.jquery2dotnet.com/2013/10/google-style-login-page-desing-usign.html">
												Google Style Login Page Design Using Bootstrap</a>
											<div class="mic-info">
												By: <a href="#">Bhaumik Patel</a> on 2 Aug 2013
											</div>
										</div>
										<div class="comment-text">
											Awesome design
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
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="http://bootsnipp.com/BhaumikPatel/snippets/Obgj">Admin Panel Quick Shortcuts</a>
											<div class="mic-info">
												By: <a href="#">Bhaumik Patel</a> on 11 Nov 2013
											</div>
										</div>
										<div class="comment-text">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
											euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim
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
							<li class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-1">
										<img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
									<div class="col-xs-10 col-md-11">
										<div>
											<a href="http://bootsnipp.com/BhaumikPatel/snippets/4ldn">Cool Sign Up</a>
											<div class="mic-info">
												By: <a href="#">Bhaumik Patel</a> on 11 Nov 2013
											</div>
										</div>
										<div class="comment-text">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
											euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim
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
						</ul>
						<a href="#" class="btn btn-primary btn-sm btn-block" role="button"><span class="glyphicon glyphicon-refresh"></span> More</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
