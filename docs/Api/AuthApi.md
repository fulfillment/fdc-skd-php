# Swagger\Client\AuthApi

All URIs are relative to *https://api.fulfillment.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**postOauthAccessToken**](AuthApi.md#postoauthaccesstoken) | **POST** /oauth/access_token | Generate an Access Token

# **postOauthAccessToken**
> \Swagger\Client\Model\AccessTokenResponseV2 postOauthAccessToken($body)

Generate an Access Token

By default tokens are valid for 7 days while refresh tokens are valid for 30 days. If your `grant_type` is \"password\" include the `username` and `password`, if however your `grant_type` is \"refresh_token\" the username/password are not required, instead set the `refresh_token`

### Example
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

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\AccessTokenRequestV2**](../Model/AccessTokenRequestV2.md)| Get an access token |

### Return type

[**\Swagger\Client\Model\AccessTokenResponseV2**](../Model/AccessTokenResponseV2.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

