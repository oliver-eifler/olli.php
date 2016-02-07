<?php
require_once('php/class/basepage.class.php');
class DynamicPage extends BasePage
{
    protected function init()
    {
        $this->dynamic = true;
        $this->title = "PHP Test Page";
        $this->error = !$this->LoadPage();
    }
    protected function LoadPage()
    {
        $this->html.="<p>Eine Dynamische PHP Test Seite</p>";
        return true;
    }
}
?>
