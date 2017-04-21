<?php

namespace Drupal\joomla_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * This is an example of a simple SQL-based source plugin. Source plugins are
 * classes which deliver source data to the processing pipeline. For SQL
 * sources, the SqlBase class provides most of the functionality needed - for
 * a specific migration, you are required to implement the three simple public
 * methods you see below.
 *
 * This annotation tells Drupal that the name of the MigrateSource plugin
 * implemented by this class is "beer_term". This is the name that the migration
 * configuration references with the source "plugin" key.
 *
 * @MigrateSource(
 *   id = "joomla_tag"
 * )
 */
class JoomlaTag extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    /**
     * The most important part of a SQL source plugin is the SQL query to
     * retrieve the data to be imported. Note that the query is not executed
     * here - the migration process will control execution of the query. Also
     * note that it is constructed from a $this->select() call - this ensures
     * that the query is executed against the database configured for this
     * source plugin.
     */
    return $this->select('xi83f_tags', 'jtag')
      ->fields('jtag', ['id', 'parent_id', 'lft', 'rgt', 'level', 'path',
        'title', 'alias', 'note', 'description', 'published', 'checked_out',
        'checked_out_time', 'access', 'params', 'metadesc', 'metakey',
        'metadata', 'created_user_id', 'created_time', 'modified_user_id',
        'modified_time', 'images', 'urls', 'hits', 'language', 'version',
        'publish_up', 'publish_down'])
      // We sort this way to ensure parent terms are imported first.
      ->orderBy('parent_id', 'ASC');
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    /**
     * This method simply documents the available source fields provided by
     * the source plugin, for use by front-end tools. It returns an array keyed
     * by field/column name, with the value being a translated string explaining
     * to humans what the field represents. You should always
     */
    $fields = [
      'id' => $this->t('Category ID'),
      'parent_id' => $this->t('Parent category ID'),
      'lft' => $this->t('Unknown'),
      'rgt' => $this->t('Unknown'),
      'level' => $this->t('N/A'),
      'path' => $this->t('PATHalias?'),
      'title' => $this->t('Title'),
      'alias' => $this->t('pathALIAS?'),
      'note' => $this->t('Note'),
      'description' => $this->t('Description'),
      'published' => $this->t('Published boolean'),
      'checked_out' => $this->t('Checked out boolean'),
      'checked_out_time' => $this->t('Checked out time'),
      'access' => $this->t('Unknown'),
      'params' => $this->t('Serialized data'),
      'metadesc' => $this->t('Metadesc'),
      'metakey' => $this->t('Metakey'),
      'metadata' => $this->t('Metadata'),
      'created_user_id' => $this->t('Created user ID'),
      'created_time' => $this->t('Created time'),
      'modified_user_id' => $this->t('Modified user ID'),
      'modified_time' => $this->t('Modified time'),
      'images' => $this->t('Images'),
      'urls' => $this->t('URLs'),
      'hits' => $this->t('Hits'),
      'language' => $this->t('Language'),
      'version' => $this->t('Version'),
      'publish_up' => $this->t('Publish up'),
      'publish_down' => $this->t('Publish down'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    /**
     * This method indicates what field(s) from the source row uniquely identify
     * that source row, and what their types are. This is critical information
     * for managing the migration. The keys of the returned array are the field
     * names from the query which comprise the unique identifier. The values are
     * arrays indicating the type of the field, used for creating compatible
     * columns in the map tables that track processed items.
     */
    return [
      'id' => [
        'type' => 'integer',
        // 'alias' is the alias for the table containing 'style' in the query
        // defined above. Optional in this case, but necessary if the same
        // column may occur in multiple tables in a join.
        'alias' => 'jtag',
      ],
    ];
  }

}
