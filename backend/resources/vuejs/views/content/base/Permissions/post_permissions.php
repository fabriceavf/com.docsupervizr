<?php

use Carbon\Carbon;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, 'permissions', 'id');


// le champs id
$editor->Fields(Field::inst('id')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs name
$editor->Fields(Field::inst('name')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->validator(Validate::unique(ValidateOptions::inst()->message('Cette permission existe deja')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs guard_name
$editor->Fields(Field::inst('guard_name')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs created_at
$editor->Fields(Field::inst('created_at')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs updated_at
$editor->Fields(Field::inst('updated_at')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
//evenement preCreate
$editor->on('preCreate', function (Editor $editor, $valeur) {
    $date = Carbon::now();
    $editor->field('created_at')
        ->setValue($date);
    $editor->field('guard_name')
        ->setValue('web');
    $editor->field('updated_at')
        ->setValue($date);
});
//evenement preEdit
$editor->on('preEdit', function (Editor $editor, $valeur) {
    $date = Carbon::now();
    $editor->field('updated_at')
        ->setValue($date);

});
//evenement preRemove
$editor->on('preRemove', function (Editor $editor, $valeur) {

});
//evenement postCreate
$editor->on('postCreate', function (Editor $editor, $id, $value, $data) {


});
//evenement postEdit
$editor->on('postEdit', function (Editor $editor, $valeur) {

});
//evenement postRemove
$editor->on('postRemove', function (Editor $editor, $valeur) {

});
//evenement writeCreate
$editor->on('writeCreate', function (Editor $editor, $id, $values) {
    //    echo'on rentre dans la write create';

});


$editor->process($editorData);
$resultat1 = $editor->json(false);
$editor->json();
