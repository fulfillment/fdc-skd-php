<?php
/**
 * OrderRequestV2
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
 * OrderRequestV2 Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class OrderRequestV2 implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'OrderRequest.v2';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'merchant_id' => 'int',
'merchant_order_id' => 'string',
'shipping_method' => 'string',
'recipient' => '\Swagger\Client\Model\ConsigneeNewV2',
'items' => '\Swagger\Client\Model\OrdersItems[]',
'warehouse' => '\Swagger\Client\Model\OrdersWarehouse',
'integrator' => 'string',
'notes' => 'string'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'merchant_id' => null,
'merchant_order_id' => null,
'shipping_method' => null,
'recipient' => null,
'items' => null,
'warehouse' => null,
'integrator' => null,
'notes' => null    ];

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
        'merchant_id' => 'merchantId',
'merchant_order_id' => 'merchantOrderId',
'shipping_method' => 'shippingMethod',
'recipient' => 'recipient',
'items' => 'items',
'warehouse' => 'warehouse',
'integrator' => 'integrator',
'notes' => 'notes'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'merchant_id' => 'setMerchantId',
'merchant_order_id' => 'setMerchantOrderId',
'shipping_method' => 'setShippingMethod',
'recipient' => 'setRecipient',
'items' => 'setItems',
'warehouse' => 'setWarehouse',
'integrator' => 'setIntegrator',
'notes' => 'setNotes'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'merchant_id' => 'getMerchantId',
'merchant_order_id' => 'getMerchantOrderId',
'shipping_method' => 'getShippingMethod',
'recipient' => 'getRecipient',
'items' => 'getItems',
'warehouse' => 'getWarehouse',
'integrator' => 'getIntegrator',
'notes' => 'getNotes'    ];

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

    const INTEGRATOR__1_SHOPPING_CART = '1ShoppingCart';
const INTEGRATOR__3D_CART = '3dCart';
const INTEGRATOR_ADOBE_BC = 'AdobeBC';
const INTEGRATOR_AMAZON_AU = 'AmazonAU';
const INTEGRATOR_AMAZON_EU = 'AmazonEU';
const INTEGRATOR_AMAZON_NA = 'AmazonNA';
const INTEGRATOR_BIG_COMMERCE = 'BigCommerce';
const INTEGRATOR_BRAND_BOOM = 'BrandBoom';
const INTEGRATOR_BRIGHT_PEARL = 'BrightPearl';
const INTEGRATOR_BUY_GOODS = 'BuyGoods';
const INTEGRATOR_CELERY = 'Celery';
const INTEGRATOR_CHANNEL_ADVISOR = 'ChannelAdvisor';
const INTEGRATOR_CLICKBANK = 'Clickbank';
const INTEGRATOR_COMMERCE_HUB = 'CommerceHub';
const INTEGRATOR_CUSTOM = 'Custom';
const INTEGRATOR_DEMANDWARE = 'Demandware';
const INTEGRATOR_EBAY = 'Ebay';
const INTEGRATOR_ECWID = 'Ecwid';
const INTEGRATOR_ETSY = 'Etsy';
const INTEGRATOR_FOXY_CART = 'FoxyCart';
const INTEGRATOR_GOODSIE = 'Goodsie';
const INTEGRATOR_INFUSIONSOFT = 'Infusionsoft';
const INTEGRATOR_KONNEKTIVE = 'Konnektive';
const INTEGRATOR_LIME_LIGHT = 'LimeLight';
const INTEGRATOR_LINIO = 'Linio';
const INTEGRATOR_LINNWORKS = 'Linnworks';
const INTEGRATOR_MAGENTO = 'Magento';
const INTEGRATOR_NETSUITE = 'Netsuite';
const INTEGRATOR_NEW_EGG = 'NewEgg';
const INTEGRATOR_NEXTERNAL = 'Nexternal';
const INTEGRATOR_NU_ORDER = 'NuOrder';
const INTEGRATOR_OPENCART = 'Opencart';
const INTEGRATOR_ORDER_WAVE = 'OrderWave';
const INTEGRATOR_OS_COMMERCE1 = 'osCommerce1';
const INTEGRATOR_OVERSTOCK = 'Overstock';
const INTEGRATOR_PAY_PAL = 'PayPal';
const INTEGRATOR_PRESTA_SHOP = 'PrestaShop';
const INTEGRATOR_PRICEFALLS = 'Pricefalls';
const INTEGRATOR_QUICKBOOKS = 'Quickbooks';
const INTEGRATOR_RAKUTEN = 'Rakuten';
const INTEGRATOR_SEARS = 'Sears';
const INTEGRATOR_SELLBRITE = 'Sellbrite';
const INTEGRATOR_SELLER_CLOUD = 'SellerCloud';
const INTEGRATOR_SHIPSTATION = 'Shipstation';
const INTEGRATOR_SHOPIFY = 'Shopify';
const INTEGRATOR_SKUBANA = 'Skubana';
const INTEGRATOR_SOLID_COMMERCE = 'SolidCommerce';
const INTEGRATOR_SPARK_PAY = 'SparkPay';
const INTEGRATOR_SPREE_COMMERCE = 'SpreeCommerce';
const INTEGRATOR_SPS_COMMERCE = 'spsCommerce';
const INTEGRATOR_STITCH_LABS = 'StitchLabs';
const INTEGRATOR_STONE_EDGE = 'StoneEdge';
const INTEGRATOR_TRADE_GECKO = 'TradeGecko';
const INTEGRATOR_ULTRA_CART = 'UltraCart';
const INTEGRATOR_VOLUSION = 'Volusion';
const INTEGRATOR_VTEX = 'VTEX';
const INTEGRATOR_WALMART = 'Walmart';
const INTEGRATOR_WOO_COMMERCE = 'WooCommerce';
const INTEGRATOR_YAHOO = 'Yahoo';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getIntegratorAllowableValues()
    {
        return [
            self::INTEGRATOR__1_SHOPPING_CART,
self::INTEGRATOR__3D_CART,
self::INTEGRATOR_ADOBE_BC,
self::INTEGRATOR_AMAZON_AU,
self::INTEGRATOR_AMAZON_EU,
self::INTEGRATOR_AMAZON_NA,
self::INTEGRATOR_BIG_COMMERCE,
self::INTEGRATOR_BRAND_BOOM,
self::INTEGRATOR_BRIGHT_PEARL,
self::INTEGRATOR_BUY_GOODS,
self::INTEGRATOR_CELERY,
self::INTEGRATOR_CHANNEL_ADVISOR,
self::INTEGRATOR_CLICKBANK,
self::INTEGRATOR_COMMERCE_HUB,
self::INTEGRATOR_CUSTOM,
self::INTEGRATOR_DEMANDWARE,
self::INTEGRATOR_EBAY,
self::INTEGRATOR_ECWID,
self::INTEGRATOR_ETSY,
self::INTEGRATOR_FOXY_CART,
self::INTEGRATOR_GOODSIE,
self::INTEGRATOR_INFUSIONSOFT,
self::INTEGRATOR_KONNEKTIVE,
self::INTEGRATOR_LIME_LIGHT,
self::INTEGRATOR_LINIO,
self::INTEGRATOR_LINNWORKS,
self::INTEGRATOR_MAGENTO,
self::INTEGRATOR_NETSUITE,
self::INTEGRATOR_NEW_EGG,
self::INTEGRATOR_NEXTERNAL,
self::INTEGRATOR_NU_ORDER,
self::INTEGRATOR_OPENCART,
self::INTEGRATOR_ORDER_WAVE,
self::INTEGRATOR_OS_COMMERCE1,
self::INTEGRATOR_OVERSTOCK,
self::INTEGRATOR_PAY_PAL,
self::INTEGRATOR_PRESTA_SHOP,
self::INTEGRATOR_PRICEFALLS,
self::INTEGRATOR_QUICKBOOKS,
self::INTEGRATOR_RAKUTEN,
self::INTEGRATOR_SEARS,
self::INTEGRATOR_SELLBRITE,
self::INTEGRATOR_SELLER_CLOUD,
self::INTEGRATOR_SHIPSTATION,
self::INTEGRATOR_SHOPIFY,
self::INTEGRATOR_SKUBANA,
self::INTEGRATOR_SOLID_COMMERCE,
self::INTEGRATOR_SPARK_PAY,
self::INTEGRATOR_SPREE_COMMERCE,
self::INTEGRATOR_SPS_COMMERCE,
self::INTEGRATOR_STITCH_LABS,
self::INTEGRATOR_STONE_EDGE,
self::INTEGRATOR_TRADE_GECKO,
self::INTEGRATOR_ULTRA_CART,
self::INTEGRATOR_VOLUSION,
self::INTEGRATOR_VTEX,
self::INTEGRATOR_WALMART,
self::INTEGRATOR_WOO_COMMERCE,
self::INTEGRATOR_YAHOO,        ];
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
        $this->container['merchant_id'] = isset($data['merchant_id']) ? $data['merchant_id'] : null;
        $this->container['merchant_order_id'] = isset($data['merchant_order_id']) ? $data['merchant_order_id'] : null;
        $this->container['shipping_method'] = isset($data['shipping_method']) ? $data['shipping_method'] : null;
        $this->container['recipient'] = isset($data['recipient']) ? $data['recipient'] : null;
        $this->container['items'] = isset($data['items']) ? $data['items'] : null;
        $this->container['warehouse'] = isset($data['warehouse']) ? $data['warehouse'] : null;
        $this->container['integrator'] = isset($data['integrator']) ? $data['integrator'] : null;
        $this->container['notes'] = isset($data['notes']) ? $data['notes'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['merchant_order_id'] === null) {
            $invalidProperties[] = "'merchant_order_id' can't be null";
        }
        if ($this->container['shipping_method'] === null) {
            $invalidProperties[] = "'shipping_method' can't be null";
        }
        if ($this->container['recipient'] === null) {
            $invalidProperties[] = "'recipient' can't be null";
        }
        if ($this->container['items'] === null) {
            $invalidProperties[] = "'items' can't be null";
        }
        $allowedValues = $this->getIntegratorAllowableValues();
        if (!is_null($this->container['integrator']) && !in_array($this->container['integrator'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'integrator', must be one of '%s'",
                implode("', '", $allowedValues)
            );
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
     * Gets merchant_id
     *
     * @return int
     */
    public function getMerchantId()
    {
        return $this->container['merchant_id'];
    }

    /**
     * Sets merchant_id
     *
     * @param int $merchant_id Necessary if you have a multitenancy account, otherwise we will associate the order with your account
     *
     * @return $this
     */
    public function setMerchantId($merchant_id)
    {
        $this->container['merchant_id'] = $merchant_id;

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
     * @param string $merchant_order_id Unique ID provided by the merchant
     *
     * @return $this
     */
    public function setMerchantOrderId($merchant_order_id)
    {
        $this->container['merchant_order_id'] = $merchant_order_id;

        return $this;
    }

    /**
     * Gets shipping_method
     *
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->container['shipping_method'];
    }

    /**
     * Sets shipping_method
     *
     * @param string $shipping_method Custom for you, it will be mapped to an actual method within the OMS UI
     *
     * @return $this
     */
    public function setShippingMethod($shipping_method)
    {
        $this->container['shipping_method'] = $shipping_method;

        return $this;
    }

    /**
     * Gets recipient
     *
     * @return \Swagger\Client\Model\ConsigneeNewV2
     */
    public function getRecipient()
    {
        return $this->container['recipient'];
    }

    /**
     * Sets recipient
     *
     * @param \Swagger\Client\Model\ConsigneeNewV2 $recipient recipient
     *
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->container['recipient'] = $recipient;

        return $this;
    }

    /**
     * Gets items
     *
     * @return \Swagger\Client\Model\OrdersItems[]
     */
    public function getItems()
    {
        return $this->container['items'];
    }

    /**
     * Sets items
     *
     * @param \Swagger\Client\Model\OrdersItems[] $items items
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->container['items'] = $items;

        return $this;
    }

    /**
     * Gets warehouse
     *
     * @return \Swagger\Client\Model\OrdersWarehouse
     */
    public function getWarehouse()
    {
        return $this->container['warehouse'];
    }

    /**
     * Sets warehouse
     *
     * @param \Swagger\Client\Model\OrdersWarehouse $warehouse warehouse
     *
     * @return $this
     */
    public function setWarehouse($warehouse)
    {
        $this->container['warehouse'] = $warehouse;

        return $this;
    }

    /**
     * Gets integrator
     *
     * @return string
     */
    public function getIntegrator()
    {
        return $this->container['integrator'];
    }

    /**
     * Sets integrator
     *
     * @param string $integrator Use of this property requires special permission and must be discussed with your account executive; values are restricted while custom values need to be accepted by your AE.
     *
     * @return $this
     */
    public function setIntegrator($integrator)
    {
        $allowedValues = $this->getIntegratorAllowableValues();
        if (!is_null($integrator) && !in_array($integrator, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'integrator', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['integrator'] = $integrator;

        return $this;
    }

    /**
     * Gets notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->container['notes'];
    }

    /**
     * Sets notes
     *
     * @param string $notes notes
     *
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->container['notes'] = $notes;

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
