# OrderResponseV2

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** | FDC ID for this order | 
**tracking_numbers** | [**\Swagger\Client\Model\TrackingNumberV2[]**](TrackingNumberV2.md) |  | [optional] 
**validated_consignee** | [**\Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchemaPropertiesOriginalConsignee**](Paths1ordersPostResponses201ContentApplication1jsonSchemaPropertiesOriginalConsignee.md) |  | 
**original_consignee** | [**\Swagger\Client\Model\ConsigneeV21**](ConsigneeV21.md) |  | 
**current_status** | [**\Swagger\Client\Model\StatusEventV2**](StatusEventV2.md) |  | 
**warehouse** | [**\Swagger\Client\Model\UserV2**](UserV2.md) |  | [optional] 
**merchant** | [**\Swagger\Client\Model\MerchantV2**](MerchantV2.md) |  | 
**depart_date** | [**\DateTime**](\DateTime.md) | DateTime order departed an FDC warehouse | [optional] 
**dispatch_date** | [**\DateTime**](\DateTime.md) | DateTime order was dispatched for fulfillment by FDC | [optional] 
**recorded_on** | [**\DateTime**](\DateTime.md) | DateTime order was recorded by FDC | 
**merchant_shipping_method** | **string** | Requested ship method | 
**purchase_order_num** | **string** | Merchant provided PO# | [optional] 
**merchant_order_id** | **string** | Merchant provided ID | 
**parent_order** | [**\Swagger\Client\Model\OrderResponseV2ParentOrder**](OrderResponseV2ParentOrder.md) |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

