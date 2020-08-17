<?php
/**
 * TrackingResponse
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
 * TrackingResponse Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class TrackingResponse implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'trackingResponse';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'tracked_events' => '\Swagger\Client\Model\TrackingEventV2[]',
'fdc_order_id' => 'int',
'first_transit_event' => '\DateTime',
'last_updated_date_time' => '\DateTime',
'last_checked_date_time' => '\DateTime',
'first_checked_date_time' => '\DateTime',
'status_message' => 'string',
'status_category_code' => 'int',
'status_date_time' => '\DateTime',
'status' => 'string',
'destination' => '\Swagger\Client\Model\Paths1trackGetResponses200ContentApplication1jsonSchemaPropertiesOrigin',
'origin' => '\Swagger\Client\Model\Feature',
'tracking_number' => '\Swagger\Client\Model\TrackingNumberV2'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'tracked_events' => null,
'fdc_order_id' => null,
'first_transit_event' => 'date-time',
'last_updated_date_time' => 'date-time',
'last_checked_date_time' => 'date-time',
'first_checked_date_time' => 'date-time',
'status_message' => null,
'status_category_code' => null,
'status_date_time' => 'date-time',
'status' => null,
'destination' => null,
'origin' => null,
'tracking_number' => null    ];

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
        'tracked_events' => 'trackedEvents',
'fdc_order_id' => 'fdcOrderId',
'first_transit_event' => 'firstTransitEvent',
'last_updated_date_time' => 'lastUpdatedDateTime',
'last_checked_date_time' => 'lastCheckedDateTime',
'first_checked_date_time' => 'firstCheckedDateTime',
'status_message' => 'statusMessage',
'status_category_code' => 'statusCategoryCode',
'status_date_time' => 'statusDateTime',
'status' => 'status',
'destination' => 'destination',
'origin' => 'origin',
'tracking_number' => 'trackingNumber'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'tracked_events' => 'setTrackedEvents',
'fdc_order_id' => 'setFdcOrderId',
'first_transit_event' => 'setFirstTransitEvent',
'last_updated_date_time' => 'setLastUpdatedDateTime',
'last_checked_date_time' => 'setLastCheckedDateTime',
'first_checked_date_time' => 'setFirstCheckedDateTime',
'status_message' => 'setStatusMessage',
'status_category_code' => 'setStatusCategoryCode',
'status_date_time' => 'setStatusDateTime',
'status' => 'setStatus',
'destination' => 'setDestination',
'origin' => 'setOrigin',
'tracking_number' => 'setTrackingNumber'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'tracked_events' => 'getTrackedEvents',
'fdc_order_id' => 'getFdcOrderId',
'first_transit_event' => 'getFirstTransitEvent',
'last_updated_date_time' => 'getLastUpdatedDateTime',
'last_checked_date_time' => 'getLastCheckedDateTime',
'first_checked_date_time' => 'getFirstCheckedDateTime',
'status_message' => 'getStatusMessage',
'status_category_code' => 'getStatusCategoryCode',
'status_date_time' => 'getStatusDateTime',
'status' => 'getStatus',
'destination' => 'getDestination',
'origin' => 'getOrigin',
'tracking_number' => 'getTrackingNumber'    ];

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
        $this->container['tracked_events'] = isset($data['tracked_events']) ? $data['tracked_events'] : null;
        $this->container['fdc_order_id'] = isset($data['fdc_order_id']) ? $data['fdc_order_id'] : null;
        $this->container['first_transit_event'] = isset($data['first_transit_event']) ? $data['first_transit_event'] : null;
        $this->container['last_updated_date_time'] = isset($data['last_updated_date_time']) ? $data['last_updated_date_time'] : null;
        $this->container['last_checked_date_time'] = isset($data['last_checked_date_time']) ? $data['last_checked_date_time'] : null;
        $this->container['first_checked_date_time'] = isset($data['first_checked_date_time']) ? $data['first_checked_date_time'] : null;
        $this->container['status_message'] = isset($data['status_message']) ? $data['status_message'] : null;
        $this->container['status_category_code'] = isset($data['status_category_code']) ? $data['status_category_code'] : null;
        $this->container['status_date_time'] = isset($data['status_date_time']) ? $data['status_date_time'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : null;
        $this->container['destination'] = isset($data['destination']) ? $data['destination'] : null;
        $this->container['origin'] = isset($data['origin']) ? $data['origin'] : null;
        $this->container['tracking_number'] = isset($data['tracking_number']) ? $data['tracking_number'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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
     * Gets tracked_events
     *
     * @return \Swagger\Client\Model\TrackingEventV2[]
     */
    public function getTrackedEvents()
    {
        return $this->container['tracked_events'];
    }

    /**
     * Sets tracked_events
     *
     * @param \Swagger\Client\Model\TrackingEventV2[] $tracked_events tracked_events
     *
     * @return $this
     */
    public function setTrackedEvents($tracked_events)
    {
        $this->container['tracked_events'] = $tracked_events;

        return $this;
    }

    /**
     * Gets fdc_order_id
     *
     * @return int
     */
    public function getFdcOrderId()
    {
        return $this->container['fdc_order_id'];
    }

    /**
     * Sets fdc_order_id
     *
     * @param int $fdc_order_id fdc_order_id
     *
     * @return $this
     */
    public function setFdcOrderId($fdc_order_id)
    {
        $this->container['fdc_order_id'] = $fdc_order_id;

        return $this;
    }

    /**
     * Gets first_transit_event
     *
     * @return \DateTime
     */
    public function getFirstTransitEvent()
    {
        return $this->container['first_transit_event'];
    }

    /**
     * Sets first_transit_event
     *
     * @param \DateTime $first_transit_event first_transit_event
     *
     * @return $this
     */
    public function setFirstTransitEvent($first_transit_event)
    {
        $this->container['first_transit_event'] = $first_transit_event;

        return $this;
    }

    /**
     * Gets last_updated_date_time
     *
     * @return \DateTime
     */
    public function getLastUpdatedDateTime()
    {
        return $this->container['last_updated_date_time'];
    }

    /**
     * Sets last_updated_date_time
     *
     * @param \DateTime $last_updated_date_time last_updated_date_time
     *
     * @return $this
     */
    public function setLastUpdatedDateTime($last_updated_date_time)
    {
        $this->container['last_updated_date_time'] = $last_updated_date_time;

        return $this;
    }

    /**
     * Gets last_checked_date_time
     *
     * @return \DateTime
     */
    public function getLastCheckedDateTime()
    {
        return $this->container['last_checked_date_time'];
    }

    /**
     * Sets last_checked_date_time
     *
     * @param \DateTime $last_checked_date_time last_checked_date_time
     *
     * @return $this
     */
    public function setLastCheckedDateTime($last_checked_date_time)
    {
        $this->container['last_checked_date_time'] = $last_checked_date_time;

        return $this;
    }

    /**
     * Gets first_checked_date_time
     *
     * @return \DateTime
     */
    public function getFirstCheckedDateTime()
    {
        return $this->container['first_checked_date_time'];
    }

    /**
     * Sets first_checked_date_time
     *
     * @param \DateTime $first_checked_date_time first_checked_date_time
     *
     * @return $this
     */
    public function setFirstCheckedDateTime($first_checked_date_time)
    {
        $this->container['first_checked_date_time'] = $first_checked_date_time;

        return $this;
    }

    /**
     * Gets status_message
     *
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->container['status_message'];
    }

    /**
     * Sets status_message
     *
     * @param string $status_message status_message
     *
     * @return $this
     */
    public function setStatusMessage($status_message)
    {
        $this->container['status_message'] = $status_message;

        return $this;
    }

    /**
     * Gets status_category_code
     *
     * @return int
     */
    public function getStatusCategoryCode()
    {
        return $this->container['status_category_code'];
    }

    /**
     * Sets status_category_code
     *
     * @param int $status_category_code status_category_code
     *
     * @return $this
     */
    public function setStatusCategoryCode($status_category_code)
    {
        $this->container['status_category_code'] = $status_category_code;

        return $this;
    }

    /**
     * Gets status_date_time
     *
     * @return \DateTime
     */
    public function getStatusDateTime()
    {
        return $this->container['status_date_time'];
    }

    /**
     * Sets status_date_time
     *
     * @param \DateTime $status_date_time status_date_time
     *
     * @return $this
     */
    public function setStatusDateTime($status_date_time)
    {
        $this->container['status_date_time'] = $status_date_time;

        return $this;
    }

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param string $status status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets destination
     *
     * @return \Swagger\Client\Model\Paths1trackGetResponses200ContentApplication1jsonSchemaPropertiesOrigin
     */
    public function getDestination()
    {
        return $this->container['destination'];
    }

    /**
     * Sets destination
     *
     * @param \Swagger\Client\Model\Paths1trackGetResponses200ContentApplication1jsonSchemaPropertiesOrigin $destination destination
     *
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->container['destination'] = $destination;

        return $this;
    }

    /**
     * Gets origin
     *
     * @return \Swagger\Client\Model\Feature
     */
    public function getOrigin()
    {
        return $this->container['origin'];
    }

    /**
     * Sets origin
     *
     * @param \Swagger\Client\Model\Feature $origin origin
     *
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->container['origin'] = $origin;

        return $this;
    }

    /**
     * Gets tracking_number
     *
     * @return \Swagger\Client\Model\TrackingNumberV2
     */
    public function getTrackingNumber()
    {
        return $this->container['tracking_number'];
    }

    /**
     * Sets tracking_number
     *
     * @param \Swagger\Client\Model\TrackingNumberV2 $tracking_number tracking_number
     *
     * @return $this
     */
    public function setTrackingNumber($tracking_number)
    {
        $this->container['tracking_number'] = $tracking_number;

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
