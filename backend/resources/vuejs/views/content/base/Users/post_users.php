<?php


use App\Models\User;
use Carbon\Carbon;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Format;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;

$db = GetDb::getDatabase();

$editor = Editor::inst($db, 'users', 'id');


// le champs id
$editor->Fields(Field::inst('id')
    ->set(false)
//    ->get(false)


);
// le champs id
$editor->Fields(Field::inst('id as permissions')
    ->getFormatter(function ($data) {
        $users = User::where(['id' => $data])->get();

        if (count($users->toArray()) == 1) {
            return Arr::pluck($users[0]->getAllPermissions()->toArray(), 'name');
        } else {
            return $data;

        }
    })
    ->set(false)


);


// le champs noms
$editor->Fields(Field::inst('name')
    //    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);
// le champs prenoms
$editor->Fields(Field::inst('prenoms')
    //    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))


);


// le champs email
$editor->Fields(Field::inst('email')
    //    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))
//            ->validator(Validate::unique(ValidateOptions::inst()->message("Cet email est deja utiliser")))
    ->validator(function ($data) {
        $users = User::where('email', $data)->get()->toArray();
        if (empty($users)) {
            return true;
        } else {
            return "Un utilisateur utilise deja cet email";
        }
    })


);
// le champs email
$editor->Fields(Field::inst('email_interne')

//    ->set(false)
//    ->get(false)

//    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
//    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))

//  ->validator(Validate::unique(ValidateOptions::inst()->message("Cet email_interne est deja utiliser")))

//    ->validator(function ($data) {
//        $users = \App\Models\User::where('email_interne', $data)->get()->toArray();
//        if (empty($users)) {
//            return true;
//        } else {
//            return "Un utilisateur utilise deja cet email_interne";
//        }
//    })


);
// le champs password
$editor->Fields(Field::inst('password as password')
    //    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))
    ->setFormatter(Format::pass())


);

// le champs contact
$editor->Fields(Field::inst('contact as contact')
    //    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))
    ->setFormatter(Format::pass())


);


// le champs password
$editor->Fields(Field::inst('password as password_confirm')
    ->set(false)
    //    ->get(false)
    ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
    ->validator(Validate::maxLen(255, ValidateOptions::inst()->message("Pas plus de 255 charactere")))
    ->validator(function ($data, $row) {
        if ($row['password'] != $data) {
            return "Les mots de passe ne concorde pas";

        } else {
            return true;
        }
    })


);


// le champs created_at
$editor->Fields(Field::inst('created_at')
    ->set(Field::SET_CREATE)
    ->setValue(Carbon::now())
    ->getFormatter(function ($data) {
        $date = new Carbon($data);
        return $date->diffForHumans();
    })

//    ->get(false)
);
// le champs updated_at
$editor->Fields(Field::inst('updated_at')
    ->setValue(Carbon::now())
    ->getFormatter(function ($data) {
        $date = new Carbon($data);
        return $date->diffForHumans();
    })
    ->set(false)
//    ->get(false)

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

});
//evenement preRemove
$editor->on('preRemove', function ($editor, $valeur) {

});
//evenement postCreate
$editor->on('postCreate', function ($editor, $id, $valeur_base, $valeur_sortie) {
    $date = Carbon::now();

    $users = User::find($valeur_sortie['id']);


});
//evenement postEdit
$editor->on('postEdit', function ($editor, $valeur) {

});
//evenement postRemove
$editor->on('postRemove', function ($editor, $valeur) {

});


$editor->process($editorData);
$resultat1 = $editor->json(false);


$editor->json();

