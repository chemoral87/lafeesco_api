<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request) {

//     $profilesRolesPermissions = [];

//     foreach ($this->profiles as $profile) {
//       foreach ($profile->roles as $role) {
//         foreach ($role->permissions as $permission) {
//           $profilesRolesPermissions[] = [
//             'org_id' => $profile->org_id,
//             'org_code' => $profile->organization->short_code,
//             'role_name' => $role->name,
//             'permission_name' => $permission->name,
//           ];
//         }
//       }
//       foreach ($profile->permissions as $permission) {
//         $profilesRolesPermissions[] = [
//           'org_id' => $profile->org_id,
//           'org_code' => $profile->organization->short_code,
//           'role_name' => null,
//           'permission_name' => $permission->name,
//         ];
//       }
//     }

//     // get 'permission_name' : [org_id1, org_id2, ...]
//     $permissions_orgs = [];
//     foreach ($profilesRolesPermissions as $profileRolePermission) {
//       if (!array_key_exists($profileRolePermission['permission_name'], $permissions_orgs)) {
//         $permissions_orgs[$profileRolePermission['permission_name']] = [];
//       }
// //prevent agro-event-delete [4, 4, 5]
//       if (!in_array($profileRolePermission['org_id'], $permissions_orgs[$profileRolePermission['permission_name']])) {
//         $permissions_orgs[$profileRolePermission['permission_name']][] = $profileRolePermission['org_id'];
//       }

//     }

    $permissions_orgs = [];
    $profilesRolesPermissions = [];

    // Loop through each profile
    foreach ($this->profiles as $profile) {
      // Get organization short code
      $orgCode = $profile->organization->short_code;

      // Loop through roles associated with the profile
      foreach ($profile->roles as $role) {
        // Loop through permissions associated with the role
        foreach ($role->permissions as $permission) {
          $profilesRolesPermissions[] = [
            'org_id' => $profile->org_id,
            'org_code' => $orgCode,
            'role_name' => $role->name,
            'permission_name' => $permission->name,
          ];

          // Store permission for the organization
          $permissions_orgs[$permission->name][$profile->org_id] = true;
        }
      }

      // Loop through direct permissions of the profile
      foreach ($profile->permissions as $permission) {
        $profilesRolesPermissions[] = [
          'org_id' => $profile->org_id,
          'org_code' => $orgCode,
          'role_name' => null,
          'permission_name' => $permission->name,
        ];

        // Store permission for the organization
        $permissions_orgs[$permission->name][$profile->org_id] = true;
      }
    }

    // Extract unique organization IDs for each permission
    foreach ($permissions_orgs as &$orgIds) {
      $orgIds = array_keys($orgIds);
    }

    return [
      'id' => $this->id,
      'name' => $this->name,
      'last_name' => $this->last_name,
      'second_last_name' => $this->second_last_name,
      'email' => $this->email,
      // 'created_at' => $this->created_at,
      'roles' => $this->roles,
      'direct_permissions' => $this->getDirectPermissions(),
      // 'profiles_permission' => $profilesRolesPermissions,
      'permissions_org' => $permissions_orgs,

    ];

  }
}
