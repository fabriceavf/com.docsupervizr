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





















class WebsocketsStatisticsEntrie extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'creating')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'created')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'updating')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'updated')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'deleting')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\Websockets_statistics_entrieObservers') &&
method_exists('\App\Observers\Websockets_statistics_entrieObservers', 'deleted')
){

try {
\App\Observers\Websockets_statistics_entrieObservers::deleted($model);

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

protected $primaryKey = 'id';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'websockets_statistics_entries';
}
protected $fillable = [
    'id' ,
    'app_id' ,
    'peak_connection_count' ,
    'websocket_message_count' ,
    'api_message_count' ,
    'created_at' ,
    'updated_at' ,
    'extra_attributes' ,
    'deleted_at' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    
    ];
















    


    

            public function getAppIdAttribute($value)
            {
            return $value;
            }
            public function setAppIdAttribute($value)
            {
            $this->attributes['app_id'] = $value ?? "";
            }








    


    

            public function getPeakConnectionCountAttribute($value)
            {
            return $value;
            }
            public function setPeakConnectionCountAttribute($value)
            {
            $this->attributes['peak_connection_count'] = $value ?? "";
            }








    


    

            public function getWebsocketMessageCountAttribute($value)
            {
            return $value;
            }
            public function setWebsocketMessageCountAttribute($value)
            {
            $this->attributes['websocket_message_count'] = $value ?? "";
            }








    


    

            public function getApiMessageCountAttribute($value)
            {
            return $value;
            }
            public function setApiMessageCountAttribute($value)
            {
            $this->attributes['api_message_count'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getIdentifiantsSadgeAttribute($value)
            {
            return $value;
            }
            public function setIdentifiantsSadgeAttribute($value)
            {
            $this->attributes['identifiants_sadge'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    



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

