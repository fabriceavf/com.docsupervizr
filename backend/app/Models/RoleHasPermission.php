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


use App\Models\Permission;


use App\Models\Role;


class RoleHasPermission extends Model
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
        'permission_id',
        'role_id',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'canCreate',
        'canUpdate',
        'canDelete',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'permission',


        'role',


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
        $this->table = 'role_has_permissions';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'creating')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'created')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'updating')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'updated')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'deleting')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\Role_has_permissionObservers') &&
                method_exists('\App\Observers\Role_has_permissionObservers', 'deleted')
            ) {

                try {
                    \App\Observers\Role_has_permissionObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function getPermissionIdAttribute($value)
    {
        return $value;
    }

    public function setPermissionIdAttribute($value)
    {
        $this->attributes['permission_id'] = $value ?? "";
    }

    public function getRoleIdAttribute($value)
    {
        return $value;
    }

    public function setRoleIdAttribute($value)
    {
        $this->attributes['role_id'] = $value ?? "";
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

    public function getCanCreateAttribute($value)
    {
        return $value;
    }

    public function setCanCreateAttribute($value)
    {
        $this->attributes['canCreate'] = $value ?? "";
    }

    public function getCanUpdateAttribute($value)
    {
        return $value;
    }

    public function setCanUpdateAttribute($value)
    {
        $this->attributes['canUpdate'] = $value ?? "";
    }

    public function getCanDeleteAttribute($value)
    {
        return $value;
    }

    public function setCanDeleteAttribute($value)
    {
        $this->attributes['canDelete'] = $value ?? "";
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

