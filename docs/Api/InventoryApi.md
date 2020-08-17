# Swagger\Client\InventoryApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getInventory**](InventoryApi.md#getinventory) | **GET** /inventory | List of Item Inventories

# **getInventory**
> \Swagger\Client\Model\ItemInventoryArrayV2 getInventory($page, $limit, $merchant_ids, $external_sku_names)

List of Item Inventories

Retrieve inventory for one or more items. This API requires elevated permissions, please speak to your success manager.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: fdcAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Swagger\Client\Api\InventoryApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 1; // int | A multiplier of the number of items (limit paramater) to skip before returning results
$limit = 80; // int | The numbers of items to return
$merchant_ids = array(56); // int[] | A CSV of merchant id, '123' or '1,2,3'
$external_sku_names = array("external_sku_names_example"); // string[] | A CSV of sku reference names, 'skuName1' or 'skuName1,skuName2,skuName3'

try {
    $result = $apiInstance->getInventory($page, $limit, $merchant_ids, $external_sku_names);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InventoryApi->getInventory: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| A multiplier of the number of items (limit paramater) to skip before returning results | [optional] [default to 1]
 **limit** | **int**| The numbers of items to return | [optional] [default to 80]
 **merchant_ids** | [**int[]**](../Model/int.md)| A CSV of merchant id, &#x27;123&#x27; or &#x27;1,2,3&#x27; | [optional]
 **external_sku_names** | [**string[]**](../Model/string.md)| A CSV of sku reference names, &#x27;skuName1&#x27; or &#x27;skuName1,skuName2,skuName3&#x27; | [optional]

### Return type

[**\Swagger\Client\Model\ItemInventoryArrayV2**](../Model/ItemInventoryArrayV2.md)

### Authorization

[fdcAuth](../../README.md#fdcAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

