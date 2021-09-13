<?php

namespace Drupal\utdk_saas;

use Drupal\user\Entity\Role;

/**
 * Perform common tasks for SaaS sites.
 */
class SaasHelper {

  /**
   * Save permissions to a given role.
   *
   * @param array $permissions
   *   Machine-readable permission names.
   * @param string $role
   *   A valid Drupal role machine name.
   *
   * @return bool
   *   Whether or not the save was successful.
   */
  public static function assignPermissions(array $permissions, $role) {
    $available_permissions = \Drupal::service('user.permissions')->getPermissions();
    if (!$role = Role::load($role)) {
      return FALSE;
    }
    foreach ($permissions as $permission) {
      if (!in_array($permission, array_keys($available_permissions))) {
        continue;
      }
      if ($role->hasPermission($permission)) {
        continue;
      }
      $role->grantPermission($permission);
    }
    return $role->save();
  }

}
