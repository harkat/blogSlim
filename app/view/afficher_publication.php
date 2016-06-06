
<section>
	<article>
	   	<div id="art1">
				<?php
					$billet = app\model\Billet::where( 'id', 'like', $id)->first();
					$user = app\model\Utilisateur::where( 'id', 'like', $billet->id_utilisateur)->first();
					$categorie = app\model\Categorie::where( 'id', 'like', $billet->id_categorie)->first();
				?>
				<div id="unbillet">
					<p id ="pseudo"><?php  echo $user->pseudo?></p>
					<p id="petitText"><?php  echo $billet->date_billet?></p>
					<p id="petitText">Catégorie : <?php  echo $categorie->label?></p>
					<p id="titre"><?php  echo $billet->titre?></p>
					<p id="message"><?php  echo $billet->message?></p>
				</div>
				<div id="commentaires">
				<p id="spCom" > COMENTAIRES : </p>
				<?php if (isset($_SESSION['auth'])) {
				echo <<<end
				<form id="com_form" method="post" action="http://medias4all.livehost.fr/blog/index.php/commenter/$id">
						<textarea name="message" rows="2" cols="100" ></textarea><br>
	  					<input type="hidden" name="id_billet" value="$id">
	  					<button type="submit" name="validation"id="com_bouton"  value = "Valider">Commenter</button>
					</FORM>
end;
}
						$comment = app\model\Commentaire::where('id_billet', 'like', $id)->orderBy('id', 'DESC')->get();
						if(count($comment)<1) echo '<p> pas de commentaires </p>';
						else {
						foreach ($comment as $comm) {
							$user = app\model\Utilisateur::where( 'id', 'like', $comm->id_utilisateur)->first();
					?>
						<p id ="com_pseudo"><?php  echo $user->pseudo?>  </p>
						<p id ="com_text"><?php  echo $comm->message?></p>
						<p id="com_date"><?php  echo $comm->date_com?></p>
						<?php }} ?>
				</div>
		</div>
	</article>
</section>