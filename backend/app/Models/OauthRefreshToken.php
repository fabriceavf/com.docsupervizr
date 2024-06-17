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





















class OauthRefreshToken extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;





public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'creating')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'created')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'updating')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'updated')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'deleting')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\Oauth_refresh_tokenObservers') &&
method_exists('\App\Observers\Oauth_refresh_tokenObservers', 'deleted')
){

try {
\App\Observers\Oauth_refresh_tokenObservers::deleted($model);

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
$this->table = 'oauth_refresh_tokens';
}
protected $fillable = [
    'id' ,
    'access_token_id' ,
    'revoked' ,
    'expires_at' ,
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
















    


    

            public function getAccessTokenIdAttribute($value)
            {
            return $value;
            }
            public function setAccessTokenIdAttribute($value)
            {
            $this->attributes['access_token_id'] = $value ?? "";
            }








    


    

            public function getRevokedAttribute($value)
            {
            return $value;
            }
            public function setRevokedAttribute($value)
            {
            $this->attributes['revoked'] = $value ?? "";
            }








    


    

            public function getExpiresAtAttribute($value)
            {
            return $value;
            }
            public function setExpiresAtAttribute($value)
            {
            $this->attributes['expires_at'] = $value ?? "";
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

