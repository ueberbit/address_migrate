<?php

/**
 * @file
 * Contains \Drupal\address_migrate\Plugin\migrate\source\d6\LocationField.
 */

namespace Drupal\address_migrate\Plugin\migrate\source\d6;

use Drupal\field\Plugin\migrate\source\d6\Field;

/**
 * Drupal 6 field source from database.
 *
 * @MigrateSource(
 *   id = "d6_field_location",
 *   source_provider = "content"
 * )
 */
class LocationField extends Field {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = parent::query();
    $query->condition('cnf.type', 'location');
    return $query;
  }

}
