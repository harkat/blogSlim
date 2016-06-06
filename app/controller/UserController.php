<?php

/**
* Classe de controleur
* @author  HARKAT Amir
*
* @since 1.0
*/
class UserController extends Controller {
	
	/**
	* Methode qui genere un string aleatoir et de longueur précise, qui sera utiliser comme token de vérification mail
	* @param lenght    la longueur du string a generer
	* @return string   string aleatoir
	*/	
	public function str_random($length){
		$alphabet = "0123456789abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ;
		return substr((str_shuffle(str_repeat($alphabet, $lenght))), 0, $length) ;
	}
	
	/**
	* Methode qui genere l'affichage de la page html du profile utilisteur
	*/    
    public function profile(){
		if (isset ($_SESSION['auth'])) {
			Controller::header();
			Controller::$app->render('profile.php');
			Controller::footer();
		}
		else
			Controller::redirect("info", "Vous devez vous connectez", "login");
    }
    
    /**
	* Methode qui verifie et mis a jour, les nouveaux nom et prenom renseigne
	*/
    public function modification_info_base(){
    	$app = Controller::$app;
		if (isset ($_SESSION['auth'])) {
			$id = $_SESSION['auth'] ;
			$nom = $app->request->post('nom') ;
		    $prenom = $app->request->post('prenom') ;
			$user = app\model\Utilisateur::where( 'id', 'like', $id)->first();
			if(empty($nom)||empty($prenom)||
    				!preg_match('/^[a-zA-Z0-9_\-.]+$/',$nom)||
    				!preg_match('/^[a-zA-Z0-9_\-.]+$/',$prenom))
    			Controller::redirect("error", "Les information renseignés ne doivent pas contenir de caractères spéciaux !", "profile");
    		else {
    			$user->nom = $nom ;
    			$user->prenom = $prenom ;
    			$user->save() ;
    			Controller::redirect("info", "Les information ont bien été mises à jour", "profile");
    		}
		}
		else
			Controller::redirect("info", "Vous devez vous connectez", "login");
    }
    
    /**
	* Methode qui verifie la nouvelle adresse mail renseignee par que l'utilisateur
	* et qui envoie un mail pour verifie la nouvelle adresse renseigne 
	*/
     public function modification_mail(){
    	$app = Controller::$app;
		if (isset ($_SESSION['auth'])) {
			$id = $_SESSION['auth'] ;
			$mail = $app->request->post('mail') ;
		    $mail1 = $app->request->post('mail1') ;
			$user = app\model\Utilisateur::where( 'id', 'like', $id)->first();
			if ($mail === $mail1) {
				if(empty($mail)|| !filter_var($mail, \FILTER_VALIDATE_EMAIL) || $mail == $user->email)
	    			Controller::redirect("error","l'Email : ".$mail." n'est pas valide !", "profile");
	    		else {
	    			$token = str_random(60) ;
	    			$user->temp_email = $mail ;
	    			$user->confirmation_token = $token ;
	    			$user->save() ;
    				mail($mail, 'Confirmation changement EMAIL', "Afin de valider votre nouvelle adresse mail, merci de cliquer sur ce lien\n\nhttp://medias4all.livehost.fr/blog/index.php/confirmation?id=".$user->id."&token=".$token);
					Controller::redirect("info","Modfication E-Mail reussie, veillez confirmer cette nouvelle adresse fin de valider les changements", 'profile');
	    		}
			}
			else
				Controller::redirect("error","les deux adresses mail ne correspondent pas", 'profile');
		}
		else
			Controller::redirect("info", "Vous devez vous connectez", "login");
    }
    
    /**
	* Methode qui verifie le nouveau mot de passe renseignee par que l'utilisateur
	* et qui mis a jour le mot de passe de l'utilisateur
	*/
    public function modification_pass(){
    	$app = Controller::$app;
		if (isset ($_SESSION['auth'])) {
			$id = $_SESSION['auth'] ;
			$pass = $app->request->post('pass') ;
		    $pass1 = $app->request->post('pass1') ;
		    $pass2 = $app->request->post('pass2') ;
		    $user = app\model\Utilisateur::where( 'id', 'like', $id)->first();
		    if (crypt($pass, $user->mdp) != $user->mdp)
    			Controller::redirect("error","Ancien mot de passe utilisteur incorrect", 'profile');
			else if ($pass1 != $pass2) 
    			Controller::redirect("error","les deux mots de passe ne correspondent pas", 'profile');
	    	else {
		    	$hash = crypt($pass1);
				$user->mdp = $hash ;
				$user->save() ;
	    		Controller::redirect("info","Votre mot de passe a bien été modifier", "profile");
    		}
		}
		else
			Controller::redirect("info", "Vous devez vous connectez", "login");
    }
    
    
	 /**
	* Methode qui permet aux utlisateurs de suprimer
	* leurs comptes aisni que tous les commentaires et 
	* publications faits
	*/
	public function suprimer_compte ($id) {
		$app = Controller::$app;
		if (isset($_POST) && $app->request->post('validation')=='Valider') {
			$pass = $app->request->post('pass') ;
			$user = app\model\Utilisateur::where('id', 'like', $id)->first();
			if (crypt($pass, $user->mdp) === $user->mdp) {
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
				session_destroy() ;
				setcookie('remember', null, -1, '/');
				session_start ();
				app\model\Utilisateur::destroy($id);
				Controller::redirect("info","Votre compte a été suprimé", "root");
			}
			else 
				Controller::redirect("error","Mot de passe incorrect !", "profile");
		}
	}
}
?>