<?php

namespace Drupal\joomla_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for beer content.
 *
 * @MigrateSource(
 *   id = "joomla_node"
 * )
 */
class JoomlaNode extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    /**
     * An important point to note is that your query *must* return a single row
     * for each item to be imported. Here we might be tempted to add a join to
     * migrate_example_beer_topic_node in our query, to pull in the
     * relationships to our categories. Doing this would cause the query to
     * return multiple rows for a given node, once per related value, thus
     * processing the same node multiple times, each time with only one of the
     * multiple values that should be imported. To avoid that, we simply query
     * the base node data here, and pull in the relationships in prepareRow()
     * below.
     */
    $query = $this->select('xi83f_content', 'jcon');
    $query->join('xi83f_contentitem_tag_map', 'jctm', 'jcon.id = jctm.content_item_id');
    $query->fields('jcon', [
                    'id',
                    'asset_id',
                    'title',
                    'alias',
                    'introtext',
                    // For some inexplicable reason, Drupal hates this field.
                    // 'fulltext',
                    'state',
                    'catid',
                    'created',
                    'created_by',
                    'created_by_alias',
                    'modified',
                    'modified_by',
                    'checked_out',
                    'checked_out_time',
                    'publish_up',
                    'publish_down',
                    'images',
                    'urls',
                    'attribs',
                    'version',
                    'ordering',
                    'metakey',
                    'metadesc',
                    'access',
                    'hits',
                    'metadata',
                    'featured',
                    'language',
                    'xreference']);
    $query->fields('jctm', [
                    'tag_id']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('ID'),
      'asset_id' => $this->t('Asset ID'),
      'title' => $this->t('Title'),
      'alias' => $this->t('Article URL'),
      'introtext' => $this->t('Intro Text'),
      // 'fulltext' => $this->t('Full Text'),
      'state' => $this->t('State'),
      'catid' => $this->t('Category ID'),
      'created' => $this->t('Created Date'),
      'created_by' => $this->t('Author ID'),
      'created_by_alias' => $this->t('Created By Alias'),
      'modified' => $this->t('Modified Date'),
      'modified_by' => $this->t('Modified By'),
      'checked_out' => $this->t('Checked Out Date'),
      'checked_out_time' => $this->t('Checked Out Time'),
      'publish_up' => $this->t('Published Up?'),
      'publish_down' => $this->t('Published Down?'),
      'images' => $this->t('Images'),
      'urls' => $this->t('URLs'),
      'attribs' => $this->t('Attibutes'),
      'version' => $this->t('Version'),
      'ordering' => $this->t('Ordering'),
      'metakey' => $this->t('Metatag Keywords'),
      'metadesc' => $this->t('Meta Description'),
      'access' => $this->t('Access'),
      'hits' => $this->t('Hits'),
      'metadata' => $this->t('Metadata'),
      'featured' => $this->t('Featured'),
      'language' => $this->t('Language'),
      'xreference' => $this->t('Xreference'),
      'tag_id' => $this->t('tag_id'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        // This is an optional key currently only used by SqlBase.
        'alias' => 'jcon',
      ],
    ];
  }

}
