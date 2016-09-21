<?php

class HelperComponent extends CComponent{

    public function init() {
        //init
    }
    public function generateRandomString() {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        $length = strlen($characters) - 1;
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $length)];
        }
        return $randomString;
    }

    public function renderMessage(){
        $messgage = Yii::app()->user->getFlash('message');
        if(!empty($messgage)){
            if(is_array($messgage)){
                foreach($messgage as $title){
                    echo '<div class="alert alert-success">' . $title . '</div>';
                }
            }
            else{
                echo '<div class="alert alert-success">' . $messgage . '</div>';
            }
        }
    }
    
    public function renderErrorMessage(){
        $messgage = Yii::app()->user->getFlash('errorMessage');
        if(!empty($messgage)){
            if(is_array($messgage)){
                foreach($messgage as $title){
                    echo '<div class="alert alert-danger">' . $title . '</div>';
                }
            }
            else{
                echo '<div class="alert alert-danger">' . $messgage . '</div>';
            }
        }
    }
}
?>