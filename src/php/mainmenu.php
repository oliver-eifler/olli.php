<?php
/*
   Olli PHP Framework
   Menu Loader
*/
require_once("php/config.php");
require_once('php/util/path.inc.php');
require_once('php/class/registry.class.php');
/* the one and only mainmenu */
class MainMenu extends _registry
{
	protected static $instance = NULL;
    protected $menu = array();
	public static function getInstance()
	{
		if (self::$instance === NULL)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	protected function __construct() {
	  $this->loadMenu();
	}
	private function __clone() {}
    protected function loadMenu() {
    $json = "pages/mainmenu.json";
    if (file_exists($json))
      {
        $this->menu = json_decode(file_get_contents($json));
        return true;
      }
      return false;
    }


    //public functions
    public function getMenu()   {return $this->menu;}
}
?>