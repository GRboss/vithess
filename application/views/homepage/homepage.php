</head>
<body>
<?php

if($this->session->userdata('authenticated')!==1) {
	header("Location: ".base_url());
} else {
	
}
