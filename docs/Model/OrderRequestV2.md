# OrderRequestV2

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**merchant_id** | **int** | Necessary if you have a multitenancy account, otherwise we will associate the order with your account | [optional] 
**merchant_order_id** | **string** | Unique ID provided by the merchant | 
**shipping_method** | **string** | Custom for you, it will be mapped to an actual method within the OMS UI | 
**recipient** | [**\Swagger\Client\Model\ConsigneeNewV2**](ConsigneeNewV2.md) |  | 
**items** | [**\Swagger\Client\Model\OrdersItems[]**](OrdersItems.md) |  | 
**warehouse** | [**\Swagger\Client\Model\OrdersWarehouse**](OrdersWarehouse.md) |  | [optional] 
**integrator** | **string** | Use of this property requires special permission and must be discussed with your account executive; values are restricted while custom values need to be accepted by your AE. | [optional] 
**notes** | **string** |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

