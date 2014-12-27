<?php

/**
 * @file
 * Contains \Drupal\disqus\Form\SocialitejsSettingsForm.
 */

namespace Drupal\socialitejs\Form;


class SocialitejsSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'socialitejs_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $socialitejs_config = $this->config('socialitejs.settings');
    $types = node_type_get_types();
    foreach ($types as $type) {
      $node_types[$type->type] = $type->name;
    }

    $form['socialitejs_node_types'] = array(
      '#type'          => 'checkboxes',
      '#title'         => t('Node types'),
      '#description'   => t('Select the node types to display the share links on.'),
      '#default_value' => $socialitejs_config->get('socialitejs_node_types'),
      '#options'       => $node_types,
    );

    $form['socialitejs_teaser'] = array(
      '#type'          => 'checkbox',
      '#title'         => t('Teaser view'),
      '#description'   => t('Enable if you want to display socalite buttons in teaser view.'),
      '#default_value' => $socialitejs_config->get('socialitejs_teaser'),
    );

    $form['socialitejs_sites'] = array(
      '#type'          => 'checkboxes',
      '#title'         => t('Widgets'),
      '#description'   => t('Select the share links you would like to enable.'),
      '#default_value' => $socialitejs_config->get('socialitejs_sites'),
      '#options'       => array(
        'facebook'     => t('Facebook'),
        'twitter'      => t('Twitter'),
        'googleplus'      => t('Google+'),
        'linkedin'      => t('LinkedIn'),
      ),
    );

    $form['socialitejs_layout'] = array(
      '#type'          => 'radios',
      '#title'         => t('Layout'),
      '#description'   => t('Select a layout you would like to have for share links.'),
      '#default_value' => $socialitejs_config->get('socialitejs_layout'),
      '#options'       => array(
        '0' => t('Button Count'),
        '1' => t('Box Count'),
      ),
    );

    $form['socialitejs_loading'] = array(
      '#type'          => 'radios',
      '#title'         => t('Loading method'),
      '#description'   => t('Select the way you would want to load the socialite buttons.'),
      '#default_value' => $socialitejs_config->get('socialitejs_loading'),
      '#options'       => array(
        'page' => t('On page load'),
        'hover' => t('On hover (lazyload)'),
      ),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('socialitejs.settings');
    $config
      ->set('socialitejs_node_types', $form_state->getValue('socialitejs_node_types'))
      ->set('socialitejs_teaser', $form_state->getValue('socialitejs_teaser'))
      ->set('socialitejs_sites', $form_state->getValue('socialitejs_sites'))
      ->set('socialitejs_layout', $form_state->getValue('socialitejs_layout'))
      ->set('socialitejs_loading', $form_state->getValue('socialitejs_loading'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
