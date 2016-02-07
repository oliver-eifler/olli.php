<?php
  require_once("php/config.php");
  header("Content-Type: text/html; charset=utf-8");
  header("X-UA-Compatible: IE=edge");
  header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Unavailable");
  offline_page();
  exit();

function offline_page()
{
  $html = "<!DOCTYPE HTML>";
  $html.= "<head>";
  $html.=   "<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=yes'>";
  $html.=   "<meta name='format-detection' content='telephone=no'/>";
  $html.=   "<title>Offline</title>";
  $html.=  "<style type='text/css'>";
  $html.=    file_get_contents("css/404.css");
  $html.=  "</style>";
  $html.= "</head>";
  $html.= "<body>";
  $html.=  "<img src='img/sick.png' alt=''>";
  $html.=  "<h1>Sorry ... Offline</h1>";
  $html.=  "<p><strong>".$_SERVER['HTTP_HOST']."</strong></p>";
  $html.=  "<p>&nbsp;</p>";
  $html.=  "<p>We are currently performing updates, please check back soon!</p>";
  $html.= "</body>";
  $html.= "</html>";
  $html.=  "<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->";

  echo $html;
}
?>