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


use App\Models\Badge;


use App\Models\Contratsclient;


use App\Models\Intervention;


use App\Models\Listing;


use App\Models\OauthAccessToken;


use App\Models\OauthAuthCode;


use App\Models\OauthPersonalAccessClient;


use App\Models\Rapport;


use App\Models\Site;


use App\Models\Transaction;


class Client extends Model
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
        'code',
        'libelle',
        'created_at',
        'updated_at',
        'type',
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
        $this->table = 'clients';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'creating')
            ) {

                try {
                    \App\Observers\ClientObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'created')
            ) {

                try {
                    \App\Observers\ClientObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'updating')
            ) {

                try {
                    \App\Observers\ClientObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'updated')
            ) {

                try {
                    \App\Observers\ClientObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ClientObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ClientObservers') &&
                method_exists('\App\Observers\ClientObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ClientObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function badges()
    {
        return $this->hasMany(Badge::class, 'client_id', 'id');
    }

    public function contratsclients()
    {
        return $this->hasMany(Contratsclient::class, 'client_id', 'id');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'client_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'client_id', 'id');
    }

    public function oauth_access_tokens()
    {
        return $this->hasMany(OauthAccessToken::class, 'client_id', 'id');
    }

    public function oauth_auth_codes()
    {
        return $this->hasMany(OauthAuthCode::class, 'client_id', 'id');
    }

    public function oauth_personal_access_clients()
    {
        return $this->hasMany(OauthPersonalAccessClient::class, 'client_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'client_id', 'id');
    }

    public function sites()
    {
        return $this->hasMany(Site::class, 'client_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'client_id', 'id');
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
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


        $select = " " . $this->id;


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

