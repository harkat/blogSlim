<?php $categorie = app\model\Categorie::where( 'id', 'like', $id)->first(); ?>
<section>
	<article>
	   	<div id="art1">
	   	<h3>Billets de la catégorie : <?php echo $categorie->label ?></h3>
				<?php
					$categorie = app\model\Categorie::where( 'id', 'like', $id)->first();
					$billet = app\model\Billet::where( 'id_categorie', 'like', $id)->get();
					if (count($billet)<1) echo "<p> pas de publication dans cette catégorie </p>";
					else {
					foreach ($billet as $v1) {
						$user = app\model\Utilisateur::where( 'id', 'like', $v1->id_utilisateur)->first();
				?>
					<div id="billets">
						<p id ="pseudo">Pseudo : <?php  echo $user->pseudo?></p>
						<p id="petitText"><?php  echo $v1->date_billet?></p>
						<p id="titre"><?php echo $v1->titre?></p>
						<p id="message"><?php  echo substr($v1->message,0,30).'...'?></p>
						<a  id="titre" href="http://medias4all.livehost.fr/blog/index.php/billet/<?php  echo $v1->id?>">voir la publication</a>
					</div>
				<?php }} ?>
				</div>
		</div>
	</article>
</section>