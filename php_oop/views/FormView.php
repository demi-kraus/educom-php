<?php
require_once('PageView.php');
class FormView extends PageView{
    $form_info;

    private function __construct($form_info){
        $this->form_info;
    }

    public bodyContent(){
        showForm($this->form_info);
    }
    
    private function showForm($form_info){
        $page = $form_info['page'];
        $fields = $form_info['fields'];
        $this->openForm($page);
        $this->showFields($fields); 
        $this->closeForm(); 
    }

    // open form
    private function openForm($page){
        echo '<form method="POST" action = "index.php" >
                <div class="form">
                <input type="hidden" name = "page" value="'.$page.'" />';
    }

    // show Form
    private function showFields($fields){
        foreach ($fields as $fieldname => $fieldinfo){
            echo '<label for='.$fieldname.'>'
                .$fieldinfo['label'].' </label>';
            
            switch($fieldinfo['type']){
                case 'textarea':
                    echo '<textarea name='.$fieldname.
                            ' rows=4 required>'. $fieldinfo['value'] .'</textarea><br><br>';
                    break;
                default:
                    echo '<input type='.$fieldinfo['type'].
                            ' name='.$fieldname.
                            ' value= "'.$fieldinfo['value'].'" required ><br><br>';
            }
        }
    }

    //close form
    private function closeForm(){
        echo '<input type="submit" value="submit">
                </div>
                </form>';
    }
}
?>