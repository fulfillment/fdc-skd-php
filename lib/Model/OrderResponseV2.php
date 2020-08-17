<?php
/**
 * OrderResponseV2
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Fulfillment.com APIv2
 *
 * Welcome to our current iteration of our REST API. While we encourage you to upgrade to v2.0 we will continue support for our [SOAP API](https://github.com/fulfillment/soap-integration).  # Versioning  The Fulfillment.com (FDC) REST API is version controlled and backwards compatible. We have many future APIs scheduled for publication within our v2.0 spec so please be prepared for us to add data nodes in our responses, however, we will not remove knowledge from previously published APIs.  #### A Current Response  ```javascript {   id: 123 } ```  #### A Potential Future Response  ```javascript {   id: 123,   reason: \"More Knowledge\" } ```  # Getting Started  We use OAuth v2.0 to authenticate clients, you can choose [implicit](https://oauth.net/2/grant-types/implicit/) or [password](https://oauth.net/2/grant-types/password/) grant type. To obtain an OAuth `client_id` and `client_secret` contact your account executive.  **Tip**: Generate an additional login and use those credentials for your integration so that changes are accredited to that \"user\".  You are now ready to make requests to our other APIs by filling your `Authorization` header with `Bearer {access_token}`.  ## Perpetuating Access  Perpetuating access to FDC without storing your password locally can be achieved using the `refresh_token` returned by [POST /oauth/access_token](#operation/generateToken).  A simple concept to achieve this is outlined below.  1. Your application/script will ask you for your `username` and `password`, your `client_id` and `client_secret` will be accessible via a DB or ENV. 2. [Request an access_token](#operation/generateToken)   + Your function should be capable of formatting your request for both a `grant_type` of \\\"password\\\" (step 1) and \\\"refresh_token\\\" (step 4). 3. Store the `access_token` and `refresh_token` so future requests can skip step 1 4. When the `access_token` expires request anew using your `refresh_token`, replace both tokens in local storage.  + If this fails you will have to revert to step 1.  Alternatively if you choose for your application/script to have access to your `username` and `password` you can skip step 4.  In all scenarios we recommend storing all credentials outside your codebase.  ## Date Time Definitions  We will report all date-time stamps using the [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) standard. When using listing API's where fromDate and toDate are available note that both dates are inclusive while requiring the fromDate to be before or at the toDate.  ### The Fulfillment Process  Many steps are required to fulfill your order we report back to you three fundamental milestones inside the orders model.  * `recordedOn` When we received your order. This will never change.  * `dispatchDate` When the current iteration of your order was scheduled for fulfillment. This may change however it is an indicator that the physical process of fulfillment has begun and a tracking number has been **assigned** to your order. The tracking number **MAY CHANGE**. You will not be able to cancel an order once it has been dispatched. If you need to recall an order that has been dispatched please contact your account executive.  * `departDate` When we recorded your order passing our final inspection and placed with the carrier. At this point it is **safe to inform the consignee** of the tracking number as it will not change.  ## Evaluating Error Responses  We currently return two different error models, with and without context. All errors will include a `message` node while errors with `context` will include additional information designed to save you time when encountering highly probable errors. For example, when you send us a request to create a duplicate order, we will reject your request and the context will include the FDC order `id` so that you may record it for your records.  ### Without Context  New order with missing required fields.  | Header | Response | | ------ | -------- | | Status | `400 Bad Request` |  ```javascript {       \"message\": \"Invalid request body\" } ```  ### With Context  New order with duplicate `merchantOrderId`.  | Header | Response | | ------ | -------- | | Status | `409 Conflict` |  ```javascript {   \"message\": \"Duplicate Order\",   \"context\": {     \"id\": 123   } } ```  ## Status Codes  Codes are a concatenation of State, Stage, and Detail.  `^([0-9]{2})([0-9]{2})([0-9]{2})$`  | Code | State              | Stage    | Detail         | | ---- | ------------------ | -------- | -------------- | | 010101 | Processing Order | Recieved | Customer Order | | 010102 | Processing Order | Recieved | Recieved | | 010201 | Processing Order | Approved | | | 010301 | Processing Order | Hold | Merchant Stock | | 010302 | Processing Order | Hold | Merchant Funds | | 010303 | Processing Order | Hold | For Merchant | | 010304 | Processing Order | Hold | Oversized Shipment | | 010305 | Processing Order | Hold | Invalid Parent Order | | 010306 | Processing Order | Hold | Invalid Address | | 010307 | Processing Order | Hold | By Admin | | 010401 | Processing Order | Address Problem | Incomplete Address | | 010402 | Processing Order | Address Problem | Invalid Locality | | 010403 | Processing Order | Address Problem | Invalid Region | | 010404 | Processing Order | Address Problem | Address Not Found | | 010405 | Processing Order | Address Problem | Many Addresses Found | | 010406 | Processing Order | Address Problem | Invalid Postal Code | | 010407 | Processing Order | Address Problem | Country Not Mapped | | 010408 | Processing Order | Address Problem | Invalid Recipient Name | | 010409 | Processing Order | Address Problem | Bad UK Address | | 010410 | Processing Order | Address Problem | Invalid Address Line 1 or 2 | | 010501 | Processing Order | Sku Problem | Invalid SKU | | 010501 | Processing Order | Sku Problem | Child Order has Invalid SKUs | | 010601 | Processing Order | Facility Problem | Facility Not Mapped | | 010701 | Processing Order | Ship Method Problem | Unmapped Ship Method | | 010702 | Processing Order | Ship Method Problem | Unmapped Ship Cost | | 010703 | Processing Order | Ship Method Problem | Missing Ship Method | | 010704 | Processing Order | Ship Method Problem | Invalid Ship Method | | 010705 | Processing Order | Ship Method Problem | Order Weight Outside of Ship Method Weight | | 010801 | Processing Order | Inventory Problem | Insufficient Inventory In Facility | | 010802 | Processing Order | Inventory Problem | Issue Encountered During Inventory Adjustment | | 010901 | Processing Order | Released To WMS | Released | | 020101 | Fulfillment In Progress | Postage Problem | Address Issue | | 020102 | Fulfillment In Progress | Postage Problem | Postage OK, OMS Issue Occurred | | 020103 | Fulfillment In Progress | Postage Problem | Postage Void Failed | | 020201 | Fulfillment In Progress | Postage Acquired | | | 020301 | Fulfillment In Progress | Postage Voided | Postage Void Failed Gracefully | | 020301 | Fulfillment In Progress | Hold | Departure Hold Requested | | 020401 | Fulfillment In Progress | 4PL Processing | | | 020501 | Fulfillment In Progress | 4PL Problem | Order is Proccessable, Postage Issue Occurred | | 020601 | Fulfillment In Progress | Label Printed | | | 020701 | Fulfillment In Progress | Shipment Cubed | | | 020801 | Fulfillment In Progress | Picking Inventory | | | 020901 | Fulfillment In Progress | Label Print Verified | | | 021001 | Fulfillment In Progress | Passed Final Inspection | | | 030101 | Shipped | Fulfilled By 4PL | | | 030102 | Shipped | Fulfilled By 4PL | Successfully Fulfilled, OMS Encountered Issue During Processing | | 030201 | Shipped | Fulfilled By FDC | | | 040101 | Returned | Returned | | | 050101 | Cancelled | Cancelled | | | 060101 | Test | Test | Test |
 *
 * OpenAPI spec version: 2.0
 * Contact: dev@fulfillment.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.21
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * OrderResponseV2 Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class OrderResponseV2 implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'OrderResponse.v2';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'int',
'tracking_numbers' => '\Swagger\Client\Model\TrackingNumberV2[]',
'validated_consignee' => '\Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchemaPropertiesOriginalConsignee',
'original_consignee' => '\Swagger\Client\Model\ConsigneeV21',
'current_status' => '\Swagger\Client\Model\StatusEventV2',
'warehouse' => '\Swagger\Client\Model\UserV2',
'merchant' => '\Swagger\Client\Model\MerchantV2',
'depart_date' => '\DateTime',
'dispatch_date' => '\DateTime',
'recorded_on' => '\DateTime',
'merchant_shipping_method' => 'string',
'purchase_order_num' => 'string',
'merchant_order_id' => 'string',
'parent_order' => '\Swagger\Client\Model\OrderResponseV2ParentOrder'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
'tracking_numbers' => null,
'validated_consignee' => null,
'original_consignee' => null,
'current_status' => null,
'warehouse' => null,
'merchant' => null,
'depart_date' => 'date-time',
'dispatch_date' => 'date-time',
'recorded_on' => 'date-time',
'merchant_shipping_method' => null,
'purchase_order_num' => null,
'merchant_order_id' => null,
'parent_order' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
'tracking_numbers' => 'trackingNumbers',
'validated_consignee' => 'validatedConsignee',
'original_consignee' => 'originalConsignee',
'current_status' => 'currentStatus',
'warehouse' => 'warehouse',
'merchant' => 'merchant',
'depart_date' => 'departDate',
'dispatch_date' => 'dispatchDate',
'recorded_on' => 'recordedOn',
'merchant_shipping_method' => 'merchantShippingMethod',
'purchase_order_num' => 'purchaseOrderNum',
'merchant_order_id' => 'merchantOrderId',
'parent_order' => 'parentOrder'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
'tracking_numbers' => 'setTrackingNumbers',
'validated_consignee' => 'setValidatedConsignee',
'original_consignee' => 'setOriginalConsignee',
'current_status' => 'setCurrentStatus',
'warehouse' => 'setWarehouse',
'merchant' => 'setMerchant',
'depart_date' => 'setDepartDate',
'dispatch_date' => 'setDispatchDate',
'recorded_on' => 'setRecordedOn',
'merchant_shipping_method' => 'setMerchantShippingMethod',
'purchase_order_num' => 'setPurchaseOrderNum',
'merchant_order_id' => 'setMerchantOrderId',
'parent_order' => 'setParentOrder'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
'tracking_numbers' => 'getTrackingNumbers',
'validated_consignee' => 'getValidatedConsignee',
'original_consignee' => 'getOriginalConsignee',
'current_status' => 'getCurrentStatus',
'warehouse' => 'getWarehouse',
'merchant' => 'getMerchant',
'depart_date' => 'getDepartDate',
'dispatch_date' => 'getDispatchDate',
'recorded_on' => 'getRecordedOn',
'merchant_shipping_method' => 'getMerchantShippingMethod',
'purchase_order_num' => 'getPurchaseOrderNum',
'merchant_order_id' => 'getMerchantOrderId',
'parent_order' => 'getParentOrder'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['tracking_numbers'] = isset($data['tracking_numbers']) ? $data['tracking_numbers'] : null;
        $this->container['validated_consignee'] = isset($data['validated_consignee']) ? $data['validated_consignee'] : null;
        $this->container['original_consignee'] = isset($data['original_consignee']) ? $data['original_consignee'] : null;
        $this->container['current_status'] = isset($data['current_status']) ? $data['current_status'] : null;
        $this->container['warehouse'] = isset($data['warehouse']) ? $data['warehouse'] : null;
        $this->container['merchant'] = isset($data['merchant']) ? $data['merchant'] : null;
        $this->container['depart_date'] = isset($data['depart_date']) ? $data['depart_date'] : null;
        $this->container['dispatch_date'] = isset($data['dispatch_date']) ? $data['dispatch_date'] : null;
        $this->container['recorded_on'] = isset($data['recorded_on']) ? $data['recorded_on'] : null;
        $this->container['merchant_shipping_method'] = isset($data['merchant_shipping_method']) ? $data['merchant_shipping_method'] : null;
        $this->container['purchase_order_num'] = isset($data['purchase_order_num']) ? $data['purchase_order_num'] : null;
        $this->container['merchant_order_id'] = isset($data['merchant_order_id']) ? $data['merchant_order_id'] : null;
        $this->container['parent_order'] = isset($data['parent_order']) ? $data['parent_order'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['id'] === null) {
            $invalidProperties[] = "'id' can't be null";
        }
        if ($this->container['validated_consignee'] === null) {
            $invalidProperties[] = "'validated_consignee' can't be null";
        }
        if ($this->container['original_consignee'] === null) {
            $invalidProperties[] = "'original_consignee' can't be null";
        }
        if ($this->container['current_status'] === null) {
            $invalidProperties[] = "'current_status' can't be null";
        }
        if ($this->container['merchant'] === null) {
            $invalidProperties[] = "'merchant' can't be null";
        }
        if ($this->container['recorded_on'] === null) {
            $invalidProperties[] = "'recorded_on' can't be null";
        }
        if ($this->container['merchant_shipping_method'] === null) {
            $invalidProperties[] = "'merchant_shipping_method' can't be null";
        }
        if ($this->container['merchant_order_id'] === null) {
            $invalidProperties[] = "'merchant_order_id' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int $id FDC ID for this order
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets tracking_numbers
     *
     * @return \Swagger\Client\Model\TrackingNumberV2[]
     */
    public function getTrackingNumbers()
    {
        return $this->container['tracking_numbers'];
    }

    /**
     * Sets tracking_numbers
     *
     * @param \Swagger\Client\Model\TrackingNumberV2[] $tracking_numbers tracking_numbers
     *
     * @return $this
     */
    public function setTrackingNumbers($tracking_numbers)
    {
        $this->container['tracking_numbers'] = $tracking_numbers;

        return $this;
    }

    /**
     * Gets validated_consignee
     *
     * @return \Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchemaPropertiesOriginalConsignee
     */
    public function getValidatedConsignee()
    {
        return $this->container['validated_consignee'];
    }

    /**
     * Sets validated_consignee
     *
     * @param \Swagger\Client\Model\Paths1ordersPostResponses201ContentApplication1jsonSchemaPropertiesOriginalConsignee $validated_consignee validated_consignee
     *
     * @return $this
     */
    public function setValidatedConsignee($validated_consignee)
    {
        $this->container['validated_consignee'] = $validated_consignee;

        return $this;
    }

    /**
     * Gets original_consignee
     *
     * @return \Swagger\Client\Model\ConsigneeV21
     */
    public function getOriginalConsignee()
    {
        return $this->container['original_consignee'];
    }

    /**
     * Sets original_consignee
     *
     * @param \Swagger\Client\Model\ConsigneeV21 $original_consignee original_consignee
     *
     * @return $this
     */
    public function setOriginalConsignee($original_consignee)
    {
        $this->container['original_consignee'] = $original_consignee;

        return $this;
    }

    /**
     * Gets current_status
     *
     * @return \Swagger\Client\Model\StatusEventV2
     */
    public function getCurrentStatus()
    {
        return $this->container['current_status'];
    }

    /**
     * Sets current_status
     *
     * @param \Swagger\Client\Model\StatusEventV2 $current_status current_status
     *
     * @return $this
     */
    public function setCurrentStatus($current_status)
    {
        $this->container['current_status'] = $current_status;

        return $this;
    }

    /**
     * Gets warehouse
     *
     * @return \Swagger\Client\Model\UserV2
     */
    public function getWarehouse()
    {
        return $this->container['warehouse'];
    }

    /**
     * Sets warehouse
     *
     * @param \Swagger\Client\Model\UserV2 $warehouse warehouse
     *
     * @return $this
     */
    public function setWarehouse($warehouse)
    {
        $this->container['warehouse'] = $warehouse;

        return $this;
    }

    /**
     * Gets merchant
     *
     * @return \Swagger\Client\Model\MerchantV2
     */
    public function getMerchant()
    {
        return $this->container['merchant'];
    }

    /**
     * Sets merchant
     *
     * @param \Swagger\Client\Model\MerchantV2 $merchant merchant
     *
     * @return $this
     */
    public function setMerchant($merchant)
    {
        $this->container['merchant'] = $merchant;

        return $this;
    }

    /**
     * Gets depart_date
     *
     * @return \DateTime
     */
    public function getDepartDate()
    {
        return $this->container['depart_date'];
    }

    /**
     * Sets depart_date
     *
     * @param \DateTime $depart_date DateTime order departed an FDC warehouse
     *
     * @return $this
     */
    public function setDepartDate($depart_date)
    {
        $this->container['depart_date'] = $depart_date;

        return $this;
    }

    /**
     * Gets dispatch_date
     *
     * @return \DateTime
     */
    public function getDispatchDate()
    {
        return $this->container['dispatch_date'];
    }

    /**
     * Sets dispatch_date
     *
     * @param \DateTime $dispatch_date DateTime order was dispatched for fulfillment by FDC
     *
     * @return $this
     */
    public function setDispatchDate($dispatch_date)
    {
        $this->container['dispatch_date'] = $dispatch_date;

        return $this;
    }

    /**
     * Gets recorded_on
     *
     * @return \DateTime
     */
    public function getRecordedOn()
    {
        return $this->container['recorded_on'];
    }

    /**
     * Sets recorded_on
     *
     * @param \DateTime $recorded_on DateTime order was recorded by FDC
     *
     * @return $this
     */
    public function setRecordedOn($recorded_on)
    {
        $this->container['recorded_on'] = $recorded_on;

        return $this;
    }

    /**
     * Gets merchant_shipping_method
     *
     * @return string
     */
    public function getMerchantShippingMethod()
    {
        return $this->container['merchant_shipping_method'];
    }

    /**
     * Sets merchant_shipping_method
     *
     * @param string $merchant_shipping_method Requested ship method
     *
     * @return $this
     */
    public function setMerchantShippingMethod($merchant_shipping_method)
    {
        $this->container['merchant_shipping_method'] = $merchant_shipping_method;

        return $this;
    }

    /**
     * Gets purchase_order_num
     *
     * @return string
     */
    public function getPurchaseOrderNum()
    {
        return $this->container['purchase_order_num'];
    }

    /**
     * Sets purchase_order_num
     *
     * @param string $purchase_order_num Merchant provided PO#
     *
     * @return $this
     */
    public function setPurchaseOrderNum($purchase_order_num)
    {
        $this->container['purchase_order_num'] = $purchase_order_num;

        return $this;
    }

    /**
     * Gets merchant_order_id
     *
     * @return string
     */
    public function getMerchantOrderId()
    {
        return $this->container['merchant_order_id'];
    }

    /**
     * Sets merchant_order_id
     *
     * @param string $merchant_order_id Merchant provided ID
     *
     * @return $this
     */
    public function setMerchantOrderId($merchant_order_id)
    {
        $this->container['merchant_order_id'] = $merchant_order_id;

        return $this;
    }

    /**
     * Gets parent_order
     *
     * @return \Swagger\Client\Model\OrderResponseV2ParentOrder
     */
    public function getParentOrder()
    {
        return $this->container['parent_order'];
    }

    /**
     * Sets parent_order
     *
     * @param \Swagger\Client\Model\OrderResponseV2ParentOrder $parent_order parent_order
     *
     * @return $this
     */
    public function setParentOrder($parent_order)
    {
        $this->container['parent_order'] = $parent_order;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
