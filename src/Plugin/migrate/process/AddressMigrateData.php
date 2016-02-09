<?php

/**
 * @file
 * Contains \Drupal\address_migrate\Plugin\migrate\process\AddressMigrateData.
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
 *   id = "address_migrate_data"
 * )
 */
class AddressMigrateData extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (empty($value['lid'])) {
      throw new MigrateSkipProcessException();
    }

    $source = 'address_migrate_data/' . $value['lid'];
    if ($row->hasSourceProperty($source)) {
      return $row->getSourceProperty($source);
    }

    throw new MigrateSkipProcessException();
  }

}
