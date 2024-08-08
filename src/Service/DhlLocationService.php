<?php

namespace Drupal\custom_dhl_location_module\Service;

use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class DhlLocationService.
 *
 * This service interacts with the DHL API to retrieve locations.
 */
class DhlLocationService
{
  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
    protected $httpClient;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
    protected $configFactory;

  /**
   * Constructs a DhlLocationService object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
    public function __construct(ClientInterface $http_client, ConfigFactoryInterface $config_factory)
    {
        $this->httpClient = $http_client;
        $this->configFactory = $config_factory;
    }

  /**
   * Fetches locations from the DHL API.
   *
   * @param string $country
   *   The country code.
   * @param string $city
   *   The city name.
   * @param string $postal_code
   *   The postal code.
   *
   * @return array
   *   An array of locations.
   */
    public function getLocations($country, $city, $postal_code)
    {
        $config = $this->configFactory->get('custom_dhl_location_module.settings');
        $api_key = $config->get('dhl_api_key') ?: 'demo-key';
        $url = $config->get('dhl_api_endpoint') ?: 'https://api.dhl.com/location-finder/v1/find-by-address';

        $query = [
        'countryCode' => $country,
        'city' => $city,
        'postalCode' => $postal_code,
        ];

        $response = $this->httpClient->get($url, [
        'query' => $query,
        'headers' => [
        'DHL-API-Key' => $api_key,
        ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (empty($data['locations'])) {
            return false;
        } else {
            $locations = $this->filterRecords($data);
            $yaml = $this->createYamlStructure($locations);
            return $yaml ?? [];
        }
    }

        /**
    * Add custom business logic here.
    */
    public function filterRecords($data)
    {
        $locations = array_filter($data['locations'], function ($location) {
            $address = $location['place']['address']['streetAddress'];
            $works_on_weekends = count($location['openingHours']) > 6;
            $has_even_address = preg_match('/\d+/', $address) &&
            ((int) filter_var($address, FILTER_SANITIZE_NUMBER_INT) % 2 === 0);
            return $works_on_weekends && $has_even_address;
        });

        return $locations;
    }

    /**
    * Create Yaml structure for Display.
    */
    public function createYamlStructure($locationData)
    {
        foreach ($locationData as $location) {
            $yaml_output[] = [
            'locationName' => $location['name'],
            'address' => [
            'countryCode' => $location['place']['address']['countryCode'],
            'postalCode' => $location['place']['address']['postalCode'],
            'addressLocality' => $location['place']['address']['addressLocality'],
            'streetAddress' => $location['place']['address']['streetAddress'],
            ],
            'openingHours' => $location['openingHours'],
            ];
        }

        $yaml = Yaml::dump($yaml_output, 3, 2);
        return $yaml;
    }
}
