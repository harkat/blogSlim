<?php

/**
* Classe de controleur
* @author  HARKAT Amir
*
* @since 1.0
*/
class AnonymousController extends Controller {
	
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
	 * Methode qui genere l'affichage des bollets avec un systeme de paginantion
	 * @param int numero de la page demandee
	 */
	public function lister_billet($cPage){
		Controller::header();
		Controller::$app->render('liste_billets.php' ,compact('cPage'));
		Controller::footer();
	}
	
	/**
	 * Methode qui genere l'affichage des statistiques des categories utilises
	 * pour ecrire les billets
	 * @param int numero de la page demandee
	 */
	public function afficher_stats(){
		Controller::header();
		Controller::$app->render('camembert_3D.php');
		Controller::footer();
	}
	
	/**
	 * Methode qui genere l'affichage dd'une categorie demandee
	 * @param int id de la categorie demandee
	 */
	
	public function afficher_categorie($id){
		$categorie = app\model\Categorie::where( 'id', 'like', $id)->first();
		if (isset($categorie)){
			Controller::header();
			Controller::$app->render('afficher_categorie.php', compact('id'));
			Controller::footer();
		}
		else {
			Controller::redirect("error", "la categorie n'existe pas", "root");
		}
	}
	
	/**
	 * Methode qui genere l'affichage d'une recherche dans la liste des billet
	 */
	public function search(){
		$app = Controller::$app;
		$query = $app->request->get('query') ;
		$etu = app\model\Billet::where( 'titre', 'like', "%".$query."%")
									->orwhere( 'message', 'like', "%".$query."%")
									->get();
   		Controller::header();
		Controller::$app->render('recherche.php',compact('etu', 'query'));
		Controller::footer();
	}
	
	/**
	 * Methode qui genere l'affichage de toutes les categorie
	 */
	public function liste_categories(){
		Controller::header();
		Controller::$app->render('liste_categories.php');
		Controller::footer();
	}
    
    /**
	* Methode qui genere l'ensemble la page html du login
	*/
    public function login(){
	    if (isset ($_SESSION['auth'])) 
			Controller::redirect("info", "", "profile");
		else{
			Controller::header();
			Controller::$app->render('login.php');
			Controller::footer();
	    }
    }
    
    /**
	* Methode qui genere l'affichage du formulaire d'u mot de passe oublie'inscription
	*/
     public function signup(){
		Controller::header();
		Controller::$app->render('formulaire_inscription.php');
		Controller::footer();
    }
	 
	/**
	* Methode qui deconnecte un utilisateur deja conecte
	*/   
	public function logout () {	
		session_destroy() ;
		setcookie('remember', null, -1, '/');
		session_start ();
		Controller::redirect("info", "Vous venez de vous déconnecter!", "login");
	}
	
	/**
	* Methode qui genere l'affichage du formulaire du mot de passe oublie
	*/  
	 public function forget_pass() {
		Controller::header();
		Controller::$app->render('formulaire_pass_oublié.php');
		Controller::footer();
	}
	
    
    /**
	* Methode qui genere l'affichage du formulaire du mot de passe oublie apres verification mail
	*/
     public function new_pass_form(){
	   if (isset ($_SESSION['initPass'])) {
		    $app = Controller::$app;
			$app->render('formulaire_init_pass.php',compact('app'));
	    }
		else{
			Controller::header();
			Controller::$app->render('login.php');
			Controller::footer();
	    }
    }
    
