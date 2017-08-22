<?php

namespace Drupal\joomla_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for blogs.
 *
 * @MigrateSource(
 *   id = "joomla_blog"
 * )
 */
class JoomlaBlog extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $config = \Drupal::config('joomlamigrate.settings');
    $database = $config->get('database');
    $prefix = $config->get('table_prefix');
    return $this->select($prefix . 'legacy_blogs', 'jb')
                ->fields('jb', ['ID', 'Title', 'Content', 'Category', 'Author', 'Email', 'Tags', 'Created']);
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'ID' => $this->t('Account ID'),
      'Title' => $this->t('Blog Title'),
      'Content' => $this->t('Blog Content'),
      'Category' => $this->t('Legacy Blog Category'),
      'Author' => $this->t('Legacy Blog Author'),
      'Email' => $this->t('Email of Author'),
      'Created' => $this->t('Created On'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'ID' => [
        'type' => 'integer',
        'alias' => 'jb',
      ],
    ];
  }

}