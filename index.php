<?php

require_once('Tekrum/ITekrumPostData');
require_once('Tekrum/TekrumPostData');

use Tekrum\ITecrumPostData;
use Tekrum\TecrumPostData;

if($_POST) {
    $first_name = (isset($_POST['first_name']) && !empty($_POST['first_name']))?:null ;
    $last_name  = (isset($_POST['last_name']) && !empty($_POST['last_name']))?:null;
    $age        = (isset($_POST['age']) && !empty($_POST['age']))?:null;
    $birth_date = (isset($_POST['birth_date']) && !empty($_POST['birth_date']))? new DateTime(['birth_date']):null;

    $db = new \PDO('');
    $tekrumDataInsert = new TecrumPostData($db,$first_name,$last_name,$age,$birth_date);
    if($tekrumDataInsert->insertRecordToDb())
    {
        echo 'Create new User';
    } else {
        echo 'Error';
    }
}
