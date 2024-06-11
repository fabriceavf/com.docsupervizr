<?php

use App\Models\base\RolesModel;
use App\Models\Model_has_rolesModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Options;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, 'model_has_roles', 'model_id');


// le champs role_id
$editor->Fields(Field::inst('role_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
    ->options(Options::inst()->table('roles')->value('id')->label('name'))
//    ->set(false)
// ->get(false)

);
// le champs permission_id
$editor->Fields(Field::inst('role_id as role_label')
    ->getFormatter(function ($data) {
        $roles = RolesModel::find($data);
        return $roles->name;
    })
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs model_type
$editor->Fields(Field::inst('model_type')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
//    ->set(false)
// ->get(false)

);
// le champs model_id
$editor->Fields(Field::inst('model_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->Options(Options::inst()
        ->table('users')
        ->value('id')
        ->label('name')
    )
    ->validator(function ($data, $row) {


        $exist = Model_has_rolesModel::where(['role_id' => $row['role_id'], 'model_id' => $data])->get()->toArray();
//        dd($exist);

        if (count($exist) > 0) {
            $roles = RolesModel::find($row['role_id']);
            $user = App\Models\User::find($data);
            return "Lutilisateur  $user->name $user->prenoms a deje role $roles->name";
        } else {
            return true;
        }


    })
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
