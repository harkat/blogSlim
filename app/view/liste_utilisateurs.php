
<section>
	<article>
	   	<div id="art1">
				<h3>Liste des Utilisateurs</h3>
				<?php
					$users = app\model\Utilisateur::where('profil', 'like', 'membre')->get()->sortBy("pseudo");
					if (count($users) <1) echo 'aucun utilisateur inscrit' ;
					else { ?>
					<form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/listeUtilisateur/delete">
					<?php foreach ($users as $v1) {
				?>		
					<div id="users">		
					<p id = "pseudo">pseudo : <?php  echo $v1->pseudo?></p>
					<p id="petitText"> nom : <?php  echo $v1->nom?></p>
					<p id="petitText">prenom : <?php  echo $v1->prenom?></p>
					<p id="petitText"> E-Mail : <?php  echo $v1->email?></p>
					<p id="petitText"> Inscrit le : <?php  echo $v1->created_at?></p>				
					<p id ="delete"> Suprimer cet utilisateur : <input type = "checkbox" name="supresse[]" value = "<?php echo $v1->id;?>"></p>
					</div>
					<?php }?>
					<br>
					<button id ="delete" type="submit" name="validation" value="Valider">Suprimer les utilisateurs</button>
					</form>
					<?php }?>
		</div>
	</article>
</section>



