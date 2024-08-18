<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, AuditableContract {
  use HasApiTokens, HasFactory, Notifiable, HasRoles;
  use Auditable;

  protected $fillable = [
    'name',
    'last_name',
    'second_last_name',
    'email',
    'password',
    'email_verified_at',
    'cellphone',
    'birthday',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getJWTIdentifier() {
    return $this->getKey();
  }

  public function getJWTCustomClaims() {
    return [];
  }

// user has many profiles
  public function profiles() {
    return $this->hasMany(Profile::class);
  }

  public function getOrgsByPermission($permission) {
    $permissions_orgs = [];

    // Loop through each profile
    foreach ($this->profiles as $profile) {
      $orgCode = $profile->organization->short_code;

      // Loop through roles associated with the profile
      foreach ($profile->roles as $role) {
        // Loop through permissions associated with the role
        foreach ($role->permissions as $rolePermission) {
          if ($rolePermission->name === $permission) {
            $permissions_orgs[$profile->org_id] = $orgCode;
          }
        }
      }

      // Loop through direct permissions of the profile
      foreach ($profile->permissions as $profilePermission) {
        if ($profilePermission->name === $permission) {
          $permissions_orgs[$profile->org_id] = $orgCode;
        }
      }
    }

    // Return the organization IDs where the permission is found
    return array_keys($permissions_orgs);
  }
}
