<?php

/**
* Classe de controleur
* @author  HARKAT Amir
*
* @since 1.0
*/
class BilletController extends Controller {	
	
	/**
	 * Methode qui poste une publication ecrite dans le formulaire
	 */
	public function poster_publication () {
		$app = Controller::$app;
		if (isset($_POST) && $app->request->post('validation')=='Valider') {
			$id_user = $_SESSION['auth'] ;
			$titre = $app->request->post('titre') ;
		    $contenu = $app->request->post('contenu') ;
		    $categorie = $app->request->post('categorie') ;
			$cat = app\model\Categorie::where( 'label', 'like', $categorie)->first();
			if(empty($titre)||empty($contenu))
    			Controller::redirect("error", "veillez remplire les champs !", "ecrirePublication");
			else{
				$billet = new app\model\Billet();
				$billet->titre = $titre ;
				$billet->message = $contenu ;
				$billet->id_utilisateur = $id_user ;
				$billet->id_categorie = $cat->id ;
				$billet->save() ;
				Controller::redirect("info", "Nouvelle publication postée", "root");
			}    				
		}
	}
	
	/**
	 * Methode qui genere l'affichage de toute les publications avec un systeme de pagination
	 $ pour afficher 10 publications par page
	 */
	public function afficher_publication ($id){
		$billet = app\model\Billet::where( 'id', 'like', $id)->first();
		if (isset($billet)){
		Controller::header();
		Controller::$app->render('afficher_publication.php', compact('id'));
		Controller::footer();
		}
		else {
			Controller::redirect("error", "la publication n°: $id n'existe pas", "root");
		}
	}
	
	/**
	 * Methode qui poste un commentaire ecrit dans le formualire
	 */
	public function poster_commentaire ($id) {
		$app = Controller::$app;
		if (isset($_POST) && $app->request->post('validation')=='Valider') {
			$id_user = $_SESSION['auth'] ;			
			$message = $app->request->post('message') ;
		    $id_billet = $app->request->post('id_billet') ;
			if(empty($message)){
				$app->flash("error", "veillez remplire les champs !");
				$app->redirectTo("afficherUnePublication", compact('id'));
			}
			else{
				$commentaire = new app\model\Commentaire();
				$commentaire->message = $message ;
				$commentaire->id_utilisateur = $id_user ;
				$commentaire->id_billet = $id_billet ;
				$commentaire->save() ;
				$app->flash("info", "Nouveeau commentaire posté");
				$app->redirectTo("afficherUnePublication", compact('id'));				
			}    			
		}
	}
	
}