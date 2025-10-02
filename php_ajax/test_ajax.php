<?php
// set up Database
$servername = "localhost"; 
$username = "root";
$password = "TrinaDePipa";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

$isajax = _getVar("action") =="ajaxcall";

// handle request
if ($isajax){
  _handleAjaxRequest($conn);
} else {
  _handlePageRequest();
}

function _handleAjaxRequest($conn){
  $func = _getVar('func');
  switch ($func){
    case 'setRating':
      $user_id = _getVar('user_id');
      $item_id = _getVar('item_id');
      $rating = _getVar('rating');


      saveRating($conn, $rating, $item_id, $user_id);
      $avgRating = getAverageRating($conn, $item_id);
      _echoAverageRating($avgRating);
  }
}

function _handlePageRequest(){
  echo '<html lang="en">
          <head>   
            <link rel="stylesheet" href="css/style.css"/>
            <script src="js/jquery.js"></script>
            <script src = "js/rating.js"> </script>
          </head>

          <body>
            
            <span class="star" data-value="1">&#9733;</span>
            <span class="star" data-value="2">&#9733;</span>
            <span class="star" data-value="3">&#9733;</span>
            <span class="star" data-value="4">&#9733;</span>
            <span class="star" data-value="5">&#9733;</span>
            <span id="avgRating"></span>
          </body>
        </html>';

}

function _getVar($name, $default='No'){
  return isset($_GET[$name])? $_GET[$name] : $default;
}

function _echoAverageRating($avgRating){
  
  $data = array('target' => '#avgRating', 'content' => $avgRating);
  echo json_encode($data);
}

function getAverageRating($conn, $item_id){
    $sql = 'SELECT AVG(rating) FROM ratings WHERE product_id='.$item_id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    return $row['AVG(rating)'];
}

function saveRating($conn, $rating, $item_id, $user_id){
    $sql = 'SELECT * FROM ratings 
                WHERE product_id='.$item_id.' AND user_id='.$user_id ;
    $result = $conn->query($sql);
    // if not found add rating to table
    if ($result->num_rows==0){
        $sql = 'INSERT INTO ratings (product_id, rating, user_id) VALUES ('.$item_id.', '.$rating.', '.$user_id.')';
        // echo 'rating is saved';
    } else {
        $sql = 'UPDATE ratings SET rating='.$rating.' WHERE product_id='.$item_id.' AND user_id='.$user_id ;
        // echo 'rating is updated';
    }
    $conn->query($sql);
}

?>

