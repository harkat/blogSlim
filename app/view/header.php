<?php
	$log = 'login">Connexion';
	$sign = 'signup">Inscription';
	if (isset($_SESSION['auth'])){
		$log = 'logout">Déconnexion' ;
		$sign = 'profile">Le Compte de : '.$_SESSION['nom'];
	}
	if (isset($_SESSION['admin'])){
		$users = '<li><a href="http://medias4all.livehost.fr/blog/index.php/listeUtilisateurs">Liste utlisateurs</a></li>';
		$categories = '<li><a href="http://medias4all.livehost.fr/blog/index.php/ajouterCategorie">Ajout catégorie</a></li>';
		
	}
?>
<!DOCTYPE html>
<html lang="fr">
    <head >
	<title>Blog APP</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="scale=1.0" />
	<link rel="stylesheet" href="/blog/static/css/style.css" type="text/css" media="screen" />
    </head>
    <div id="page">
		 <header>
			 <a href=""><img src="/blog/static/Images/logo.png" alt="logo" /></a>
			 <h1><a href="http://medias4all.livehost.fr/blog/index.php">Blog App </a></h1>
			 <h2><a href="">projet php</a>
			 <a id = "auth1" href="http://medias4all.livehost.fr/blog/index.php/<?php echo $log?></a>
			 <a id = "auth1" href="http://medias4all.livehost.fr/blog/index.php/<?php echo $sign?></a></h2>
			 <form id="form" method="get" action="http://medias4all.livehost.fr/blog/index.php/search">
    			 <input type="text" id="auth2" name="query" placeholder="Rechercher une publication" required/>
     			<button type = "submit" id="auth3">Rechercher</button>'
     		</form>
     		
		</header>
	 <div id="banniere">
		 <a href="http://medias4all.livehost.fr/blog/index.php"><img src="/blog/static/Images/HeaderBackGround.jpg" alt="banniere" /></a>
	 </div>
	 <nav>
		<ul>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/listBillet/1">Tous Les billets</a></li>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/statistique">Statistiques</a></li>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/categorie">Toutes les Categories</a></li>
            <?php if (isset($_SESSION['admin'])){	
					echo '<li><a href="http://medias4all.livehost.fr/blog/index.php/ajouterCategorie">Ajout catégorie</a></li>';
					echo '<li><a href="http://medias4all.livehost.fr/blog/index.php/listeUtilisateurs">Liste utlisateurs</a></li>';
			}
			?>
		</ul>
	</nav>
    <body>
	<?php  
	if (!empty($flash['error']))
	   echo <<<YOP
	<div class="error">
	    {$flash['error']}
	</div>
YOP;
	if (!empty($flash['info']))
	   echo <<<YOP
	<div class="info">
	    {$flash['info']}
	</div>
YOP
	?>

