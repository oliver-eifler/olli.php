<?php

namespace Faker\Provider\olli;

class Text extends \Faker\Provider\Text
{
    protected static $baseText = '';
    public function realTextInit($file)
    {
        self::$baseText = file_get_contents($file);
    }
}
?>