<?php

namespace Drupal\joomla_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for beer user accounts.
 *
 * @MigrateSource(
 *   id = "joomla_user"
 * )
 */
class JoomlaUser extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $config = \Drupal::config('joomlamigrate.settings');
    $database = $config->get('database');
    $prefix = $config->get('table_prefix');
    return $this->select($prefix . 'users', 'ju')
                ->fields('ju', ['id', 'name', 'username', 'email', 'password', 'block',
                  'sendEmail', 'registerDate', 'lastvisitDate', 'activation', 'params','lastResetTime', 'resetCount', 'otpKey', 'otep', 'requireReset']);
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Account ID'),
      'name' => $this->t('Account name (for display)'),
      'username' => $this->t('Account name (for login)'),
      'email' => $this->t('Account email'),
      'password' => $this->t('Account password (raw)'),
      'block' => $this->t('User is Blocked'),
      'sendEmail' => $this->t('Email is from'),
      'registerDate' => $this->t('Register Date'),
      'lastvisitDate' => $this->t('Last Visit'),
      'activation' => $this->t('Activation'),
      'params' => $this->t('Parameters'),
      'lastResetTime' => $this->t('Last Reset Time'),
      'resetCount' => $this->t('Reset Count'),
      'optKey' => $this->t('Optional Key (?????)'),
      'otep' => $this->t('OTEP (????)'),
      'requireReset' => $this->t('Require Reset ???'),
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
        'alias' => 'ju',
      ],
    ];
  }

}
