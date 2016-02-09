<?php

/**
 * @file
 * Contains \Drupal\address_migrate\Plugin\migrate\cckfield\Location.
 */

namespace Drupal\address_migrate\Plugin\migrate\cckfield;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Entity\MigrationInterface;
use Drupal\migrate\Plugin\MigratePluginManager;
use Drupal\migrate_drupal\Plugin\migrate\cckfield\CckFieldPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @MigrateCckField(
 *   id = "location",
 *   type_map = {}
 * )
 */
class Location extends CckFieldPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The migrate plugin manager, configured for lookups in d6_user_roles.
   *
   * @var \Drupal\migrate\Plugin\MigratePluginManager
   */
  protected $migratePluginManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigratePluginManager $migration_plugin_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->migratePluginManager = $migration_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.migrate.process')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldFormatterMap() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function processCckFieldValues(MigrationInterface $migration, $field_name, $data) {
    $process = [
      [
        'plugin' => 'address_migrate_data',
        'source' => $field_name
      ],
      [
        'plugin' => 'iterator',
        'process' => [
          'country_code' => [
            'plugin' => 'callback',
            'callable' => 'strtoupper',
            'source' => 'country',
          ],
          // 'administrative_area' => '',
          'locality' => 'city',
          // 'dependent_locality' => 'province',
          'postal_code' => 'postal_code',
          // 'sorting_code'
          'address_line1' => 'street',
          'address_line2' => 'additional',
          'organization' => 'name',
          // 'recipient' => '',
        ],
      ]
    ];
    $migration->setProcessOfProperty($field_name, $process);

    $process = [
      [
        'plugin' => 'address_migrate_data',
        'source' => $field_name,
      ],
      [
        'plugin' => 'iterator',
        'process' => [
          'value' => [
            'plugin' => 'address_migrate_lat_lon',
            'source' => [
              'longitude',
              'latitude'
            ],
          ],
        ],
      ]
    ];
    // @todo: Use suffix from d6_field_address_geofield
    $migration->setProcessOfProperty($field_name . '_geo', $process);
  }

}
