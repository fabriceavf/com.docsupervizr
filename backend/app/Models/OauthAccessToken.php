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


use App\Models\Client;


use App\Models\User;


class OauthAccessToken extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'name',
        'scopes',
        'revoked',
        'created_at',
        'updated_at',
        'expires_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'client',


        'user',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'oauth_access_tokens';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'creating')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'created')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'updating')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'updated')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'deleting')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\Oauth_access_tokenObservers') &&
                method_exists('\App\Observers\Oauth_access_tokenObservers', 'deleted')
            ) {

                try {
                    \App\Observers\Oauth_access_tokenObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?? "";
    }

    public function getScopesAttribute($value)
    {
        return $value;
    }

    public function setScopesAttribute($value)
    {
        $this->attributes['scopes'] = $value ?? "";
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
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";
        try {
            $select = $this->libelle;
        } catch (\Throwable $e) {

        }


        return trim($select);


    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }


}

