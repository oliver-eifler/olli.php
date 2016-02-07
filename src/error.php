<?php
if (preg_match("/^(.*)\.(js|css|png|jp?g|gif|svg)$/i",$_SERVER['REQUEST_URI']))
{
    if (file_exists("pages".$_SERVER['REQUEST_URI']))
    {
        $file = "pages".$_SERVER['REQUEST_URI'];
        $mime = false;
        if (preg_match("/^(.*)\.(png)$/i",$file)) $mime = "image/png";
        else if (preg_match("/^(.*)\.(jp?g)$/i",$file)) $mime = "image/jpeg";
        else if (preg_match("/^(.*)\.(gif)$/i",$file)) $mime = "image/gif";
        else if (preg_match("/^(.*)\.(svg)$/i",$file)) $mime = "image/svg+xml";
        else if (preg_match("/^(.*)\.(js)$/i",$file)) $mime = "text/javascript";
        else if (preg_match("/^(.*)\.(css)$/i",$file)) $mime = "text/css";

        $modified = filemtime($file);
        $offset = 60 * 60 * 24 * 30; // Cache for a Month
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $modified)
        {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', $modified).' GMT',true, 304);
            exit();
        }

        header("Content-type: ".$mime);
        header ("Last-Modified: ".gmdate("D, d M Y H:i:s", $modified )." GMT",true,200);

        echo file_get_contents($file);
        exit();
    }

    $host  = $_SERVER['HTTP_HOST'];
    if (preg_match("/^(.*)\.(png|jp?g|gif)$/i",$_SERVER['REQUEST_URI']))
    {
        header('Content-type: image/png',true,404);
        echo file_get_contents("img/baselope.png");
        exit();
    }
    if (preg_match("/^(.*)\.(svg)$/i",$_SERVER['REQUEST_URI']))
    {
        header('Content-type: image/svg+xml',true,404);
        echo file_get_contents("img/lab.svg");
        exit();
    }
    if (preg_match("/^(.*)\.(js)$/i",$_SERVER['REQUEST_URI']))
    {
        header ('Content-type: text/javascript',true,404);
        echo "/* Nothing here */";
        exit();
    }
    if (preg_match("/^(.*)\.(css)$/i",$_SERVER['REQUEST_URI']))
    {
        header ('Content-type: text/css',true,404);
        echo "/* Nothing here */";
        exit();
    }
}
include 'template.php';
?>