<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;





















class Programmationsdetail extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'creating')
){

try {
\App\Observers\ProgrammationsdetailObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'created')
){

try {
\App\Observers\ProgrammationsdetailObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'updating')
){

try {
\App\Observers\ProgrammationsdetailObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'updated')
){

try {
\App\Observers\ProgrammationsdetailObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'deleting')
){

try {
\App\Observers\ProgrammationsdetailObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ProgrammationsdetailObservers') &&
method_exists('\App\Observers\ProgrammationsdetailObservers', 'deleted')
){

try {
\App\Observers\ProgrammationsdetailObservers::deleted($model);

} catch (\Throwable $e) {

}
}
});
}

/**
* The primary key associated with the table.
*
* @var string
*/

protected $primaryKey = '';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'programmationsdetails';
}
protected $fillable = [

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',

];





    protected $with = [














    
    ];

















public function getSelectvalueAttribute()
{
    $select="";
    try{
    $select =$this->id;
    }catch (\Throwable $e){

    }
    
    return trim($select);

}
public function getSelectlabelAttribute()
{
    $select="";
    try{
    $select =$this->libelle;
    }catch (\Throwable $e){

    }

    
    return trim($select);



}


protected $appends = [
'Selectvalue','Selectlabel'
];

protected $schemalessAttributes = [
'extra_attributes',
'other_extra_attributes',
];

public function scopeWithExtraAttributes(): Builder
{
return $this->extra_attributes->modelScope();
}

public function scopeWithOtherExtraAttributes(): Builder
{
return $this->other_extra_attributes->modelScope();
}



}

