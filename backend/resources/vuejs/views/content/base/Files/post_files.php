<?php

use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, '001_files', 'id_files');


// le champs id_files
$editor->Fields(Field::inst('id_files')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs old_name
$editor->Fields(Field::inst('old_name')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs new_name
$editor->Fields(Field::inst('new_name')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs descriptions
$editor->Fields(Field::inst('descriptions')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs extensions
$editor->Fields(Field::inst('extensions')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs size
$editor->Fields(Field::inst('size')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs path
$editor->Fields(Field::inst('path')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs web_path
$editor->Fields(Field::inst('web_path')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs created_at
$editor->Fields(Field::inst('created_at')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs updated_at
$editor->Fields(Field::inst('updated_at')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
//evenement preCreate
$editor->on('preCreate', function (Editor $editor, $valeur) {
});
//evenement preEdit
$editor->on('preEdit', function (Editor $editor, $valeur) {
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
