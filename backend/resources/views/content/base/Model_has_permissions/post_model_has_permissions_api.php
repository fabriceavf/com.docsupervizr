<?php

use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, '001_model_has_permissions', 'model_id');

$tables = Arr::pluck(DB::select("SHOW FULL COLUMNS FROM 001_model_has_permissions"), 'Field');

if (!empty($editorData) && count($editorData) >= 1) {
    $editor->where(function ($q) use ($editorData, $tables) {

        foreach ($editorData as $key => $data) {

            if (in_array($key, $tables)) {
                $q->where($key, $data);

            }

        }

    });

}

// le champs permission_id
$editor->Fields(Field::inst('permission_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs model_type
$editor->Fields(Field::inst('model_type')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->set(false)
// ->get(false)

);
// le champs model_id
$editor->Fields(Field::inst('model_id')
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
