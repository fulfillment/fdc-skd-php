# StatusTypeV2

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** | Depricated, use code instead | [optional] 
**is_closed** | **bool** | Depricated, does this status event close the order | [optional] 
**action_required_by** | [**\Swagger\Client\Model\StatusTypeV2ActionRequiredBy**](StatusTypeV2ActionRequiredBy.md) |  | [optional] 
**stage** | [**\Swagger\Client\Model\StatusTypeV2Stage**](StatusTypeV2Stage.md) |  | 
**state** | [**\Swagger\Client\Model\StatusTypeV2Stage**](StatusTypeV2Stage.md) |  | 
**detail** | **string** |  | [optional] 
**reason** | **string** | Depricated | [optional] 
**name** | **string** | Depricated, use stage/state instead | [optional] 
**detail_code** | **string** |  | 
**code** | **string** | Code, see [status codes](#section/Getting-Started/Status-Codes) | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