    /**
	* Methode qui verifie et mis a jour le nouveau mot de passe renseinge apres verification mail (mot de passe oublie)
	*/
    public function new_pass_submit(){
	   $app = Controller::$app;
		if (isset ($_SESSION['initPass'])) {
			$id = $_SESSION['initPass'] ;
		    $pass1 = $app->request->post('pass1') ;
		    $pass2 = $app->request->post('pass2') ;
		    $user = app\model\Utilisateur::where( 'id', 'like', $id)->first();
			if ($pass1 === $pass2){
		    	$hash = crypt($pass1);
				$user->mdp = $hash ;
				$user->save() ;
				session_destroy() ;
				session_start ();
	    		Controller::redirect("info","Votre mot de passe a bien été mis à jour, vous pouvez l'utiliser pour vous connectez", "login");
    		} 
	    	else 
	    		Controller::redirect("error","les deux mots de passe ne correspondent pas", 'newPassForm');
		}
		else
			Controller::index();
    }
    
    /**
	* Methode qui verifie l'adresse mail renseignee pour la recupuration du mot de passe oublier
	* et qui envoie un mail de verification pour renitialiser un nouveau mot de passe
	*/
    public function initialiser_pass(){
		$app = Controller::$app;
		if (isset($_POST) && $app->request->post('validation')=='Valider') {
				
			$mail = $app->request->post('mail') ;
		   	$user =  app\model\Utilisateur::where( 'email', 'like', $mail)->first();
		   	
		   	if (isset($user) && $user->confirmed_at != null) 
		   	{
		   		$reset_token = str_random(60) ;
		   		$user->reset_token = $reset_token ;
		   		$user->reset_at = date("Y-m-d H:i:s");
		   		$user->save() ;
				mail($mail, 'Password Reset', "Afin de renitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://medias4all.livehost.fr/blog/index.php/confirmation?id=".$user->id."&reset_token=".$reset_token);
		   		Controller::redirect("info","Les instruction de rénitialisation on été envoyés par Email", 'login');
		   	}
			else 
		        Controller::redirect("error","L'adresse mail : ".$mail." n'existe pas", "forgetPass");
		}
		else 
			Controller::redirect("info", "", "login");
	}
    
    /**
	* Methode qui verifie le couple pseudo / mot de passe et connecte l'utilisateur par une session
	* ou avec la création d'un cookie d'une semaine
	*/
    public function authentification () {
    	$app = Controller::$app;
    	
    	if (isset($_POST) &&  $app->request->post('validation') =='Valider') {
			
    		$username = $app->request->post('user') ;
    		$pass = $app->request->post('pass');
    	   	$user = app\model\Utilisateur::where( 'pseudo', 'like', $username)->first();
    	   	if (isset($user)) {
	    	   	if ($user->confirmed_at != null)
		    	{
		    	    if (crypt($pass, $user->mdp) == $user->mdp){
		    	    	if($user->profil === 'admin')	$_SESSION['admin'] = $user->id ;
		    	    	$_SESSION['auth'] = $user->id ;
		    	    	$_SESSION['nom'] = $user->pseudo ;
		    	    	$remeber = $app->request->post('remember');
		    	    	
		    	    	if (isset($remeber))
		    	    	{
		    	    		$remember_token = str_random(250) ;
		    	    		$user->remember_token = $remember_token ;
		    	    		$user->save() ;
		    	    		setcookie('remember', $user->id."//".$remember_token.md5($user->username)."snapu", time() + 60 * 60 * 24* 7, '/' );
		    	    	}
		    	    	
				    	$app->redirectTo('profile');
			        }
			        else
			        	Controller::redirect("error","Mot de passe incorrect", "login");
	    	   	}
	    	   	else 
	    	   		Controller::redirect("error","Compte non validé ! vérifiez votre boite mail", "login");
	    	   		
			}
			else 
				Controller::redirect("error","Indentifiants incorrects", "login");
		}
		else 
			$this->redirect("error","données non envoyées", "login");
    }

