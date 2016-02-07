<?php
/*
   Olli PHP Framework
*/
require_once('php/class/registry.class.php');
require_once("php/config.php");

class BasePage extends _registry
{
    protected $error = false;
    protected $html  ="";
    protected $menu = array();
    function __construct(&$data,$err = false)
    {
        $this->error = $err;
        $this->build = false;
        $this->modified = time();
        $this->dynamic = false;
        foreach ($data as $k => $v)
          $this->offsetSet($k,$v);
        if (!$this->error)
        {
          $this->loadMenu();
          $this->loadBackground();
          $this->init();
        }
    }
    //overwrite functions
    protected function init() {$this->build = true;}
    //utilitie functions
    protected function loadMenu() {
      $cmd = $this->cmd;
      $json = $cmd["dirname"]."/menu.json";
      if (file_exists($json))
      {
        $this->menu = json_decode(file_get_contents($json));
        return true;
      }
      return false;
    }
    protected function loadBackground() {
      $cmd = $this->cmd;
      $json = $cmd["dirname"]."/back.jpg";
      if (file_exists($json)) {
        $this->background = "/".$cmd["dirname"]."/back.jpg";
        return true;
      }
      return false;
    }


    //public functions
    public function getError()  {return $this->error;}
    public function getHtml()   {return $this->html;}
    public function getMenu()   {return $this->menu;}
    public function getBackground()   {return $this->background;}
    public function getCSS()
    {
        $css="";
        if ($this->background !== null) {
          $css = ".pageContainer:before {";
          if ($this->background === false)
          {
            $css .="background-image: none;";
          }
          else
          {
            $css .="background-image: -webkit-linear-gradient(rgba(250, 250, 255, 0.9), rgba(250, 250, 255, 0.9)), url('".$this->background."');";
            $css .="background-image: linear-gradient(rgba(250, 250, 255, 0.9), rgba(250, 250, 255, 0.9)), url('".$this->background."');";
          }
          $css .= "}";
        }
        if (empty($this->menu)) {
            $css .= ".pageWrapper-nav {display:none}";
        }

        if (!empty($css))
            $css = "<style type='text/css'>".$css."</style>";
        return $css;
    }

    public function getData($idx)
    {
        return $this->offsetGet($idx);
    }
    public function setData($idx,$value)
    {
        $this->offsetSet($idx,$value);
    }
    public function getPreparedTitle()
    {
        $config = Config::getInstance();
        $title = (!empty($this->short)?$this->short:$this->title);
        $title .= (!empty($title)? " | ":"").$config->title;
        return $title;
    }
    public function getPreparedDescription()
    {
        $config = Config::getInstance();
        $desc = (!empty($this->description)?$this->description:$config->desc);
        return $desc;
    }
    public function getPreparedTags()
    {
        return implode(", ",$this->getTagsArray());
    }
    protected function getTagsArray()
    {
        $config = Config::getInstance();
        $tags = $config->tags;
        if (!empty($this->tags))
            $tags = array_merge(explode(",",$this->tags),$tags);
        foreach($tags as $k => $v)
            $tags[$k] = strtolower(trim($v));
        return $tags;
    }
    public function getModifiedTime()
    {
        $time = $this->mtime;
        if (!empty($time))
            return strtotime($time);
        $time = $this->ctime;
        if (!empty($time))
            return strtotime($time);
        return $this->modified;
    }
    public function debugData()
    {
        $html="<ul>";
        $html.="<li><b>Error: <span style='color:".($this->error?"red'>ERROR":"green'>O.K")."</span></b></li>";
        foreach($this as $k => $v)
            $html.="<li><b>".$k."</b>: ".htmlentities(print_r($v,true),ENT_QUOTES|ENT_HTML401)."</li>";
        $html.="<li><b>Menu</b>: ".htmlentities(print_r($this->menu,true),ENT_QUOTES|ENT_HTML401)."</li>";
        foreach ($_SERVER as $name => $value)
        {
           if (substr($name, 0, 5) == 'HTTP_' || substr($name, 0, 6) == 'HTTPS_')
           {
               $html.="<li>".$name." = ".$value."</li>";
           }
        }

        $html.="</ul>";
        return $html;
    }
    public function isRootPath($uri)
    {
        $path = $this->request_uri;
        if ($path == $uri)
            return true;
        $parts = explode("/",trim($path,"/"));
        $path = "";
        foreach($parts as $part) {
            $path.="/".$part;
            if ($path == $uri)
                return true;
        }
        return false;
    }
}
?>