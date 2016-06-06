<?php
	$user = app\model\Utilisateur::where( 'id', 'like', $_SESSION['auth'])->first();
?>
<section>
	<article>
	   	<div id="art1">
	   		<h3>Mon Compte</h3>
			 <ul>
			    <li>Id : <?php echo $user->id?></a></li>
		        <li>Pseudo :<?php echo $user->pseudo ?></li>
		        <li>Nom : <?php echo $user->nom?></li>
		        <li>Prenom : <?php echo $user->prenom?></li>
		        <li>Adressse Mail : <?php echo $user->email?></li>
		        <li>Type du Compte : <?php echo $user->profil?></li>
		        <li>Inscrit le : <?php echo $user->created_at?></li>
		        <li>Dernière modification le : <?php echo $user->updated_at?></li>
		    </ul>
		</div>
			<div id="art1">
	   		<h4>Modifier Vos Informations </h4>
		    <form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/profile/modifInfo">
		         Nouveau Nom : <input type="text" id="nom" name="nom" placeholder="Entrez votre nouveau nom" required/><br>
		         Nouveau Prenom : <input type="text" id="prenom" name="prenom" placeholder="Entrez votre nouveau prenom" required/>
		        <button type = "submit" name="validation" value = "Valider">Valider</button>
        	</form> 
        	
        	<h4>Modifier votre Adresse Mail </h4>
		    <form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/profile/modifMail">
        		Nouvelle Adresse : <input type="text" id="nom" name="mail" placeholder="Entrez la nouvelle Adresse" required/><br>
	         	Confirmez l'adresse : <input type="text" id="prenom" name="mail1" placeholder="Confirmez l'adresse" required/>
		        <button type = "submit" name="validation" value = "Valider">Valider</button>
        	</form>
        	
			<h4>Modifier votre mot de passe </h4>
		    <form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/profile/modifPass">
		         Ancien Password : <input type="password" id="pas" name="pass" placeholder="Entrez votre Ancien pass" required/><br>
		         Nouveau Password : <input type="password" id="pas" name="pass1" placeholder="Entrez votre nouveau pass" required/><br>
		         Confirmez le Password : <input type="password" id="pas" name="pass2" placeholder="Confirmer votre passs" required/>
		        <button type = "submit" name="validation" value = "Valider">Valider</button>
        	</form> 
        	<h4> Suprimer Votre Compte </h4>
        	<form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/profile/delete/<?php  echo $_SESSION['auth'] ?>">
        		 Password : <input type="password" id="pas" name="pass" placeholder="Entrez votre pass" required/>
		        <button type = "submit" name="validation" value = "Valider">Suprimer le compte</button>
        	</form> 
		</div>
		
	</article>
</section>