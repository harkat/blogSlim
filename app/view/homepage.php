

<section>
	<article>
	   	<div id="art1">
				<h3>Accueil</h3>
				<?php if (isset($_SESSION['auth'])){?>
				<form id="form" method="post" action="http://medias4all.livehost.fr/blog/index.php/posterPublication">
				Titre : <br><TEXTAREA name="titre" rows=1 cols=60></TEXTAREA><br>
				Catégorie : <select name="categorie">
								<?php
									$categorie = app\model\Categorie::all();
									foreach ($categorie as $v1) {
									      echo "<option value=".$v1->label.">".$v1->label."</option>";
									}
								?>
				          </select><br>
				Exprimez-vous : <br><TEXTAREA name="contenu" rows=5 cols=60></TEXTAREA><br>
				<button type = "submit" name="validation" value = "Valider">poster</button>
				</FORM>
				<?php
				}
					$billet = app\model\Billet::all()->sortByDesc("date_billet")->take(10);
					if (count($billet) < 1) echo "<p> aucune pubication ! </p>" ;
					else {
					foreach ($billet as $v1) {
						$user = app\model\Utilisateur::where( 'id', 'like', $v1->id_utilisateur)->first();
						$categorie = app\model\Categorie::where( 'id', 'like', $v1->id_categorie)->first();
				?>
					<div id="billets">
						<p id ="pseudo">Pseudo : <?php  echo $user->pseudo?></p>
						<p id="petitText"><?php  echo $v1->date_billet?></p>
						<p id="petitText">Catégorie : <a href="http://medias4all.livehost.fr/blog/index.php/categorie/<?php echo $categorie->id?>"><?php echo $categorie->label?></a></p>
						<p id="titre"><?php echo $v1->titre?></p>
						<p id="message"><?php  echo substr($v1->message,0,30).'...'?></p>
						<a  id="titre" href="http://medias4all.livehost.fr/blog/index.php/billet/<?php  echo $v1->id?>">voir la publication</a>
					</div>
					<?php }} ?>
			
		</div>
	</article>
</section>