   /**
	* Methode qui verifie les donnees rensegniees pour l'inscription
	* et qui envoie un mail a l'utilisateur pour la validation de son compte
	*/
 	public function signedUp (){
		$app = Controller::$app;
		if (isset($_POST) && $app->request->post('validation')=='Valider') {
		    $username = $app->request->post('user') ;
		    $nom = $app->request->post('nom') ;
		    $prenom = $app->request->post('prenom') ;
    		$pass = $app->request->post('pass') ;
    		$pass1 = $app->request->post('pass1') ;
    		$mail = $app->request->post('mail') ;
    		
    		if(empty($username)|| empty($nom)||empty($prenom)||
    				!preg_match('/^[a-zA-Z0-9_\-.]+$/',$username)||
    				!preg_match('/^[a-zA-Z0-9_\-.]+$/',$nom)||
    				!preg_match('/^[a-zA-Z0-9_\-.]+$/',$prenom))
    			Controller::redirect("error", "Les information renseignés ne doivent pas contenir de caractères spéciaux !", "signup");
    		
    		
    		elseif (app\model\Utilisateur::where( 'pseudo', 'like', $username)->exists())
    			Controller::redirect("error","Le pseudo : ".$username." existe déjà !", 'signup');
    			
    		elseif(empty($mail)|| !filter_var($mail, \FILTER_VALIDATE_EMAIL))
    			Controller::redirect("error","l'Email : ".$mail." n'est pas valide !", "signup");
    		
    		elseif ($pass != $pass1) 
    			Controller::redirect("error","Les deux mots de passes renseignés ne correspondent pas !", "signup");
    			
    		elseif (app\model\Utilisateur::where( 'email', 'like', $mail)->exists())
    			Controller::redirect("error","l'Adresse Mail : $mail existe déjà !", 'signup');
    		
    		else{
    			$hash = crypt($pass);
    			$token = str_random(60) ;
    			$user = new app\model\Utilisateur();
    	    	$user->pseudo = $username ;
    	    	$user->nom = $nom ;
    			$user->prenom = $prenom ;
    			$user->email = $mail ;
    			$user->mdp = $hash ;
    			$user->confirmation_token = $token ;
    			$user->save() ;
    			mail($mail, 'Confirmation EMAIL', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://medias4all.livehost.fr/blog/index.php/confirmation?id=".$user->id."&token=".$token);
				Controller::redirect("info","Inscription reussie, veillez suivre les instructions envoyées sur l'adresse : $mail afin de valider votre compte", 'root');
    		}
		}
		else
	        Controller::redirect("info","Veillez remplire le formulaire d'inscription", "signup");
	}
	
	/**
	* Methode qui verifie les differents liens de confirmation envoyes par mail, pour la creation d'un
	*  nouveau compte, le changement de l'adressse mail ou la recupuration d'un nouveau mot de passe
	*/
	public function confirmation() {
		$app = Controller::$app;
		$user_id = $app->request->get('id') ;
		$token = $app->request->get('token') ;
		$reset_token = $app->request->get('reset_token') ;
		$usr = app\model\Utilisateur::where( 'id', 'like', $user_id)->first();
		$date = $usr->reset_at ;
		
		if($usr->confirmation_token != null) {
			if ($usr->temp_email != null) {
				$usr->email = $usr->temp_email ;
				$usr->temp_email = null;
				$usr->confirmation_token = null ;
				$usr->save();
				Controller::redirect("info","Vérification de la nouvelle adresse mail effectuée, votre nouvelle adresse mail est : '".$usr->email."' vous pouvez vous connectez", "root");
			}
			else if ($usr->confirmation_token === $token) {
				$usr->confirmation_token = null ;
				$usr->confirmed_at = date("Y-m-d H:i:s");
				$usr->save();
				Controller::redirect("info","Vérification de l'adresse mail effectué, votre compte est activé maintenant :) vous pouvez vous connectez", "root");
			}
			else
				Controller::redirect("error","Token non valide !", "root");
		}
		else if($usr->reset_token !=null && $usr->reset_token === $reset_token) {
				$usr->reset_token = null ;
				$_SESSION['initPass'] = $usr->id ;
				$usr->save() ;
				Controller::redirect("info","renseigné un nouveau mot de passe", "newPassForm");
			}
		else
			Controller::redirect("error","Token non valide !", "root");
	}
}
?>