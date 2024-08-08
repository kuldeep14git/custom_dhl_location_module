<?php

namespace Drupal\custom_dhl_location_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_dhl_location_module\Service\DhlLocationService;

/**
 * Controller for displaying DHL locations.
 */
class LocationController extends ControllerBase
{
   /**
   * The DHL Location Service.
   *
   * @var \Drupal\custom_dhl_location_module\Service\DhlLocationService
   */
    protected $dhlLocationService;

  /**
   * Constructs a LocationController object.
   *
   * @param \Drupal\custom_dhl_location_module\Service\DhlLocationService $dhl_location_service
   *   The DHL Location Service.
   */
    public function __construct(DhlLocationService $dhl_location_service)
    {
        $this->dhlLocationService = $dhl_location_service;
    }

  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('custom_dhl_location_module.dhl_location_service')
        );
    }

    public function display($country, $city, $postal_code)
    {
        $yamlData = $this->dhlLocationService->getLocations($country, $city, $postal_code);

        if ($yamlData && !empty($yamlData)) {
            return [
                '#type' => 'markup',
                '#markup' => '<pre>' . $yamlData . '</pre>',
                ];
        } else {
            return [
                '#type' => 'markup',
                '#markup' => "<span>No result Found! </span><a href = '/dhl-form'> Click here to return </a>",
                ];
        }
    }
}
