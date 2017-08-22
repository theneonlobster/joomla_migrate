<?php

namespace Drupal\joomla_migrate\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a form to collect security check configuration.
 */
class JoomlaMigrateSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'joomlamigrate_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['joomlamigrate.settings'];
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $module_path = drupal_get_path('module', 'joomla_migrate');

    $config = \Drupal::config('joomlamigrate.settings');

    // main description
    $args = array(
      ':untappd' => 'https://untappd.com/api/docs',
      '@untappd' => 'Untappd API',
    );
    $form['untappd_description'] = array(
      '#markup' => t('This module provides an HTTP client that communicates with the <a href=":untappd">@untappd</a>.', $args),
    );

    $form['database'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Database name'),
      '#description' => $this->t('The database name, according to your settings.php file.'),
      '#required' => TRUE,
      '#default_value' => $config->get('database'),
    ];
    $form['table_prefix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Table prefix'),
      '#required' => FALSE,
      '#default_value' => $config->get('table_prefix'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // @TODO
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $list = [];
    $this->buildAttributeList($list, $form_state->getValues());
    $config = $this->config('joomlamigrate.settings');

    foreach ($list as $key => $value) {
      $config->set($key, $value);
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Build the configuration form value list.
   */
  protected function buildAttributeList(
    array &$list = [],
    array $rawAttributes = [],
    $currentName = '')
  {
    foreach ($rawAttributes as $key => $rawAttribute) {
      $name = $currentName ? $currentName . '.' . $key:$key;
      if (in_array($name,['op','form_id','form_token','form_build_id','submit'])){
        continue;
      }
      if (is_array($rawAttribute)) {
        $this->buildAttributeList($list, $rawAttribute, $name);
      } else {
        $list[$name] = $rawAttribute;
      }
    }
  }
}
