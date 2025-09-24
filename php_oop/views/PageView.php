<?php
class PageView{
    protected $menu;
    // $error_message;

    function __construct($menu='', $error_message='' ){
        $this->menu = $menu;
        // $this->error_message = $error_message;
    }

    public function show(){
        $this->beginDoc();
        $this->beginHeader();
        $this->headerContent();
        $this->endHeader();
        if (!empty($this->menu)){
            require_once('MenuView.php');
            $menuView = new MenuView($this->menu);
            $menuView->showMenu();}
        $this->beginBody();
        $this->bodyContent();
        $this->endBody();
        $this->beginFooter();
        $this->footerContent();
        $this->endFooter();
        $this->endDoc();
    }

    function beginDoc() { 
        echo "<!DOCTYPE html>\n<html>";
        $cssfile = '"css/style.css"';
        echo "<head>
            <link rel=\"stylesheet\" href= $cssfile/>
        </head>";
    }

    function beginHeader() { 
        echo '<header>';
    }
    function headerContent($title = 'WELCOME!') { 
        echo '<h1>'.$title.'</h1>';
    }
    
    function endHeader(){
        echo '</header>';
    }

    
    function beginBody() {
        echo '<body>';
      }
    function bodyContent(){}

    function endBody() { 
        echo '</body>';
     }

    function beginFooter(){
        echo '<footer>';
    }

    function footerContent(){
        echo '&copy 2010-'.date('Y');
    }

    function endFooter(){
        echo '</footer>';
    }
    function endDoc(){
        echo '</html>';
     }


}
?>