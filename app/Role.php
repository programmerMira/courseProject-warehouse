<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'permissions',
    ];
    protected $casts = [
        'permissions' => 'array',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }
 
    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }
 
    private function hasPermission(string $permission) : bool
    {
        return $this->permissions[$permission] ?? false;
    }
}
