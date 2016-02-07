<?php
/**
 * Olli Framework
 * This file is part of the Olli-Framework
 * Copyright (c) 2012-2015 Oliver Jean Eifler
 *
 * @version 0.0.1
 * @link http://www.framework.dd/
 * @author Oliver Jean Eifler <oliver.eifler@gmx.de>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
require_once('php/class/registry.class.php');
//the one and only config
class Config extends _registry
{
	protected static $instance = NULL;
	public static function getInstance()
	{
		if (self::$instance === NULL)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	protected function __construct() {}
	private function __clone() {}
}

$config = Config::getInstance();
$config->title = "F.E.O.";
$config->tags = array("förderverein","eisenbahn","oderbruch","verein");
$config->desc = "Förderverein Pro Eisenbahn im Oderbruch e.V.";
$config->authorName     = "Oliver Jean Eifler";
$config->authorURL      = "http://".$_SERVER["SERVER_NAME"]."/about";
$config->authorMail     = "olli.eifler@gmail.com";
?>