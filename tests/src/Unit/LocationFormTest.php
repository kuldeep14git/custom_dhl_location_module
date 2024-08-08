<?php

namespace Drupal\Tests\custom_dhl_location_module\Unit;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\custom_dhl_location_module\Form\LocationForm;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Form\FormState;

/**
 * Tests for the LocationForm class.
 *
 * @group custom_dhl_location_module
 */
class LocationFormTest extends UnitTestCase
{
    use StringTranslationTrait;

    /**
     * Tests form ID.
     */
    public function testGetFormId()
    {
        $form = new LocationForm();
        $this->assertEquals('custom_dhl_location_module_form', $form->getFormId());
    }

    /**
     * Tests form build.
     */
    /**
   * Tests the buildForm method.
   */
    public function testBuildForm()
    {
      // Mock the StringTranslation service.
        $translation = $this->createMock(TranslationInterface::class);
        $translation->method('translate')
        ->willReturnArgument(0);

      // Set the container with the mocked translation service.
        $container = new ContainerBuilder();
        $container->set('string_translation', $translation);
        \Drupal::setContainer($container);

      // Instantiate the form class.
        $form = new LocationForm();

      // Mock FormStateInterface.
        $form_state = $this->createMock(FormStateInterface::class);

      // Call the buildForm method.
        $form_array = $form->buildForm([], $form_state);

      // Assertions to ensure form array structure is as expected.
        $this->assertArrayHasKey('country', $form_array);
        $this->assertArrayHasKey('city', $form_array);
        $this->assertArrayHasKey('postal_code', $form_array);
    }

    /**
     * Tests form submission.
     */
    public function testSubmitForm()
    {
        $form = new LocationForm();
        $form_state = $this->createMock(FormState::class);
        $form_state->expects($this->once())
            ->method('setRedirectUrl');
        $form_structure = [];
        $form->submitForm($form_structure, $form_state);
    }
}
