<?php

use Carbon\Carbon;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();

$editor = Editor::inst($db, 'contenu');


// le champs id
$editor->Fields(Field::inst('id')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs libelle
$editor->Fields(Field::inst('libelle')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs types
$editor->Fields(Field::inst('types')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs text
$editor->Fields(Field::inst('text')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs files
$editor->Fields(Field::inst('files')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs textarea
$editor->Fields(Field::inst('textarea')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs datetime
$editor->Fields(Field::inst('datetime')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs extra_attributes
$editor->Fields(Field::inst('extra_attributes')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs deleted_at
$editor->Fields(Field::inst('deleted_at')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs created_at
$editor->Fields(Field::inst('created_at')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs updated_at
$editor->Fields(Field::inst('updated_at')
    //    ->set(false)
    //        ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);


//evenement preCreate
$editor->on('preCreate', function ($editor, $valeur) {
    $date = Carbon::now();

    $editor->field('created_at')
        ->setValue($date);
    $editor->field('updated_at')
        ->setValue($date);

});
//evenement preEdit
$editor->on('preEdit', function ($editor, $valeur) {
    $date = Carbon::now();
    $editor->field('updated_at')
        ->setValue($date);

});
//evenement preRemove
$editor->on('preRemove', function ($editor, $valeur) {


});
//evenement postCreate
$editor->on('postCreate', function ($editor, $id, $valeur_base, $valeur_sortie) {


});
//evenement postEdit
$editor->on('postEdit', function ($editor, $valeur) {

});
//evenement postRemove
$editor->on('postRemove', function ($editor, $valeur) {

});


$editor->process($editorData);
$editor->json();



