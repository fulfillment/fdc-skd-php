# Swagger\Client\OrdersApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteOrdersId**](OrdersApi.md#deleteordersid) | **DELETE** /orders/{id} | Cancel an Order
[**getOrder**](OrdersApi.md#getorder) | **GET** /orders/{id} | Order Details
[**getOrders**](OrdersApi.md#getorders) | **GET** /orders | List of Orders
[**postOrders**](OrdersApi.md#postorders) | **POST** /orders | New Order

# **deleteOrdersId**
> \Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema deleteOrdersId($id)

Cancel an Order

Request an order is canceled to prevent shipment.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 56; // int | ID of order that needs to be canceled

try {
    $result = $apiInstance->deleteOrdersId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->deleteOrdersId: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| ID of order that needs to be canceled |

### Return type

[**\Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchema**](../Model/Paths1ordersPostResponses201ContentApplication1jsonSchema.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getOrder**
> \Swagger\Client\Model\Paths1ordersGetResponses200ContentApplication1jsonSchema getOrder($id, $merchant_id, $hydrate)

Order Details

For the fastest results use the FDC provided `id` however you can use your `merchantOrderId` as the `id`.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = "id_example"; // string | The FDC order Id
$merchant_id = 56; // int | Providing your `merchantId` indicates the `id` is your `merchantOrderId`. Although it is not necessary to provide this it will speed up your results when using your `merchantOrderId` however it will slow your results when using the FDC provided `id`
$hydrate = array("hydrate_example"); // string[] | Adds additional information to the response, uses a CSV format for multiple values.'

try {
    $result = $apiInstance->getOrder($id, $merchant_id, $hydrate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->getOrder: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| The FDC order Id |
 **merchant_id** | **int**| Providing your &#x60;merchantId&#x60; indicates the &#x60;id&#x60; is your &#x60;merchantOrderId&#x60;. Although it is not necessary to provide this it will speed up your results when using your &#x60;merchantOrderId&#x60; however it will slow your results when using the FDC provided &#x60;id&#x60; | [optional]
 **hydrate** | [**string[]**](../Model/string.md)| Adds additional information to the response, uses a CSV format for multiple values.&#x27; | [optional]

### Return type

[**\Swagger\Client\Model\Paths1ordersGetResponses200ContentApplication1jsonSchema**](../Model/Paths1ordersGetResponses200ContentApplication1jsonSchema.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getOrders**
> \Swagger\Client\Model\OrderResponseOneOfV2 getOrders($from_date, $to_date, $merchant_ids, $warehouse_ids, $page, $limit, $hydrate)

List of Orders

Retrieve many orders at once

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from_date = "from_date_example"; // string | Date-time in ISO 8601 format for selecting orders after, or at, the specified time
$to_date = "to_date_example"; // string | Date-time in ISO 8601 format for selecting orders before, or at, the specified time
$merchant_ids = array(56); // int[] | A CSV of merchant id, '123' or '1,2,3'
$warehouse_ids = array(56); // int[] | A CSV of warehouse id, '123' or '1,2,3'
$page = 1; // int | A multiplier of the number of items (limit paramater) to skip before returning results
$limit = 80; // int | The numbers of items to return
$hydrate = array("hydrate_example"); // string[] | Adds additional information to the response, uses a CSV format for multiple values.'

try {
    $result = $apiInstance->getOrders($from_date, $to_date, $merchant_ids, $warehouse_ids, $page, $limit, $hydrate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->getOrders: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **from_date** | **string**| Date-time in ISO 8601 format for selecting orders after, or at, the specified time |
 **to_date** | **string**| Date-time in ISO 8601 format for selecting orders before, or at, the specified time |
 **merchant_ids** | [**int[]**](../Model/int.md)| A CSV of merchant id, &#x27;123&#x27; or &#x27;1,2,3&#x27; | [optional]
 **warehouse_ids** | [**int[]**](../Model/int.md)| A CSV of warehouse id, &#x27;123&#x27; or &#x27;1,2,3&#x27; | [optional]
 **page** | **int**| A multiplier of the number of items (limit paramater) to skip before returning results | [optional] [default to 1]
 **limit** | **int**| The numbers of items to return | [optional] [default to 80]
 **hydrate** | [**string[]**](../Model/string.md)| Adds additional information to the response, uses a CSV format for multiple values.&#x27; | [optional]

### Return type

[**\Swagger\Client\Model\OrderResponseOneOfV2**](../Model/OrderResponseOneOfV2.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postOrders**
> \Swagger\Client\Model\OrderResponseV2 postOrders($body)

New Order

Error Notes&#58; * When `409 Conflict` is a 'Duplicate Order' the `context` will include the FDC `id`, see samples.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\OrderRequestV2(); // \Swagger\Client\Model\OrderRequestV2 | The order to create

try {
    $result = $apiInstance->postOrders($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->postOrders: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\OrderRequestV2**](../Model/OrderRequestV2.md)| The order to create |

### Return type

[**\Swagger\Client\Model\OrderResponseV2**](../Model/OrderResponseV2.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

