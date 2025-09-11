<?php
// =========================
// style page 
// =========================
function stylePage($cssfile = "\"style.css\""){
    echo "
        <link rel=\"stylesheet\" href=$cssfile/>
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
// form
// =========================
function showForm($fields){
    $test_array = testInputFields($fields);
    $error = $test_array[0];
    $fields = $test_array[1];
    $action = $test_array[2];
    openForm($error, $action);
    showFields($fields); 
    closeForm(); 
}

// test input fields
function testInputFields($fields){
    $error =  "";
    $action = "" ;
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        foreach($fields as $fieldname => $fieldinfo){
          if (empty($_POST[$fieldname])) {
                    $error = "* All fields are required";
                    break;
                } else{
                    $fields[$fieldname]['value'] = $_POST[$fieldname];
                    }
        }
        if (empty($error)){
            $action = 'form_results.php';
        }
    }
    return array($error, $fields, $action);
}

// open form
function openForm($error="", $action){
    echo '<form method="POST" 
            action ='. $action .' >
            <div class="form"> 
            <span class= "error">'. $error.'</span><br>';
}


// show Form
function showFields($fields){
    foreach ($fields as $fieldname => $fieldinfo){
        echo '<label for='.$fieldname.'>'
            .$fieldinfo['label'].' </label>';
        
        switch($fieldinfo['type']){
            case 'textarea':
                echo '<textarea name='.$fieldname.
                        ' rows=4>'. $fieldinfo['value'] .'</textarea><br>';
                break;
            default:
                echo '<input type='.$fieldinfo['type'].
                        ' name='.$fieldname.
                        ' value='.$fieldinfo['value'].'><br>';
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