<?php

/**
 * @file
 * Contains \Drupal\address_migrate\Plugin\migrate\process\AddressMigrateLatLon.
 */

namespace Drupal\address_migrate\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipProcessException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * This plugin extracts a value from an array.
 *
 * @MigrateProcessPlugin(
 *   id = "address_migrate_lat_lon"
 * )
 */
class AddressMigrateLatLon extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (count($value) == 2 && isset($value[0]) && isset($value[1])) {
      return \Drupal::service('geofield.wkt_generator')->WktBuildPoint($value);
    }
    throw new MigrateSkipProcessException();
  }

}
