<?php

class RatingController {
    private $isajax;
    public $conn;

    function __construct($conn){
        $this->isajax = $this->_getVar("action") == "ajaxcall";
        $this->conn = $conn;
    }

    function _handleAjaxRequest($conn){ // controller
        $func = _getVar('func');   
        switch ($func){
            case 'setRating':
            $rating = _getVar('rating');

            require_once('models/RatingModel.php');
            $RatingModel = new RatingModel($this->conn);
            $avgRating = $RatingModel->handleRating($rating);

            _echoAverageRating($avgRating);
    }
    }
    // get var from url parameter
    private function _getVar($name, $default='No'){
        return isset($_GET[$name])? $_GET[$name] : $default;
        }


    
    private function _handlePageRequest(){

    }

}
?>