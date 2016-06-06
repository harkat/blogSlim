
<section>
	<article>
	   	<div id="art1">
	   	<h3>Toutes les catégories</h3>
				<?php
					$categorie = app\model\Categorie::all(); 
					if (count($categorie)<1) echo "aucune catégorie ! vous devez vous connectez en administrateur pour en rajouter";
					else {
					foreach ($categorie as $cat) {
						$billet = app\model\Billet::where( 'id_categorie', 'like', $cat->id)->get();
				?>
					<div id="billets">
						<p id ="pseudo">Lable : <a href="http://medias4all.livehost.fr/blog/index.php/categorie/<?php echo $cat->id?>"><?php echo $cat->label?></a></p>
						<p id="petitText"> Nombre de billets : <?php  echo count($billet)?></p>
					</div>
				<?php }} ?>
				</div>
		</div>
	</article>
</section>