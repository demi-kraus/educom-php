<?php
class PageView{
    $menu;
    // $error_message;

    function __construct($menu, $error_message='' ){
        $this->menu = $menu;
        // $this->error_message = $error_message;
    }

    public function show(){
        $this->beginDoc();
        $this->beginHeader();
        $this->headerContent();
        $this->endHeader();
        $this->showMenu($this->menu)
        $this->beginBody();
        $this->bodyContent();
        $this->endBody();
        $this->endDoc();
    }

    function beginDoc() { 
        $cssfile = '"css/style.css"';
        echo "<head>
            <link rel=\"stylesheet\" href= $cssfile/>
        </head>";
    }

    function beginHeader() { 
        echo '<header>';
    }
    function headerContent($title = 'WELCOME!') { 
        echo $title;
    }
    
   function showMenu($menu){
    echo "<ul class=\"menu\"> ";
    foreach ($menu as $item => $link){
        // $item = strtoupper($item);
       echo "<li> <a href= \"".$link."\">". $item . "</a> </li>";
    }
    echo "</ul>";
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
    function endDoc(){ }


}
?>