<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;


class Controlleursaxe extends Model
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
        'pointeuse_id',
        'ligne_id',
        'moyenstransport_id',
        'site_id',
        'date_debut',
        'date_fin',
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


        'ligne',


        'moyenstransport',


        'pointeuse',


        'site',


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
        $this->table = 'controlleursaxes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'creating')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'created')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'updating')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'updated')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ControlleursaxeObservers') &&
                method_exists('\App\Observers\ControlleursaxeObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ControlleursaxeObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function ligne()
    {
        return $this->belongsTo(Ligne::class, 'ligne_id', 'id');
    }

    public function moyenstransport()
    {
        return $this->belongsTo(Moyenstransport::class, 'moyenstransport_id', 'id');
    }

    public function pointeuse()
    {
        return $this->belongsTo(Pointeuse::class, 'pointeuse_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'controlleursaxe_id', 'id');
    }

    public function getPointeuseIdAttribute($value)
    {
        return $value;
    }

    public function setPointeuseIdAttribute($value)
    {
        $this->attributes['pointeuse_id'] = $value ?? "";
    }

    public function getLigneIdAttribute($value)
    {
        return $value;
    }

    public function setLigneIdAttribute($value)
    {
        $this->attributes['ligne_id'] = $value ?? "";
    }

    public function getMoyenstransportIdAttribute($value)
    {
        return $value;
    }

    public function setMoyenstransportIdAttribute($value)
    {
        $this->attributes['moyenstransport_id'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getDateDebutAttribute($value)
    {
        return $value;
    }

    public function setDateDebutAttribute($value)
    {
        $this->attributes['date_debut'] = $value ?? "";
    }

    public function getDateFinAttribute($value)
    {
        return $value;
    }

    public function setDateFinAttribute($value)
    {
        $this->attributes['date_fin'] = $value ?? "";
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

