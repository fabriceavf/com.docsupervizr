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


class File extends Model
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
        'old_name',
        'new_name',
        'descriptions',
        'extensions',
        'size',
        'path',
        'web_path',
        'statut',
        'extra_attributes',
        'created_at',
        'updated_at',
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
        $this->table = 'files';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'creating')
            ) {

                try {
                    \App\Observers\FileObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'created')
            ) {

                try {
                    \App\Observers\FileObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'updating')
            ) {

                try {
                    \App\Observers\FileObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'updated')
            ) {

                try {
                    \App\Observers\FileObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'deleting')
            ) {

                try {
                    \App\Observers\FileObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\FileObservers') &&
                method_exists('\App\Observers\FileObservers', 'deleted')
            ) {

                try {
                    \App\Observers\FileObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function getOldNameAttribute($value)
    {
        return $value;
    }

    public function setOldNameAttribute($value)
    {
        $this->attributes['old_name'] = $value ?? "";
    }

    public function getNewNameAttribute($value)
    {
        return $value;
    }

    public function setNewNameAttribute($value)
    {
        $this->attributes['new_name'] = $value ?? "";
    }

    public function getDescriptionsAttribute($value)
    {
        return $value;
    }

    public function setDescriptionsAttribute($value)
    {
        $this->attributes['descriptions'] = $value ?? "";
    }

    public function getExtensionsAttribute($value)
    {
        return $value;
    }

    public function setExtensionsAttribute($value)
    {
        $this->attributes['extensions'] = $value ?? "";
    }

    public function getSizeAttribute($value)
    {
        return $value;
    }

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = $value ?? "";
    }

    public function getPathAttribute($value)
    {
        return $value;
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = $value ?? "";
    }

    public function getWebPathAttribute($value)
    {
        return $value;
    }

    public function setWebPathAttribute($value)
    {
        $this->attributes['web_path'] = $value ?? "";
    }

    public function getStatutAttribute($value)
    {
        return $value;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
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


        $select .= "" . $this->id . " ";


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

