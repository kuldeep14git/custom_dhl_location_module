<?php

namespace Drupal\custom_dhl_location_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DhlSettingsForm.
 */
class DhlSettingsForm extends ConfigFormBase
{
  /**
   * {@inheritdoc}
   */
    protected function getEditableConfigNames()
    {
        return ['custom_dhl_location_module.settings'];
    }

  /**
   * {@inheritdoc}
   */
    public function getFormId()
    {
        return 'dhl_settings_form';
    }

  /**
   * {@inheritdoc}
   */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('custom_dhl_location_module.settings');

        $form['dhl_api_key'] = [
        '#type' => 'textfield',
        '#title' => $this->t('DHL API Key'),
        '#default_value' => $config->get('dhl_api_key'),
        '#required' => true,
        ];

        $form['dhl_api_endpoint'] = [
        '#type' => 'textfield',
        '#title' => $this->t('DHL API Endpoint'),
        '#default_value' => $config->get('dhl_api_endpoint'),
        '#required' => true,
        ];

        return parent::buildForm($form, $form_state);
    }

  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->configFactory->getEditable('custom_dhl_location_module.settings')
        ->set('dhl_api_key', $form_state->getValue('dhl_api_key'))
        ->set('dhl_api_endpoint', $form_state->getValue('dhl_api_endpoint'))
        ->save();

        parent::submitForm($form, $form_state);
    }
}
