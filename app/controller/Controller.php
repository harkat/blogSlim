<?php

use Slim\Slim;

class Controller {

    // Initialization impossible here: Slim does not yet exist!
    protected static $app;

    public function __construct(){
	if (empty(Controller::$app))
	    Controller::$app = Slim::getInstance();
    }
    
    	/**
	* Methode redirect qui redirige vers une Root slim et rajout un message flash aussi
	* @param flag    le flag du message a enreggistrer
	* @param str  le message a enregistrer autant que flash 
	* * @param url  le nom de la Root slim sur le quel se redirégé
	*/
	public function redirect($flag, $str, $url) {
		$app = Controller::$app;
		$app->flash($flag, $str);
		$app->redirectTo($url);
	}
	
	/**
	* Methode qui genere l'affichage du header la page html
	*/
    public function header() {
		$app = Controller::$app;
		$app->render('header.php',compact('app'));
    }
    
	/**
	* Methode qui genere l'affichage du footer la page html
	*/
    public function footer() {
		Controller::$app->render('footer.php');
    }
    
	/**
	* Methode qui genere l'ensemble la page html d'aceuil
	*/
    public function index(){
		$this->header();
		Controller::$app->render('homepage.php');
		$this->footer();
    }
}

?>
