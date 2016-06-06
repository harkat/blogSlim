<?php

/**
* Classe de controleur
* @author  HARKAT Amir
*
* @since 1.0
*/
class AdminController extends Controller {


	/**
	 * Methode qui genere l'affichage de la liste des utilisateurs inscrits
	 * pour les eradiers
	 */
	public function lister_utilisateurs () {
		if (isset($_SESSION['admin'])){ 
			Controller::header();
			Controller::$app->render('liste_utilisateurs.php');
			Controller::footer();
		}
		else 
			Controller::redirect("info", "vous devez vous connectez en administrateur avant", "login");
	}
	
	/**
	 * Methode qui suprime un utilisateur 
	 * @param int id utilisateur
	 */
	public function suprimer_utilisateur () {
		$app = Controller::$app;			
		if (isset($_SESSION['admin']) && isset($_POST) && $app->request->post('validation')=='Valider') {
			if($app->request->post('supresse') != null ) {
				foreach($app->request->post('supresse') as $id) {									
					$user = app\model\Utilisateur::where('id', 'like', $id)->first();
					$comment = app\model\Commentaire::where('id_utilisateur', 'like', $id)->get();
					$billet = app\model\Billet::where('id_utilisateur', 'like', $id)->get();
					if(count($comment)>0) 
						foreach ($comment as $comm) {
							app\model\Commentaire::destroy($comm->id);
						}					
					if(count($billet)>0) 
						foreach ($billet as $bill) {
							app\model\Billet::destroy($bill->id);
						}
					app\model\Utilisateur::destroy($id);						
				}
				Controller::redirect("info","Utilisteur(s) suprimé(s)", "listeUtilisateurs");
			}
			else Controller::redirect("error","Vous devez choisir les utilisateurs à suprimer", "listeUtilisateurs");
		}								
		else 
			Controller::redirect("info", "vous devez vous connectez en administrateur avant", "login");
	}
	
	/**
	 * Methode qui genere l'affichage de formulaire d'jout d'une nouvelle categorie
	 */
	public function ajout_categorie () {
		if (isset($_SESSION['admin'])){ 
			Controller::header();
			Controller::$app->render('ajouter_categorie.php');
			Controller::footer();
		}
		else 
			Controller::redirect("info", "vous devez vous connectez en administrateur avant", "login");
	}
	
	/**
	 * Methode qui ajoute la categorie renseigne dans le formulaire d'jout
	 */
	public function ajouter_categorie () {
		if (isset($_SESSION['admin'])){ 
			$app = Controller::$app;
			if (isset($_POST) && $app->request->post('validation')=='Valider') {
				$lab = $app->request->post('label');
				$label = trim($lab);
				$cat = app\model\Categorie::all();
				$temp = 0 ;
				foreach ($cat as $v1) {
			  		if ($v1->label === $label) $temp = -1 ;
				}
				if ($temp === 0){
					$categorie = new app\model\Categorie();
					$categorie->label = $label ;
					$categorie->save() ;
					Controller::redirect("info","nouvelle categorie : $label ajoutée", "afficherCategorie");
				}
				else 
					Controller::redirect("error","la catégorie : $label existe déjà", "afficherCategorie");
			}
		}
		else 
			Controller::redirect("info", "vous devez vous connectez en administrateur avant", "login");
	
	}
}			