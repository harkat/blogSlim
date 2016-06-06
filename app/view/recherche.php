

<section>
	<article>
	   	<div id="art1">
				<h4>Résultas de recherche pour : <?php echo $query ?> </h4>
				<?php
				if (count($etu) < 1) echo "aucune publication avec le mot clé : $query";
				else {
					foreach ($etu as $v1) {
						$user = app\model\Utilisateur::where( 'id', 'like', $v1->id_utilisateur)->first();
						$categorie = app\model\Categorie::where( 'id', 'like', $v1->id_categorie)->first();
				?>
					<div id="billets">
						<p id ="pseudo">Pseudo : <?php  echo $user->pseudo?></p>
						<p id="petitText"><?php  echo $v1->date_billet?></p>
						<p id="petitText">Catégorie : <a href="https://webetu.iutnc.univ-lorraine.fr/www/harkat1u/index.php/categorie/<?php echo $categorie->id?>"><?php echo $categorie->label?></a></p>
						<p id="titre"><?php echo $v1->titre?></p>
						<p id="message"><?php  echo substr($v1->message,0,30).'...'?></p>
						<a  id="titre" href="https://webetu.iutnc.univ-lorraine.fr/www/harkat1u/index.php/billet/<?php  echo $v1->id?>">voir la publication</a>
					</div>
				<?php }} ?>
			
		</div>
	</article>
</section>



