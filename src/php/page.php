<?php
/*
   Olli PHP Framework
   Page Router & Loader
*/
require_once("php/config.php");
require_once('php/util/path.inc.php');

/* the one and only page */
class Page {
  protected static $instance = NULL;
  public static function getInstance()
  {
  	if (self::$instance === NULL) {
	  self::load();
	}
	return self::$instance;
  }
  public static function load()
  {
    if (self::$instance !== NULL) {
      delete(self::$instance);
      self::$instance = NULL;
    }

    $request_url = get_request_url();
    $parts = parse_url($request_url);
    $request_uri = strtolower($parts['path']);
    /* Normalize Path */
    $path = remove_ext($request_uri);

    if (empty($path) || $path == "/" || $path=="/index" || $path=="/home") {
       $path="/start"; //later: do landing Page
    }
    else {
      //remove index from right
      $rm = "/index";
      $len = strlen($rm);
      if (substr($path,$len*-1) == $rm)
        $path = substr($path,0,strlen($path) - $len );
    }
    $request_cmd = $path;
    //create the commando
    $dir = 'pages'.$path;
    $cmd = array(); //default to read index.html
    $error = !(path2cmd($dir.'.php',$cmd) || path2cmd($dir.'.html',$cmd) || path2cmd($dir.'/index.php',$cmd) || path2cmd($dir.'/index.html',$cmd));
    $data = array(
      "request_url" => $request_url
      ,"request_uri" => $request_uri
      ,"request_cmd" => $request_cmd
      ,"cmd" => $cmd
    );
    $classname = "StaticPage";
    $classfile = "php/static.php";

    /*check if a *.php page is requested and exists*/
    if (!$error) {
      $path = $cmd["path"];
      if (!$error && preg_match("/^(.*)\.(php)$/i",$path)) {
          $classname = ucfirst($cmd["filename"])."Page";
          $classfile = $path;
          $data["modified"] = filemtime($classfile);
     }
    }

    require_once($classfile);
    $page = new $classname($data,$error);

    self::$instance = $page;
    return self::$instance;
  }
  protected function __construct() {}
  private function __clone() {}
}
?>