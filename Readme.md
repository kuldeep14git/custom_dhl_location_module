# DHL Location Module

## Overview

 This module provides a form where users can select country from a dropdown list and can enter city and postal code to textfields. Once submit it can show available locations fetching from DHL API.

## Software used

- PHP 8.1
- Drupal 10.1

## Features

- **User Input Form**: Users can input the country, city, and postal code to search for DHL locations.
- **API Integration**: The module sends a request to the [DHL Location Finder API](https://api.dhl.com/location-finder) to retrieve location data.
- **Data Filtering**: Locations that do not operate on weekends and those with odd-numbered street addresses are filtered out.
- **YAML Output**: The filtered list of locations is displayed in YAML format, following the structure:
  ```yaml
  ---
  locationName: Packstation 103
  address:
    countryCode: DE
    postalCode: '01067'
    addressLocality: Dresden
    streetAddress: Falkenstr. 10
  openingHours:
    monday: '00:00:00 - 23:59:00'
    tuesday: '00:00:00 - 23:59:00'
    wednesday: '00:00:00 - 23:59:00'
    thursday: '00:00:00 - 23:59:00'
    friday: '00:00:00 - 23:59:00'
    saturday: '00:00:00 - 23:59:00'
    sunday: '00:00:00 - 23:59:00'

## Formatting (PSR-12 standard)

- I have used phpcs and used below commands to fix them.
- To see errors use this command : phpcs --standard=PSR12 web/modules/custom/custom_dhl_location_module
- To fix errors use this command : phpcbf --standard=PSR12 web/modules/custom/custom_dhl_location_module

## Test Case Creation

- I have created testcases using PHPunit
- Use below command to run test cases
- vendor/bin/phpunit -c web/core web/modules/custom/custom_dhl_location_module/tests/src/Unit
- You will see something like this :

Time: 00:00.126, Memory: 12.00 MB

OK (4 tests, 6 assertions)


## API 
- Use below curl request :
  ```bash
  curl --location --request GET 'https://api.dhl.com/location-finder/v1/find-by-address?countryCode=NL&postalCode=1106LN&city=Amsterdam' \
--header 'DHL-API-Key: demo-key' \
--header 'Content-Type: application/json' \
--data '{
   "countryCode":"NL11",
   "city":"Amsterdam",
   "postalCode":"1106LN"
}'
