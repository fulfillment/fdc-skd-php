# Swagger\Client\ReturnsApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getReturns**](ReturnsApi.md#getreturns) | **GET** /returns | List Returns
[**putReturns**](ReturnsApi.md#putreturns) | **PUT** /returns | Inform us of an RMA

# **getReturns**
> \Swagger\Client\Model\ReturnsArrayV2 getReturns($from_date, $to_date, $page, $limit)

List Returns

Retrieves summary return activity during the queried timespan. Although return knowledge can be learned from `GET /orders/{id}` it can take an unknown amount of time for an order that is refused or undeliverable to return to an FDC facility. Instead we recommend regularly querying this API.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\ReturnsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from_date = "from_date_example"; // string | Date-time in ISO 8601 format for selecting orders after, or at, the specified time
$to_date = "to_date_example"; // string | Date-time in ISO 8601 format for selecting orders before, or at, the specified time
$page = 1; // int | A multiplier of the number of items (limit paramater) to skip before returning results
$limit = 80; // int | The numbers of items to return

try {
    $result = $apiInstance->getReturns($from_date, $to_date, $page, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReturnsApi->getReturns: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **from_date** | **string**| Date-time in ISO 8601 format for selecting orders after, or at, the specified time |
 **to_date** | **string**| Date-time in ISO 8601 format for selecting orders before, or at, the specified time |
 **page** | **int**| A multiplier of the number of items (limit paramater) to skip before returning results | [optional] [default to 1]
 **limit** | **int**| The numbers of items to return | [optional] [default to 80]

### Return type

[**\Swagger\Client\Model\ReturnsArrayV2**](../Model/ReturnsArrayV2.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **putReturns**
> \Swagger\Client\Model\RmaResponseV2 putReturns($body)

Inform us of an RMA

Inform FDC of an expected return.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\ReturnsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\RmaRequestV2(); // \Swagger\Client\Model\RmaRequestV2 | RMA

try {
    $result = $apiInstance->putReturns($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReturnsApi->putReturns: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\RmaRequestV2**](../Model/RmaRequestV2.md)| RMA |

### Return type

[**\Swagger\Client\Model\RmaResponseV2**](../Model/RmaResponseV2.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

