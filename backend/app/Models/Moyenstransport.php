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


use App\Models\Typesmoyenstransport;


use App\Models\Deplacement;


use App\Models\Deploiementspointeusesmoyenstransport;


use App\Models\Lignesmoyenstransport;


use App\Models\Tracking;


class Moyenstransport extends Model
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
        'typesmoyenstransport_id',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'typesmoyenstransport',


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
        $this->table = 'moyenstransports';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'creating')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'created')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'updating')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'updated')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'deleting')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\MoyenstransportObservers') &&
                method_exists('\App\Observers\MoyenstransportObservers', 'deleted')
            ) {

                try {
                    \App\Observers\MoyenstransportObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function typesmoyenstransport()
    {
        return $this->belongsTo(Typesmoyenstransport::class, 'typesmoyenstransport_id', 'id');
    }

    public function deplacements()
    {
        return $this->hasMany(Deplacement::class, 'moyenstransport_id', 'id');
    }

    public function deploiementspointeusesmoyenstransports()
    {
        return $this->hasMany(Deploiementspointeusesmoyenstransport::class, 'moyenstransport_id', 'id');
    }

    public function lignesmoyenstransports()
    {
        return $this->hasMany(Lignesmoyenstransport::class, 'moyenstransport_id', 'id');
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class, 'moyenstransport_id', 'id');
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

    public function getTypesmoyenstransportIdAttribute($value)
    {
        return $value;
    }

    public function setTypesmoyenstransportIdAttribute($value)
    {
        $this->attributes['typesmoyenstransport_id'] = $value ?? "";
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

