<?php

/**
 * @file
 * Contains \Drupal\address_migrate\Plugin\migrate\source\d6\LocationFieldInstance.
 */

namespace Drupal\address_migrate\Plugin\migrate\source\d6;

use Drupal\field\Plugin\migrate\source\d6\FieldInstance;

/**
 * Drupal 6 field instances source from database.
 *
 * @MigrateSource(
 *   id = "d6_field_instance_location",
 *   source_provider = "content"
 * )
 */
class LocationFieldInstance extends FieldInstance {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = parent::query();
    $query->condition('cnf.type', 'location');
    return $query;
  }

}
