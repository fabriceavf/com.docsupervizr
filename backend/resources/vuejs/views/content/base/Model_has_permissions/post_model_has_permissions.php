<?php

use App\Models\base\PermissionsModel;
use App\Models\Model_has_permissionsModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Options;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;


$db = GetDb::getDatabase();
$editor = Editor::inst($db, 'model_has_permissions', 'model_id');


// le champs permission_id
$editor->Fields(Field::inst('permission_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->Options(Options::inst()
        ->table('permissions')
        ->value('id')
        ->label('name')
    )
    ->validator(function ($data, $row) {


        $exist = Model_has_permissionsModel::where(['permission_id' => $data, 'model_id' => $row['model_id']])->get()->toArray();
//        dd($exist);

        if (count($exist) > 0) {
            $permi = PermissionsModel::find($data);
            $user = App\Models\User::find($row['model_id']);
            return "Lutilisateur  $user->name $user->prenoms a deja la permission $permi->name";
        } else {
            return true;
        }


    })
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs permission_id
$editor->Fields(Field::inst('permission_id as permission_label')
    ->getFormatter(function ($data) {
        $permissions = PermissionsModel::find($data);
        return $permissions->name;
    })
    ->xss(true)
////    ->set(false)
// ->get(false)

);
// le champs model_type
$editor->Fields(Field::inst('model_type')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
    ->get(false)

);
// le champs model_id
$editor->Fields(Field::inst('model_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->Options(Options::inst()
        ->table('users')
        ->value('id')
        ->label('name')
    )
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs model_id
$editor->Fields(Field::inst('model_id as user_name')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->getFormatter(function ($data) {
        $user = App\Models\User::find($data);


        if (!empty($user)) {
            return $user->name . ' ' . $user->prenoms;
        } else {
            return $data;
        }
    })
    ->xss(true)
//    ->set(false)
// ->get(false)

);
//evenement preCreate
$editor->on('preCreate', function (Editor $editor, $valeur) {
    $editor->field('model_type')->setValue('App\Models\User');
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
