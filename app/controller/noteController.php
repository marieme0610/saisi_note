<?php
require_once(dirname(__DIR__)."/model/noteModel.php");

function ShowSaisi(){
    $classes = getAllTables('classes');
    $periodes = getAllTables('periodes');
    $matieres = getAllTables('matieres');
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $id_classe = (int)$_POST['classe'];
        $id_matiere =(int) $_POST['matiere'];
        $id_periode = (int)$_POST['periode'];
        var_dump($id_classe);
        var_dump($id_matiere);
        var_dump($id_periode);
        $moyenne = getMoyenne($id_classe, $id_matiere, $id_periode );
        var_dump($moyenne);
    $notes = getNotesClasse( $id_classe,  $id_matiere,  $id_periode);
 var_dump($notes);
        
    }
    // dd($notes);

    
    require_once(dirname(__DIR__)."/view/saisiNote.html.php");
}