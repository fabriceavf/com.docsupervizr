<?php

use App\Models\base\PermissionsModel;
use App\Models\base\RolesModel;
use App\Models\Role_has_permissionsModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Options;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, 'role_has_permissions', 'permission_id');
//dd($roles_id);

if (!empty($roles_id)) {
    $editor->where('role_id', $roles_id);

} else {
    die();
}


// le champs permission_id
$editor->Fields(Field::inst('permission_id')
    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->validator(function ($data) use ($roles_id) {


        $roles = RolesModel::find($roles_id);
        $permi = PermissionsModel::find($data);


        $permissions = Role_has_permissionsModel::where(['role_id' => $roles_id, 'permission_id' => $data])->get()->toArray();
//        dd($roles_id,$data,$permissions);
        if (count($permissions) > 0) {
            return "Le role $roles->name a deja la permission $permi->name";

        } else {
            return true;
        }


    })
    ->options(Options::inst()
        ->table('permissions')
        ->value('id')
        ->label('name')
    )
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
//    ->set(false)
// ->get(false)

);
// le champs role_id
$editor->Fields(Field::inst('role_id')
//    ->validator(Validate::required(ValidateOptions::inst()->message('Ce champs est requis')))
    ->xss(true)
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
//evenement preCreate
$editor->on('preCreate', function (Editor $editor, $valeur) use ($roles_id) {
    $editor->field('role_id')
        ->setValue($roles_id);
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
//$resultat1 = $editor->json(false);
$editor->json();
