<!DOCTYPE html>

<html>
<head>
    <meta content="zh-cn" http-equiv="Content-Language" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huan Fitness Pal</title>
    <style>
       <?php include 'style.css';?>
    </style>
</head>
<body>
<header>
    <div class="Logo">
        <a href=""><img class="logo" src="weblogo.webp"></a>
        <h1 class="title">Huan Fitness Pal</h1>
    </div>

    <!-- Nav bar -->
    <div class="navbar">
        <nav>
			<ul class="navlink">
		<?php if(isset($_SESSION['Usr_id'])) { ?>
            
                <li><a href="Homepage.php"><i class="fa-solid fa-house"></i></a></li>
                <li><a href="Sponsor.php"><i class="fa-solid fa-handshake"></i></a></li>
                <li><a href="aboutUs.php"><i class="fa-solid fa-circle-info"></i></a></li>
                <li><a href="history.php"><i class="fa-solid fa-phone"></i></a></li>
                <li><a href="Profile/profile.php"><i class="fa fa-user"></i></a></li>
                <li><a href="Profile/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            
		<?php } elseif(isset($_SESSION['admin_id'])) {?>
				<li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
		<?php } else {?>
				<li><a href=""><i class="fa-solid fa-user-plus"></i></a></li>
				<li><a href=""><i class="fa-solid fa-right-to-bracket"></i></a></li>
		<?php }?>
			</ul>
        </nav>
    </div>
</header>
<main>
</html>