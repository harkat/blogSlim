<?php
namespace conf;

use Illuminate\Database\Capsule\Manager as DB;

class Configuration{
    public static function config() {
	$db = new DB();
	$params = parse_ini_file('params.ini');
	
	$db->addConnection($params);
	$db->setAsGlobal();
	$db->bootEloquent();
    }
}
?>
