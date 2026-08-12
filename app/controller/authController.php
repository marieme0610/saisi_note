<?php
require_once(dirname(__DIR__)."/model/authModel.php");

function login(){

    if($_SERVER['REQUEST_METHOD']== 'POST'){
        $email = $_POST['email'];
        $mdp = $_POST['password'];  
    // dd($mdp);   

    $result = getInfoUser($email);
    if(!empty($result) && $mdp == $result['mot_de_passe']){
        set_session('userConnect',$result);
    // dd($result);

        // dd("azerty");
        header("Location:http://localhost:8000/saisi/note");
        exit;
    }
    }
    
    require_once(dirname(__DIR__)."/view/login.html.php");
}

function logout(){
    unset_session('userConnect');
    header("Location:http://localhost:8000");
    exit;
}