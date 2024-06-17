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

















    
        use App\Models\User;

    



class OauthClient extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;





public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'creating')
){

try {
\App\Observers\Oauth_clientObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'created')
){

try {
\App\Observers\Oauth_clientObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'updating')
){

try {
\App\Observers\Oauth_clientObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'updated')
){

try {
\App\Observers\Oauth_clientObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'deleting')
){

try {
\App\Observers\Oauth_clientObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\Oauth_clientObservers') &&
method_exists('\App\Observers\Oauth_clientObservers', 'deleted')
){

try {
\App\Observers\Oauth_clientObservers::deleted($model);

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
$this->table = 'oauth_clients';
}
protected $fillable = [
    'id' ,
    'user_id' ,
    'name' ,
    'secret' ,
    'provider' ,
    'redirect' ,
    'personal_access_client' ,
    'password_client' ,
    'revoked' ,
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














    

                    'user',
        



    
    ];







            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    















    


    


    

            public function getNameAttribute($value)
            {
            return $value;
            }
            public function setNameAttribute($value)
            {
            $this->attributes['name'] = $value ?? "";
            }








    


    

            public function getSecretAttribute($value)
            {
            return $value;
            }
            public function setSecretAttribute($value)
            {
            $this->attributes['secret'] = $value ?? "";
            }








    


    

            public function getProviderAttribute($value)
            {
            return $value;
            }
            public function setProviderAttribute($value)
            {
            $this->attributes['provider'] = $value ?? "";
            }








    


    

            public function getRedirectAttribute($value)
            {
            return $value;
            }
            public function setRedirectAttribute($value)
            {
            $this->attributes['redirect'] = $value ?? "";
            }








    


    

            public function getPersonalAccessClientAttribute($value)
            {
            return $value;
            }
            public function setPersonalAccessClientAttribute($value)
            {
            $this->attributes['personal_access_client'] = $value ?? "";
            }








    


    

            public function getPasswordClientAttribute($value)
            {
            return $value;
            }
            public function setPasswordClientAttribute($value)
            {
            $this->attributes['password_client'] = $value ?? "";
            }








    


    

            public function getRevokedAttribute($value)
            {
            return $value;
            }
            public function setRevokedAttribute($value)
            {
            $this->attributes['revoked'] = $value ?? "";
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

