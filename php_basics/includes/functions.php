<?php
// =========================
// style page 
// =========================
function stylePage($cssfile = '"css/style.css"'){
    echo "<head>
        <link rel=\"stylesheet\" href= $cssfile/>
    </head>";
}

// =========================
// show header
// =========================
function showHeader($title){

    echo "<header> 
            <h1> $title <h1>
          </header>";
}

// =========================
// show menu
// =========================
function showMenu($menu){
    echo "<ul class=\"menu\"> ";
    foreach ($menu as $item => $link){
       echo "<li> <a href= \"".$link."\">". $item . "</a> </li>";
    }
    echo "</ul>";
}

// =========================
// Test POST for login
// =========================



// =========================
// form
// =========================
function showForm($form_info){
    $page = $form_info['page'];
    $fields = $form_info['fields'];
    openForm($page);
    showFields($fields); 
    closeForm(); 
}

// test input fields
function testInputFields($fields){
    $error =  "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        foreach($fields as $fieldname => $fieldinfo){
          if (empty($_POST[$fieldname])) {
                    $error = "* All fields are required";
                    break;
            } 
            else{
                    $fields[$fieldname]['value'] = $_POST[$fieldname];
            }
        }   
    }
    return array($error, $fields);
}

// open form
function openForm($page){
    echo '<form method="POST" action = "index.php" >
            <div class="form">
            <input type="hidden" name = "page" value="'.$page.'" />';
            // <span class= "error">'. $error.'</span><br>';
}

// show Form
function showFields($fields){
    foreach ($fields as $fieldname => $fieldinfo){
        echo '<label for='.$fieldname.'>'
            .$fieldinfo['label'].' </label>';
        
        switch($fieldinfo['type']){
            case 'textarea':
                echo '<textarea name='.$fieldname.
                        ' rows=4 required>'. $fieldinfo['value'] .'</textarea><br>';
                break;
            default:
                echo '<input type='.$fieldinfo['type'].
                        ' name='.$fieldname.
                        ' value= "'.$fieldinfo['value'].'" required ><br>';
        }
    }
}

//close form
function closeForm(){
    echo '</div>
            <input type="submit" value="submit">
            </form>';
}

// =========================
// show footer
// =========================
function showFooter(){
    echo "<footer> &copy 2010-".date('Y')."</footer>";
   
}

?>