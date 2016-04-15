<?php require_once("config/config.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="_css/style.css" media="screen and (min-width:500px)">
<link rel="stylesheet" type="text/css" href="_css/mobile.css" media="screen and (max-width:500px)">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="plugins/stellar/stellar.js" type="text/javascript"></script>
<link rel="stylesheet" href="plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="plugins/main.js"></script>
<link href="favicon.ico" rel="icon" type="image/x-icon" />
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
<title>Lambourghini </title>
</head>
<body>

<header data-stellar-ratio="0.5">
<img class="active" src="_img/header.jpg" />
<img src="_img/header2.jpg" />
<img src="_img/header3.jpg" />
<img src="_img/header4.jpg" />
<img src="_img/header5.jpg" />
</header>
<nav>
<li><a href="?page=home">Home</a></li>
<li class="extend"><a href="#">Modellen</a>
<div>
<ul>
<?php 
foreach($autos as $id => $auto){
echo '<li><a href="?page=autos&id='.$id.'">'.$auto.'</a></li>';

}
?>
</ul>
</div>
</li>
<li><a href="?page=store">Store</a></li>
<li><a href="?page=dealers">Dealers</a></li>
<?php echo login(); ?>
<?php if(admin()) echo "<li><a href=\"admin\">Beheer</a></li>"; ?>
<div class="clear"></div>
</nav>
<article>

<?php

if(isset($_GET['page'])){
include("_inc/".$_GET['page'].".php");
}else{
include("_inc/home.php");
}
?>
</article>

<footer>

</footer>
</body>
</html>