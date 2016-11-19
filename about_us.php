<html>
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../dist/css/bootstrap-theme.min.css" rel="stylesheet">
	<!---CSS for Card -->
	<link rel="stylesheet" type="text/css" href="style.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="menu_trans.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="arrow_menu_about.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="rotating-card.css?v=<?=time();?>">
	<link href="https://fonts.googleapis.com/css?family=Pacifico|Michroma" rel="stylesheet">
	<script
          src="https://code.jquery.com/jquery-2.2.4.min.js"
          integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
          crossorigin="anonymous"></script>
	<script src="buttonScript.js?v=?v=<?=time();?>"></script>
	<script src="velocity.min.js?v=?v=<?=time();?>"></script>
	<script src="velocity.ui.js?v=?v=<?=time();?>"></script> 
	<meta charset="UTF-8">
</head>
<body>
<div class="container">
		<!-- Boton index --> 
	<div class="col_bar" onclick="buttonInit()" id="arrow_bar_about" async defer>
		<div class="con_bar">
			<div class="bar arrow-top-r"></div>
			<div class="bar arrow-middle-r"></div>
			<div class="bar arrow-bottom-r"></div>
		</div>
	</div>
	
    <div class="row">
        <h1 class="title">
            THE BEST TEAM YOU WILL EVER-EVER SEE
            <br>
            <small>Meet the crazy bastards who started this amazing project!</small>
        </h1>
<!-- First Line -->
<div class="col-sm-10 col-xs-8 col-sm-offset-1">
	<!-- First Card -->
		<div class="col-md-4 col-sm-12 col-md-offset-2">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f1.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/fer.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Fernando Téllez</h3>
                                <p class="profession">Software Ninjaneer</p>
                                <p class="text-center">Digital Systems & Robotics Engineering Student</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i> A00514019
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"El domingo haré una carne asada en Santiago"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Web design & Database Manager</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>2200</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>1800</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Korean</h4>
                                        <p>
                                            LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
	<!-- Second Card -->
		<div class="col-md-4 col-sm-12">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f8.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/ingrid.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Ingrid Navarro</h3>
                                <p class="profession">Chief Researcher in Dark Technologies</p>
                                <p class="text-center">Digital Systems & Robotics Engineering Student</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i> A00569236
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"¡Maldita sea!"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Sensors & Web Design</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>8000</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>1000</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Korean</h4>
                                        <p>
                                            LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
<!--         <div class="col-sm-1"></div> -->
		</div>
        <div class="col-sm-10 col-xs-8 col-sm-offset-1">
	<!-- Third Card -->	
         <div class="col-md-4 col-sm-12">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f2.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/renato.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Renato González</h3>
                                <p class="profession">Senior Electronics Prophet</p>
                                <p class="text-center">Digital Systems & Robotics Engineering Student</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i>A00812113
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"¿Cuándo nos vamos a juntar?"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Electronics & Telecommunications</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>1200</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>2300</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Korean</h4>
                                        <p>
                                            LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
	<!-- Fourth Card -->
		<div class="col-md-4 col-sm-12">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f9.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/dan.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Daniela Zacarías</h3>
                                <p class="profession">Digital Media Sith Lady</p>
                                <p class="text-center">Biomedical Engineering Student</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i> A00814138
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"Ok. Va. Yo lo hago"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Digital Management & Sensors</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>2400</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>1140</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Korean</h4>
                                        <p>
                                           LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
	<!-- Fifth Card -->
		<div class="col-md-4 col-sm-12">
		
		
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f10.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/mika.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Mikhail Rodríguez</h3>
                                <p class="profession">Master of Disaster</p>
                                <p class="text-center">Digital Systems and Robotics Engineering</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i>A00812761
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"Oigan chicosss..."</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Electronics & Sensors</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>??????</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4><3</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Divine-Beast</h4>
                                        <p>
                                            LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
<!-- Second Line  -->
	</div>	
<div class="col-sm-10 col-xs-8 col-sm-offset-1">
	<!-- Sixth Card -->
		<div class="col-md-4 col-sm-12 col-md-offset-2">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f7.jpg"/>
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/sedas.jpg"/>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Dr. Sergio W. Sedas</h3>
                                <p class="profession">Korean Chief Cheerleader Officer</p>
                                <p class="text-center"> PhD. Robotics and Computational Design </p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i> 
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"Ustedes pueden llegar a Carnegie Mellon"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Mentor & Spiritual Advisor</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>9000+</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>9000+</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Master Korean</h4>
                                        <p>
                                            LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
	<!-- Seventh Card -->
		<div class="col-md-4 col-sm-12">
             <div class="card-container">
                <div class="card">
                    <div class="front">
                        <div class="cover">
                            <img src="img/f6.jpg"/> 
                        </div>
                        <div class="user">
                            <img class="img-circle" src="img/mario.jpg"/> 
                        </div>
                        <div class="content">
                            <div class="main">
                                <h3 class="name">Mario Vega</h3>
                                <p class="profession">DJI Flight Commander</p>
                                <p class="text-center">Mechatronics Engineering Student</p>
                            </div>
                            <div class="footer">
                                <i class="fa fa-mail-forward"></i> A00812424
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back">
                        <div class="header">
                            <h5 class="motto">"¡Hay que volar el dron!"</h5>
                        </div>
                        <div class="content">
                            <div class="main">
                                <h4 class="text-center">Job Description</h4>
                                <p class="text-center">Flight Test Pilot</p>

                                <div class="stats-container">
                                    <div class="stats">
                                        <h4>1305</h4>
                                        <p>
                                            ATK
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>2200</h4>
                                        <p>
                                            DEF
                                        </p>
                                    </div>
                                    <div class="stats">
                                        <h4>Korean</h4>
                                        <p>
                                           LVL
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer">
                            <div class="social-links text-center">
                                <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                                <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                            </div>
                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            </div> <!-- end card-container -->
        </div> <!-- end col sm 3 -->
<!--         <div class="col-sm-1"></div> -->
		</div>
</div>

	<!-- Index --> 
	<div class="overlay-navigation">
		<nav role="navigation">
			<ul>
				<li><a href="index.php" data-content="The beginning">Inicio</a></li>
				<li><a href="about_us.php" data-content="Curious?">About Us</a></li>
				<li><a href="graphs.php" data-content="I got game">Monitor</a></li>
				<li><a href="https://weathermonitorblog.wordpress.com/" data-content="Only the finest">Blog</a></li>
			</ul>
		</nav>
	</div>
</body>
</html>