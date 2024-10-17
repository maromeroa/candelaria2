<?php

/**
 * UpdateWebhook
 *
 * PHP version 5
 *
 * @category Class
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
/**
 * SendinBlue API
 *
 * SendinBlue provide a RESTFul API that can be used with any languages. With this API, you will be able to :   - Manage your campaigns and get the statistics   - Manage your contacts   - Send transactional Emails and SMS   - and much more...  You can download our wrappers at https://github.com/orgs/sendinblue  **Possible responses**   | Code | Message |   | :-------------: | ------------- |   | 200  | OK. Successful Request  |   | 201  | OK. Successful Creation |   | 202  | OK. Request accepted |   | 204  | OK. Successful Update/Deletion  |   | 400  | Error. Bad Request  |   | 401  | Error. Authentication Needed  |   | 402  | Error. Not enough credit, plan upgrade needed  |   | 403  | Error. Permission denied  |   | 404  | Error. Object does not exist |   | 405  | Error. Method not allowed  |   | 406  | Error. Not Acceptable  |
 *
 * OpenAPI spec version: 3.0.0
 * Contact: contact@sendinblue.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.12
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */
namespace WPMailSMTP\Vendor\SendinBlue\Client\Model;

use ArrayAccess;
use WPMailSMTP\Vendor\SendinBlue\Client\ObjectSerializer;
/**
 * UpdateWebhook Class Doc Comment
 *
 * @category Class
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class UpdateWebhook implements \WPMailSMTP\Vendor\SendinBlue\Client\Model\ModelInterface, \ArrayAccess
{
    const DISCRIMINATOR = null;
    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'updateWebhook';
    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = ['url' => 'string', 'description' => 'string', 'events' => 'string[]'];
    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = ['url' => 'url', 'description' => null, 'events' => null];
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
    protected static $attributeMap = ['url' => 'url', 'description' => 'description', 'events' => 'events'];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = ['url' => 'setUrl', 'description' => 'setDescription', 'events' => 'setEvents'];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = ['url' => 'getUrl', 'description' => 'getDescription', 'events' => 'getEvents'];
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
    const EVENTS_HARD_BOUNCE = 'hardBounce';
    const EVENTS_SOFT_BOUNCE = 'softBounce';
    const EVENTS_BLOCKED = 'blocked';
    const EVENTS_SPAM = 'spam';
    const EVENTS_DELIVERED = 'delivered';
    const EVENTS_REQUEST = 'request';
    const EVENTS_CLICK = 'click';
    const EVENTS_INVALID = 'invalid';
    const EVENTS_DEFERRED = 'deferred';
    const EVENTS_OPENED = 'opened';
    const EVENTS_UNIQUE_OPENED = 'uniqueOpened';
    const EVENTS_UNSUBSCRIBED = 'unsubscribed';
    const EVENTS_LIST_ADDITION = 'listAddition';
    const EVENTS_CONTACT_UPDATED = 'contactUpdated';
    const EVENTS_CONTACT_DELETED = 'contactDeleted';
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getEventsAllowableValues()
    {
        return [self::EVENTS_HARD_BOUNCE, self::EVENTS_SOFT_BOUNCE, self::EVENTS_BLOCKED, self::EVENTS_SPAM, self::EVENTS_DELIVERED, self::EVENTS_REQUEST, self::EVENTS_CLICK, self::EVENTS_INVALID, self::EVENTS_DEFERRED, self::EVENTS_OPENED, self::EVENTS_UNIQUE_OPENED, self::EVENTS_UNSUBSCRIBED, self::EVENTS_LIST_ADDITION, self::EVENTS_CONTACT_UPDATED, self::EVENTS_CONTACT_DELETED];
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
        $this->container['url'] = isset($data['url']) ? $data['url'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['events'] = isset($data['events']) ? $data['events'] : null;
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
        return \count($this->listInvalidProperties()) === 0;
    }
    /**
     * Gets url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->container['url'];
    }
    /**
     * Sets url
     *
     * @param string $url URL of the webhook
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->container['url'] = $url;
        return $this;
    }
    /**
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }
    /**
     * Sets description
     *
     * @param string $description Description of the webhook
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;
        return $this;
    }
    /**
     * Gets events
     *
     * @return string[]
     */
    public function getEvents()
    {
        return $this->container['events'];
    }
    /**
     * Sets events
     *
     * @param string[] $events Events triggering the webhook. Possible values for Transactional type webhook – `sent` OR `request`, `delivered`, `hardBounce`, `softBounce`, `blocked`, `spam`, `invalid`, `deferred`, `click`, `opened`, `uniqueOpened` and `unsubscribed` and possible values for Marketing type webhook – `spam`, `opened`, `click`, `hardBounce`, `softBounce`, `unsubscribed`, `listAddition` and `delivered`
     *
     * @return $this
     */
    public function setEvents($events)
    {
        $allowedValues = $this->getEventsAllowableValues();
        if (!\is_null($events) && \array_diff($events, $allowedValues)) {
            throw new \InvalidArgumentException(\sprintf("Invalid value for 'events', must be one of '%s'", \implode("', '", $allowedValues)));
        }
        $this->container['events'] = $events;
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
        if (\is_null($offset)) {
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
        if (\defined('JSON_PRETTY_PRINT')) {
            // use JSON pretty print
            return \json_encode(\WPMailSMTP\Vendor\SendinBlue\Client\ObjectSerializer::sanitizeForSerialization($this), \JSON_PRETTY_PRINT);
        }
        return \json_encode(\WPMailSMTP\Vendor\SendinBlue\Client\ObjectSerializer::sanitizeForSerialization($this));
    }
}
