# Swagger\Client\PartnersApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**putOrdersIdShip**](PartnersApi.md#putordersidship) | **PUT** /orders/{id}/ship | Ship an Order
[**putOrdersIdStatus**](PartnersApi.md#putordersidstatus) | **PUT** /orders/{id}/status | Update Order Status

# **putOrdersIdShip**
> \Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema putOrdersIdShip($body, $id)

Ship an Order

Note, this API is used to update orders and is reserved for our shipping partners.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\PartnersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\OrderShipV2(); // \Swagger\Client\Model\OrderShipV2 | Shipping Details
$id = 56; // int | The FDC order Id

try {
    $result = $apiInstance->putOrdersIdShip($body, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PartnersApi->putOrdersIdShip: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\OrderShipV2**](../Model/OrderShipV2.md)| Shipping Details |
 **id** | **int**| The FDC order Id |

### Return type

[**\Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema**](../Model/Paths1ordersPostResponses201ContentApplication1jsonSchema.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **putOrdersIdStatus**
> \Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema putOrdersIdStatus($body, $id)

Update Order Status

Note, this API is used to update orders and is reserved for our shipping partners.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\PartnersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\StatusTypeSimpleV2(); // \Swagger\Client\Model\StatusTypeSimpleV2 | New status event
$id = 56; // int | The FDC order Id

try {
    $result = $apiInstance->putOrdersIdStatus($body, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PartnersApi->putOrdersIdStatus: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\StatusTypeSimpleV2**](../Model/StatusTypeSimpleV2.md)| New status event |
 **id** | **int**| The FDC order Id |

### Return type

[**\Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema**](../Model/Paths1ordersPostResponses201ContentApplication1jsonSchema.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

