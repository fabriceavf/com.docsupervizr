<?php

use Carbon\Carbon;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Upload;
use DataTables\GetDb;

$db = GetDb::getDatabase();
$editor = Editor::inst($db, '001_contenu', 'id_contenu');
$current_timestamp = Carbon::now()->timestamp;

// le champs miniatures
$editor->Fields(Field::inst('value')
    ->upload(Upload::inst(public_path() . '/upload/' . $current_timestamp . '____ID__.__EXTN__')
        ->db('files', 'id', array(
            'old_name' => Upload::DB_FILE_NAME,
            'new_name' => Upload::DB_FILE_NAME,
            'descriptions' => 'Bref descriptions',
            'extensions' => Upload::DB_EXTN,
            'size' => Upload::DB_FILE_SIZE,
            'path' => Upload::DB_SYSTEM_PATH,
            'web_path' => Upload::DB_WEB_PATH,
            'created_at' => now(),
            'updated_at' => now(),
        ))
    )
    ->set(false)

//    ->get(false)

);

$editor->process($editorData);
$resultat1 = $editor->data();
$reponse = [];
//dd($resultat1);
if (!empty($resultat1['files']['files'][$resultat1['upload']['id']]['web_path'])) {
    $reponse = $resultat1['files']['files'][$resultat1['upload']['id']]['web_path'];
    $reponse = str_replace('\\', '', $reponse);
    $reponse = ['url' => URL::to($reponse)];

}
//dd($reponse);
echo json_encode($reponse);
