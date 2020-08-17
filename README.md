# SwaggerClient-php
Welcome to our current iteration of our REST API. While we encourage you to upgrade to v2.0 we will continue support for our [SOAP API](https://github.com/fulfillment/soap-integration).  # Versioning  The Fulfillment.com (FDC) REST API is version controlled and backwards compatible. We have many future APIs scheduled for publication within our v2.0 spec so please be prepared for us to add data nodes in our responses, however, we will not remove knowledge from previously published APIs.  #### A Current Response  ```javascript {   id: 123 } ```  #### A Potential Future Response  ```javascript {   id: 123,   reason: \"More Knowledge\" } ```  # Getting Started  We use OAuth v2.0 to authenticate clients, you can choose [implicit](https://oauth.net/2/grant-types/implicit/) or [password](https://oauth.net/2/grant-types/password/) grant type. To obtain an OAuth `client_id` and `client_secret` contact your account executive.  **Tip**: Generate an additional login and use those credentials for your integration so that changes are accredited to that \"user\".  You are now ready to make requests to our other APIs by filling your `Authorization` header with `Bearer {access_token}`.  ## Perpetuating Access  Perpetuating access to FDC without storing your password locally can be achieved using the `refresh_token` returned by [POST /oauth/access_token](#operation/generateToken).  A simple concept to achieve this is outlined below.  1. Your application/script will ask you for your `username` and `password`, your `client_id` and `client_secret` will be accessible via a DB or ENV. 2. [Request an access_token](#operation/generateToken)   + Your function should be capable of formatting your request for both a `grant_type` of \\\"password\\\" (step 1) and \\\"refresh_token\\\" (step 4). 3. Store the `access_token` and `refresh_token` so future requests can skip step 1 4. When the `access_token` expires request anew using your `refresh_token`, replace both tokens in local storage.  + If this fails you will have to revert to step 1.  Alternatively if you choose for your application/script to have access to your `username` and `password` you can skip step 4.  In all scenarios we recommend storing all credentials outside your codebase.  ## Date Time Definitions  We will report all date-time stamps using the [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) standard. When using listing API's where fromDate and toDate are available note that both dates are inclusive while requiring the fromDate to be before or at the toDate.  ### The Fulfillment Process  Many steps are required to fulfill your order we report back to you three fundamental milestones inside the orders model.  * `recordedOn` When we received your order. This will never change.  * `dispatchDate` When the current iteration of your order was scheduled for fulfillment. This may change however it is an indicator that the physical process of fulfillment has begun and a tracking number has been **assigned** to your order. The tracking number **MAY CHANGE**. You will not be able to cancel an order once it has been dispatched. If you need to recall an order that has been dispatched please contact your account executive.  * `departDate` When we recorded your order passing our final inspection and placed with the carrier. At this point it is **safe to inform the consignee** of the tracking number as it will not change.  ## Evaluating Error Responses  We currently return two different error models, with and without context. All errors will include a `message` node while errors with `context` will include additional information designed to save you time when encountering highly probable errors. For example, when you send us a request to create a duplicate order, we will reject your request and the context will include the FDC order `id` so that you may record it for your records.  ### Without Context  New order with missing required fields.  | Header | Response | | ------ | -------- | | Status | `400 Bad Request` |  ```javascript {       \"message\": \"Invalid request body\" } ```  ### With Context  New order with duplicate `merchantOrderId`.  | Header | Response | | ------ | -------- | | Status | `409 Conflict` |  ```javascript {   \"message\": \"Duplicate Order\",   \"context\": {     \"id\": 123   } } ```  ## Status Codes  Codes are a concatenation of State, Stage, and Detail.  `^([0-9]{2})([0-9]{2})([0-9]{2})$`  | Code | State              | Stage    | Detail         | | ---- | ------------------ | -------- | -------------- | | 010101 | Processing Order | Recieved | Customer Order | | 010102 | Processing Order | Recieved | Recieved | | 010201 | Processing Order | Approved | | | 010301 | Processing Order | Hold | Merchant Stock | | 010302 | Processing Order | Hold | Merchant Funds | | 010303 | Processing Order | Hold | For Merchant | | 010304 | Processing Order | Hold | Oversized Shipment | | 010305 | Processing Order | Hold | Invalid Parent Order | | 010306 | Processing Order | Hold | Invalid Address | | 010307 | Processing Order | Hold | By Admin | | 010401 | Processing Order | Address Problem | Incomplete Address | | 010402 | Processing Order | Address Problem | Invalid Locality | | 010403 | Processing Order | Address Problem | Invalid Region | | 010404 | Processing Order | Address Problem | Address Not Found | | 010405 | Processing Order | Address Problem | Many Addresses Found | | 010406 | Processing Order | Address Problem | Invalid Postal Code | | 010407 | Processing Order | Address Problem | Country Not Mapped | | 010408 | Processing Order | Address Problem | Invalid Recipient Name | | 010409 | Processing Order | Address Problem | Bad UK Address | | 010410 | Processing Order | Address Problem | Invalid Address Line 1 or 2 | | 010501 | Processing Order | Sku Problem | Invalid SKU | | 010501 | Processing Order | Sku Problem | Child Order has Invalid SKUs | | 010601 | Processing Order | Facility Problem | Facility Not Mapped | | 010701 | Processing Order | Ship Method Problem | Unmapped Ship Method | | 010702 | Processing Order | Ship Method Problem | Unmapped Ship Cost | | 010703 | Processing Order | Ship Method Problem | Missing Ship Method | | 010704 | Processing Order | Ship Method Problem | Invalid Ship Method | | 010705 | Processing Order | Ship Method Problem | Order Weight Outside of Ship Method Weight | | 010801 | Processing Order | Inventory Problem | Insufficient Inventory In Facility | | 010802 | Processing Order | Inventory Problem | Issue Encountered During Inventory Adjustment | | 010901 | Processing Order | Released To WMS | Released | | 020101 | Fulfillment In Progress | Postage Problem | Address Issue | | 020102 | Fulfillment In Progress | Postage Problem | Postage OK, OMS Issue Occurred | | 020103 | Fulfillment In Progress | Postage Problem | Postage Void Failed | | 020201 | Fulfillment In Progress | Postage Acquired | | | 020301 | Fulfillment In Progress | Postage Voided | Postage Void Failed Gracefully | | 020301 | Fulfillment In Progress | Hold | Departure Hold Requested | | 020401 | Fulfillment In Progress | 4PL Processing | | | 020501 | Fulfillment In Progress | 4PL Problem | Order is Proccessable, Postage Issue Occurred | | 020601 | Fulfillment In Progress | Label Printed | | | 020701 | Fulfillment In Progress | Shipment Cubed | | | 020801 | Fulfillment In Progress | Picking Inventory | | | 020901 | Fulfillment In Progress | Label Print Verified | | | 021001 | Fulfillment In Progress | Passed Final Inspection | | | 030101 | Shipped | Fulfilled By 4PL | | | 030102 | Shipped | Fulfilled By 4PL | Successfully Fulfilled, OMS Encountered Issue During Processing | | 030201 | Shipped | Fulfilled By FDC | | | 040101 | Returned | Returned | | | 050101 | Cancelled | Cancelled | | | 060101 | Test | Test | Test |

This PHP package is automatically generated by the [Swagger Codegen](https://github.com/swagger-api/swagger-codegen) project:

- API version: 2.0
- Build package: io.swagger.codegen.v3.generators.php.PhpClientCodegen
For more information, please visit [https://fulfillment.com](https://fulfillment.com)

## Requirements

PHP 5.5 and later

## Installation & Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/SwaggerClient-php/vendor/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\AccessTokenRequestV2(); // \Swagger\Client\Model\AccessTokenRequestV2 | Get an access token

try {
    $result = $apiInstance->postOauthAccessToken($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->postOauthAccessToken: ', $e->getMessage(), PHP_EOL;
}
?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api.fulfillment.com/v2*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuthApi* | [**postOauthAccessToken**](docs/Api/AuthApi.md#postoauthaccesstoken) | **POST** /oauth/access_token | Generate an Access Token
*InventoryApi* | [**getInventory**](docs/Api/InventoryApi.md#getinventory) | **GET** /inventory | List of Item Inventories
*OrdersApi* | [**deleteOrdersId**](docs/Api/OrdersApi.md#deleteordersid) | **DELETE** /orders/{id} | Cancel an Order
*OrdersApi* | [**getOrder**](docs/Api/OrdersApi.md#getorder) | **GET** /orders/{id} | Order Details
*OrdersApi* | [**getOrders**](docs/Api/OrdersApi.md#getorders) | **GET** /orders | List of Orders
*OrdersApi* | [**postOrders**](docs/Api/OrdersApi.md#postorders) | **POST** /orders | New Order
*PartnersApi* | [**putOrdersIdShip**](docs/Api/PartnersApi.md#putordersidship) | **PUT** /orders/{id}/ship | Ship an Order
*PartnersApi* | [**putOrdersIdStatus**](docs/Api/PartnersApi.md#putordersidstatus) | **PUT** /orders/{id}/status | Update Order Status
*ReturnsApi* | [**getReturns**](docs/Api/ReturnsApi.md#getreturns) | **GET** /returns | List Returns
*ReturnsApi* | [**putReturns**](docs/Api/ReturnsApi.md#putreturns) | **PUT** /returns | Inform us of an RMA
*TrackingApi* | [**getTrack**](docs/Api/TrackingApi.md#gettrack) | **GET** /track | Tracking
*UsersApi* | [**getUsersMe**](docs/Api/UsersApi.md#getusersme) | **GET** /users/me | About Me

## Documentation For Models

 - [AccessTokenRequestV2](docs/Model/AccessTokenRequestV2.md)
 - [AccessTokenResponseV2](docs/Model/AccessTokenResponseV2.md)
 - [ConsigneeNewV2](docs/Model/ConsigneeNewV2.md)
 - [ConsigneeV2](docs/Model/ConsigneeV2.md)
 - [ConsigneeV21](docs/Model/ConsigneeV21.md)
 - [ErrorStandardV2](docs/Model/ErrorStandardV2.md)
 - [ErrorStandardWithContextV2](docs/Model/ErrorStandardWithContextV2.md)
 - [Feature](docs/Model/Feature.md)
 - [FeatureProperties](docs/Model/FeatureProperties.md)
 - [Geometry](docs/Model/Geometry.md)
 - [IsoCountryV2](docs/Model/IsoCountryV2.md)
 - [ItemInventoryArrayV2](docs/Model/ItemInventoryArrayV2.md)
 - [ItemInventoryArrayV2Item](docs/Model/ItemInventoryArrayV2Item.md)
 - [ItemInventoryArrayV2Merchant](docs/Model/ItemInventoryArrayV2Merchant.md)
 - [ItemInventoryArrayV2Meta](docs/Model/ItemInventoryArrayV2Meta.md)
 - [ItemInventoryArrayV2Quantity](docs/Model/ItemInventoryArrayV2Quantity.md)
 - [ItemInventoryArrayV2QuantityTotal](docs/Model/ItemInventoryArrayV2QuantityTotal.md)
 - [ItemInventoryV2](docs/Model/ItemInventoryV2.md)
 - [MerchantV2](docs/Model/MerchantV2.md)
 - [OneOfAccessTokenRequestV2](docs/Model/OneOfAccessTokenRequestV2.md)
 - [OneOfGeometryCoordinates](docs/Model/OneOfGeometryCoordinates.md)
 - [OneOfOrderResponseOneOfV2](docs/Model/OneOfOrderResponseOneOfV2.md)
 - [OrderRequestV2](docs/Model/OrderRequestV2.md)
 - [OrderResponseOneOfV2](docs/Model/OrderResponseOneOfV2.md)
 - [OrderResponseV2](docs/Model/OrderResponseV2.md)
 - [OrderResponseV2ParentOrder](docs/Model/OrderResponseV2ParentOrder.md)
 - [OrderShipV2](docs/Model/OrderShipV2.md)
 - [OrdersItems](docs/Model/OrdersItems.md)
 - [OrdersWarehouse](docs/Model/OrdersWarehouse.md)
 - [OrdersidstatusStatus](docs/Model/OrdersidstatusStatus.md)
 - [PaginationV2](docs/Model/PaginationV2.md)
 - [ReturnV2](docs/Model/ReturnV2.md)
 - [ReturnsArrayV2](docs/Model/ReturnsArrayV2.md)
 - [ReturnsArrayV2Item](docs/Model/ReturnsArrayV2Item.md)
 - [ReturnsArrayV2Meta](docs/Model/ReturnsArrayV2Meta.md)
 - [ReturnsArrayV2NonRestockedReason](docs/Model/ReturnsArrayV2NonRestockedReason.md)
 - [ReturnsArrayV2Order](docs/Model/ReturnsArrayV2Order.md)
 - [ReturnsArrayV2Status](docs/Model/ReturnsArrayV2Status.md)
 - [ReturnsItems](docs/Model/ReturnsItems.md)
 - [RmaItemV2](docs/Model/RmaItemV2.md)
 - [RmaRequestV2](docs/Model/RmaRequestV2.md)
 - [RmaResponseV2](docs/Model/RmaResponseV2.md)
 - [StatusEventV2](docs/Model/StatusEventV2.md)
 - [StatusTypeSimpleV2](docs/Model/StatusTypeSimpleV2.md)
 - [StatusTypeV2](docs/Model/StatusTypeV2.md)
 - [StatusTypeV2ActionRequiredBy](docs/Model/StatusTypeV2ActionRequiredBy.md)
 - [StatusTypeV2Stage](docs/Model/StatusTypeV2Stage.md)
 - [TrackingEventV2](docs/Model/TrackingEventV2.md)
 - [TrackingNumberV2](docs/Model/TrackingNumberV2.md)
 - [TrackingResponse](docs/Model/TrackingResponse.md)
 - [UserContactV2](docs/Model/UserContactV2.md)
 - [UserContactV21](docs/Model/UserContactV21.md)
 - [UserContactV21Merchant](docs/Model/UserContactV21Merchant.md)
 - [UserV2](docs/Model/UserV2.md)

## Documentation For Authorization


## apiKey

- **Type**: API key
- **API key parameter name**: x-api-key
- **Location**: HTTP header

## fdcAuth

- **Type**: OAuth
- **Flow**: password
- **Authorization URL**: 
- **Scopes**: 
 - ****: 


## Author

dev@fulfillment.com

