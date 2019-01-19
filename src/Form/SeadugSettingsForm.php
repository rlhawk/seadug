<?php

namespace Drupal\seadug\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form to configure SeaDUG settings.
 */
class SeadugSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'seadug_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'seadug.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('seadug.settings');

    $form['url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL'),
      '#default_value' => $config->get('url'),
      '#description' => $this->t('Enter a URL.'),
    ];

    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#default_value' => $config->get('date'),
      '#description' => $this->t('Choose a date.'),
    ];

    $form['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Size'),
      '#empty_value' => '',
      '#options' => [
        's' => $this->t('Small'),
        'm' => $this->t('Medium'),
        'l' => $this->t('Large'),
        'xl' => $this->t('Extra large'),
      ],
      '#default_value' => $config->get('size'),
      '#description' => $this->t('Select a size.'),
    ];

    $form['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable by default'),
      '#default_value' => $config->get('enable'),
      '#description' => $this->t('Enable SeaDUG integration for content types by default.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('seadug.settings')
      ->set('url', $values['url'])
      ->set('date', $values['date'])
      ->set('size', $values['size'])
      ->set('enable', $values['enable'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
