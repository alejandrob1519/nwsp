<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title></title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500' rel='stylesheet' type='text/css'>
	<style>
	*{padding:0;margin:0;}
body{
		font-family:'Ubuntu',Trebuchet, Arial, Helvetica, sans-serif;
	}
	#top-bar{position:fixed;
	width:100%;
	height:45px;
	top:0; left:0;
	color:#FFFFFF;
	background: #666;
	background: rgba(0,0,0,.6);
	box-shadow:0px 2px 2px rgba(0,0,0,.3);
	font-size:90%;
	font-family: 'Ubuntu',Arial, Helvetica, sans-serif;
	text-align:left;
	line-height:45px;
	border:0px solid transparent;
	border-bottom:0px;
	}
	#top-bar p{
	font-size:large;
	font-weight:500;
	margin:0;
	}
	#top-bar .title a{
	float:left;
	position:relative;
	font-size:large;
	left:0;
	border-right:2px solid #fff;
	-moz-transition:all.6s;/*Firefox*/
	-webkit-transition:all .6s;/*Crome/Safari*/
	-ms-transition:all .6s;/*IE-->No funciona todavía*/
	-o-transition:all .6s;/*Opera*/
	transition:all .6s;	
	color:#FFFFFF;
	text-decoration:none;
	padding:0 50px 0 10px;
	}
	
	#top-bar .title a:hover{
	left:20px;
	font-size:x-large;
	text-decoration:none;
	}
	#top-bar .link a{
	float:right;
	position:relative;
	right:0;
	border-left:2px solid #fff;
	-moz-transition:all.6s;/*Firefox*/
	-webkit-transition:all .6s;/*Crome/Safari*/
	-ms-transition:all .6s;/*IE-->No funciona todavía*/
	-o-transition:all .6s;/*Opera*/
	transition:all .6s;	
	color:#FFFFFF;
	text-decoration:none;
	padding:0 10px 0 50px;
	font-size:15px;
	}
	#top-bar .link a:after{
	content: ' »';
}
	#top-bar .link a:hover{
	text-decoration:underline;
	color:#FFC94D;
}
	#demo-nav-container{
		position:absolute;
		bottom:50px;
		width:100%;
		
	}
	#demo-nav{
		margin:0 auto;
		width: 170px;
		background: #666;
		background: rgba(0,0,0, .6);
		box-shadow:0px 2px 2px rgba(0,0,0,.3);
		border-radius:7px;
		overflow:hidden;/*Para que entre la lista*/
	}
	#demo-nav ul{
		float:right;
		margin-bottom:10px;
		margin-right:15px;
	}
	#demo-nav p{
		color:#fff;
		padding:0 0 5px 5px;
		margin:10px 0 3px 10px;
	}
	#demo-nav li.actual{background:#fff;}
	#demo-nav li.actual a{color:#2c2c2c;}
	#demo-nav li{
		display:inline-block;
		list-style:none;
		width:20px;
		height:20px;
		text-align:center;
		border-radius:10px;
		background:#666;
		box-shadow: 1px 2px 2px rgba(0,0,0,.6);
		line-height:20px;
		color:#fff;
		font-family:'Ubuntu', Arial, Helvetica, sans-serif;
	}
	#demo-nav li a{
		text-align:center;
		width:20px;
		height:20px;
		display:inline-block;
		color:#fff;
		line-height:20px;
		font-family:'Ubuntu', Arial, Helvetica, sans-serif;
		text-decoration:none;
	}
	#demo-container{
	position: relative;
	top: 50%;
	margin: 0 auto;
	}
	
#menu-altern
{
	color:#FFFFFF;
	width:100%;
	height:35px;
	box-shadow: 1px 2px 1px rgba(0,0,0,.3);	
	font-family:Ubuntu,Trebuchet, Arial, Helvetica, sans-serif;
	z-index:999;
	text-align:center;
	border-radius:4px;
	font-size:90%;
}

#menu-altern ul
{
	z-index:999;
}

#menu-altern ul li
{
	list-style:none;
	display:inline;
	float:left;
	width:140px;
	height:35px;
	line-height:35px;
	background:#666;
	cursor:pointer;
	border-right:1px solid #999;
}

#menu-altern ul li:first-child
{
	border-bottom-left-radius:4px;
	border-top-left-radius:4px;
}

#menu-altern ul li:first-child a
{
	border-bottom-left-radius:4px;
	border-top-left-radius:4px;
}

#menu-altern ul li:last-child,#menu-altern ul li:last-child a
{
	border-bottom-right-radius:4px;
	border-top-right-radius:4px;
	border-right:0;
}

#menu-altern .flechaabajo
{
	display:inline-block;
	position:relative;
	top:-1px;
	left:10px;
	border-left:6px solid transparent;
	border-top:6px solid #fff;
	border-right:6px solid transparent;
	border-bottom:0;
}

#menu-altern ul li a
{
	display:block;
	text-decoration:none;
	color:#fff;
	position:relative;
}

#menu-altern ul li ul
{
	box-shadow:none;
	position:relative;
	width:117px;
	z-index:999;
	border-radius:0;
	display:block;
}

#menu-altern ul li ul li
{
	display:block;
	box-shadow: 1px 2px 1px rgba(0,0,0,.3);
	float:none;
	position:relative;
	background:#666666;
	z-index:999;
	overflow: hidden;
	-moz-transition:all 1s;/*Firefox*/
	-webkit-transition:all 1s;/*Crome/Safari*/
	-ms-transition:all 1s;/*IE-->No funciona todavía*/
	-o-transition:all 1s;/*Opera*/
	transition:all 1s;
	opacity:0;
}

#menu-altern ul li ul li a
{
	color:#ffffff;
	border:0;
}

#menu-altern ul li ul li:first-child,#menu-altern ul li ul li:first-child a
{
	margin-left:0;
	border-radius:0;
}

#menu-altern ul li ul li:last-child
{
	border-right:1px solid #999;
	border-radius:0 0 4px 4px;
}
#menu-altern ul li ul li:last-child a
{
	border-radius:0 0 4px 4px;
}
#menu-altern ul li.destacada,#menu-altern ul li.destacada ul li
{
	background:#C00;
}

#menu-altern ul li.destacada:hover,#menu-altern ul li.destacada ul li:hover
{
	background:#FF1A1A;
}

#menu-altern ul li:hover
{
	background:#888;
}
#menu-altern ul li:hover ul li{
	opacity:1;
}
		
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="demo-container">
	<div id="menu-altern">
	<ul>
    <?php
		$menu = $this->login_model->listarMenu("5");
		
		$i = 1;

		foreach($menu as $dato){
        	if($i < count($menu)){
			?>
				<li><a href="<?php echo site_url($dato->enlace); ?>"><?php echo $dato->nombre?></a></li>
            	<?php
            }else{
				?>
				<li class="destacada"><a href="<?php echo site_url($dato->enlace);?>"><?php echo $dato->nombre?></a></li>
                <?php
            }
			$i++;
		}
	?>
	</ul>
	</div>
</div>
</body>
</html>

