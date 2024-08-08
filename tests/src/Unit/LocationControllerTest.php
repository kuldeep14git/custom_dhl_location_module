<?php

namespace Drupal\Tests\custom_dhl_location_module\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use GuzzleHttp\Client;
use Drupal\Tests\UnitTestCase;
use Drupal\custom_dhl_location_module\Controller\LocationController;
use Drupal\custom_dhl_location_module\Service\DhlLocationService;

/**
 * Tests for the LocationController class.
 *
 * @group custom_dhl_location_module
 */
class LocationControllerTest extends UnitTestCase
{
    /**
     * Tests the display function.
     */
    public function testDisplay()
    {
        $container = new ContainerBuilder();
        $http_client = $this->createMock(Client::class);
        $container->set('http_client', $http_client);
        \Drupal::setContainer($container);

        $controller = new LocationController($this->createMock(DhlLocationService::class), $http_client);

        $response = $controller->display('NL', 'Amsterdam', '1106LN');

        $this->assertNotEmpty($response);
    }
}
