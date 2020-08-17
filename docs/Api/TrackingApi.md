# Swagger\Client\TrackingApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getTrack**](TrackingApi.md#gettrack) | **GET** /track | Tracking

# **getTrack**
> \Swagger\Client\Model\TrackingResponse getTrack($tracking_number)

Tracking

Get uniformed tracking events for any package, this response is carrier independent. Please note, an API Key is required for throttling purposes, please contact your success manager for details.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\TrackingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$tracking_number = "tracking_number_example"; // string | 

try {
    $result = $apiInstance->getTrack($tracking_number);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrackingApi->getTrack: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **tracking_number** | **string**|  | [optional]

### Return type

[**\Swagger\Client\Model\TrackingResponse**](../Model/TrackingResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

