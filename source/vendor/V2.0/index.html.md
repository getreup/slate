---
title: ReUp Vendor API Reference

language_tabs:
  - php
  - javascript

toc_footers:
  - <a href='mailto:hello@getreup.com'>Questions? Email hello@getreup.com</a>

includes:
  - errors

search: true
---

# Introduction

Welcome to the ReUp Vendor API. Our Vendor API provides a means for third party online ordering, gift card checkers, wifi-marketing, and other integrations to perform transactions and other data queries with ReUp mobile apps. This API follows RPC web service guidelines. Third parties need authentication on a per client basis to maintain security standards.

# Authentication

ReUp uses a combination of the merchants ReUp app ID (a 5 character alphanumeric string, unique to EACH client app) and an API key (unique to each third party) as HTTP auth username/password pairings, respectively, to allow access to the ReUp Vendor API. Please [email](mailto:hello@getreup.com) if you are unaware of your client's ReUp app ID or your third party API key.

The endpoint for all methods in this document is the following:

`https://api.getreup.com/vendor/V2.0/`

The authorization header should conform to HTTP basic auth by composing of the following:

`Basic base64(APPID:APIKEY)`

<aside class="notice">
Replace <code>APPID</code> with the merchant's unique ReUp app ID, and <code>APIKEY</code> with your third party API key.
</aside>

# JSON RPC
> A typical request:

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "method_name";
$postData->params    = array("<var1>", "<var2>", ...);
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "method_name";
postData.params      = ["<var1>", "<var2>", ...];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> Make sure to replace `method_name` with a method name and `array("<var1>", "<var2>")` with parameters outlined in following sections.

The ReUp Vendor API deploys the JSON RPC standard for all requests, see [http://json-rpc.org/](http://json-rpc.org/) for more details.  Each request requires the POST body to be in the format of:

Key | Type | Description
--------- | ----------- | -----------
jsonrpc | string | Always pass 2.0 here.
method | string | The method name for this request.
params | array | An array of parameters for this method.
id | string | For debugging purposes only. Whatever is passed in here is also returned.

# Retrieving Information

The calls in this section are used to retrieve information on the merchant or the gift card presented by the customer.

## Get Features

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetFeatures";
$postData->params    = array();
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetFeatures";
postData.params      = [];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
  "jsonrpc": "2.0",
  "error": {
    "code": 0,
    "message": "No Error",
    "usermsg": "",
    "AppStoreURL": "apple URL",
    "PlayStoreURL": ""
  },
  "result": [
    {
      "FeatureID": "1",
      "FeatureName": "News For Favorites",
      "ImageFileName": "https://www.somewhere.com/image1.png",
      "Description": "A news item only for our favorite customers",
      "Timestamp": "2017-03-08 21:17:17"
    },
    {
      "FeatureID": "2",
      "FeatureName": "News For Ballers",
      "ImageFileName": "https://www.somewhere.com/image2.png",
      "Description": "A news item only for our top spending customers",
      "Timestamp": "2017-03-08 21:17:17"
    },
    {
      "FeatureID": "3",
      "FeatureName": "News For All",
      "ImageFileName": null,
      "Description": "A news item for anyone",
      "Timestamp": "2017-03-08 21:17:17"
    }
  ],
  "info": {
    "Profile": 0.089814901351929
  },
  "ID": 1
}

```

This endpoint allows third parties to retrieve what features, news items or promotional materials the merchant has set up in their ReUp dashboard. Each feature has a title, description and potentially an image URL..

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`GetFeatures`

### JSON Parameters

This method takes zero parameters.

## Retrieve List of Rewards

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetRewards";
$postData->params    = array();
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetRewards";
postData.params      = [];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": ""
    },
    "result": [
        {
            "RewardID": "22",
            "RewardName": "Free Small Soda",
            "Description": "A free small soda of your choice.",
            "Points": "10"
        },
        {
            "RewardID": "28",
            "RewardName": "Free Sandwich",
            "Description": "Any sandwich, any size.  On us!",
            "Points": "20"
        },
        {
            "RewardID": "31",
            "RewardName": "Free Combo Upgrade",
            "Description": "Upgrade any sandwich to a full combo.",
            "Points": "25"
        }
    ],
    "info": {
        "Profile": 0.296965122223
    },
    "ID": 1
}
```

This method returns a list of active rewards set by the merchant. This is primarily used when a customer presents a gift card. Using this end point, you are able to retrieve a list of rewards and their required point values to display a list of rewards to the merchant. Rewards can be linked to specific SKUs or product IDs so that the EvaluateReward method can return a potential discount for a particular reward and invoice.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`GetRewards`

### JSON Parameters

This method takes zero parameters.

## Evaluate A Reward

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "EvaluateReward";
$postData->params    = array("<user_id>", "<reward_id>", "<user_type>", "<hash>",
                        array(
                          "receipt_datetime" => "2016-11-14T12:31:21+00:00",
                          "subtotal" => "22.00",
                          "items" => array(
                            array(
                              "item_type" => "M",
                              "item_name" => "Steak Burger",
                              "item_qty" => "3",
                              "item_amount" => "24.00",
                              "product_id" => "2100720",
                              "product_family" => "1404",
                              "product_group" => "1089"
                            ),
                            array(
                              "item_type" => "M",
                              "item_name" => "Veggie Burger",
                              "item_qty" => "2",
                              "item_amount" => "21.00",
                              "product_id" => "2100722",
                              "product_family" => "1404",
                              "product_group" => "1089"
                            ),
                            array(
                              "item_type" => "D",
                              "item_name" => "$2 Off a $10 Purchase",
                              "item_qty" => 1,
                              "item_amount" => "-2.00",
                              "product_id" => 10,
                              "product_family" => 0,
                              "product_group" => 0
                            )
                          )
                        ));
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}
postData.jsonrpc     = "2.0";
postData.method      = "EvaluateReward";
postData.params      = ["<user_id>", "<reward_id>", "<user_type>", "<hash>",
                        {
                          "receipt_datetime": "2016-11-14T12:31:21+00:00",
                          "subtotal": "22.00",
                          "items": [
                            {
                              "item_type": "M",
                              "item_name": "Steak Burger",
                              "item_qty": "3",
                              "item_amount": "24.00",
                              "product_id": "2100720",
                              "product_family": "1404",
                              "product_group": "1089"
                            },
                            {
                              "item_type": "M",
                              "item_name": "Veggie Burger",
                              "item_qty": "2",
                              "item_amount": "21.00",
                              "product_id": "2100722",
                              "product_family": "1404",
                              "product_group": "1089"
                            },
                            {
                              "item_type": "D",
                              "item_name": "$2 Off a $10 Purchase",
                              "item_qty": 1,
                              "item_amount": "-2.00",
                              "product_id": 10,
                              "product_family": 0,
                              "product_group": 0
                            }
                          ]
                        }];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
  "jsonrpc": "2.0",
  "error": {
    "code": 0,
    "message": "No Error",
    "usermsg": "",
    "AppStoreURL": "apple URL",
    "PlayStoreURL": ""
  },
  "result": {
    "QualifiedDiscounts": [
      {
        "Index": 0,
        "SKU": "2100720",
        "Discount": "8.00",
        "RewardID": "20",
        "RewardName": "Test Reward Name",
        "Points": "20"
      },
      {
        "Index": 1,
        "SKU": "2100722",
        "Discount": "10.50",
        "RewardID": "20",
        "RewardName": "Test Reward Name",
        "Points": "20"
      }
    ],
    "UserName": "no-reply@getreup.com",
    "FirstName": "ReUp",
    "LastName": "Scanner",
    "Credit": "212.40",
    "CurrentPoints": "45",
    "RewardID": "20",
    "RewardName": "Test Reward Name",
    "PointsUsed": "20",
    "AfterPoints": 25
  },
  "info": {
    "Profile": 0.12654304504395
  },
  "ID": 1
}
```

This endpoint allows the third party to pass in a RewardID (or "\*" to query all rewards) along with an invoice and retrieve the potential discounts the user is qualified for. This method does NOT decrement points. Apply the appropriate discount to the invoice and then execute the RedeemReward method on checkout.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`EvaluateReward`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID of the end user. This is passed to the third party from ReUp during an integration interaction.
1 | Reward ID | The ID of the reward to evaluate. This can also be "\*" to evaluate all rewards.
2 | User Type | For a mobile app user, this is always "U".   For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. This is passed to the third party from ReUp during an integration interaction.
4 | Invoice Details | An object with a key named "items", which is an array of objects each containing at least the keys "product_id" (the SKU), "item_qty" (optional, 1 is used without it), and "item_amount". Feel free to send any additional information in the line items.

## Get List of Payment Methods

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetPaymentMethods";
$postData->params    = array("<user_id>", "<user_hash>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetPaymentMethods";
postData.params      = ["<user_id>", "<user_hash>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
  "jsonrpc": "2.0",
  "error": {
    "code": 0,
    "message": "No Error",
    "usermsg": "",
    "AppStoreURL": "apple URL",
    "PlayStoreURL": ""
  },
  "result": [
    [
      "APP_CREDIT",
      "App Credit (65.50)",
      "App Credit",
      "65.50"
    ],
    [
      "card_19y5E82xFkHYcVLujndH63Xb",
      "VISA (4242)",
      "VISA",
      "4242"
    ]
  ],
  "info": {
    "Profile": 0.09302806854248
  },
  "ID": 1
}
```

This method returns a list of payment methods that are compatible with AuthorizePayment and
MakePayment. The response is an array of arrays, where the first response is always
"App Credit" (as long as the Vendor has set up app credit payments). Each payment method
consists of ["<payment_method_id", "<payment_method_name>", "<payment_method_type>", "<payment_method_info>"], where payment_method_info is either the remaining amount of app credit or the last four digits
for a credit card.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`GetPaymentMethods`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID of the end user. This is passed to the third party from ReUp during an integration interaction.
1 | Hash | A hash unique to this merchant and user. This is passed to the third party from ReUp during an integration interaction.

## Get App Info

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetInfo";
$postData->params    = array();
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetInfo";
postData.params      = [];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": "",
        "AppStoreURL": "apple URL",
        "PlayStoreURL": ""
    },
    "result": {
        "DollarsPerPoint": "10.0",
        "AccessProfile": "M,W,GC,"
    },
    "info": {
        "Profile": 0.065255165100098
    },
    "ID": 1
}
```

This method returns some configuration data for the client, including the "DollarsPerPoint" they have set up in the dashboard.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`GetInfo`

### JSON Parameters

This method takes zero parameters.

# Gift Card Interactions

## Get Gift Card Info

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetGCInfo";
$postData->params    = array("<gift_card_number>", "<gift_card_pin>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetGCInfo";
postData.params      = ["<gift_card_number>", "<gift_card_pin>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": "",
        "AppStoreURL": "apple URL",
        "PlayStoreURL": ""
    },
    "result": [
        {
            "UserID": "1489012460",
            "Credit": "0.00",
            "Points": "0",
            "Email": "sterling@archer.com",
            "Name": "Sterling Archer",
            "HasTransferredLoyalty": "0"
        },
        [
            {
                "TransactionID": "11",
                "Credit": "-5.71",
                "Points": "0",
                "IsCredit": "1",
                "Source": "5",
                "Timestamp": "2016-03-08 22:40:54",
                "Refunded": "0",
                "RewardID": "",
                "RewardName": ""
            },
            {
                "TransactionID": "10",
                "Credit": "25.10",
                "Points": "0",
                "IsCredit": "1",
                "Source": "0",
                "Timestamp": "2016-03-08 22:40:46",
                "Refunded": "0",
                "RewardID": "",
                "RewardName": ""
            }
        ]
    ],
    "info": {
        "Profile": 0.13805413246155
    },
    "ID": 1
}
```

This endpoint retrieves a ReUp gift card user and their transactions.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`GetGCInfo`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | Gift Card Number | The human readable number on the back of a ReUp gift card.
1 | Gift Card PIN | A 5 digit PIN, which will have a stick over it originally for security purposes.

## Register Gift Card

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "RegisterGC";
$postData->params    = array("<gift_card_number>", "<gift_card_pin>", "<email>", "<full_name>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "RegisterGC";
postData.params      = ["<gift_card_number>", "<gift_card_pin>", "<email>", "<full_name>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": "",
        "AppStoreURL": "apple URL",
        "PlayStoreURL": ""
    },
    "result": {
        "UserID": "1489015928",
        "Credit": "0.00",
        "Points": "0",
        "Email": "sterling@archer.com",
        "Name": "Sterling Archer",
        "HasTransferredLoyalty": "0"
    },
    "info": {
        "Profile": 0.1219220161438
    },
    "ID": 1
}
```

This endpoint registers a ReUp gift card with an email and name. A gift card can only be registered once.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`RegisterGC`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | Gift Card Number | The human readable number on the back of a ReUp gift card.
1 | Gift Card PIN | A 5 digit PIN, which will have a stick over it originally for security purposes.
2 | Email | The email that the gift card is being registered under.
3 | Full Name | The name that the gift card is being registered under

# Conducting Transactions

## Authorize Payment

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "AuthorizePayment";
$postData->params    = array("<user_id>", "<user_hash>", "<amount>", "<payment_method_id>", "<invoice>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "AuthorizePayment";
postData.params      = ["<user_id>", "<user_hash>", "<amount>", "<payment_method_id>", "<invoice>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": "",
        "AppStoreURL": "apple URL",
        "PlayStoreURL": ""
    },
    "result": {
        "UserName": "sterling@archer.com",
        "FirstName": "Sterling",
        "LastName": "Archer",
        "PreauthorizedCredit": 13.40
    },
    "info": {
        "Profile": 0.90005421638489
    },
    "ID": 1
}
```

In the case where the Payment Method ID references a credit card, this endpoint reaches out to the payment processor and does a pre-authorization for the amount + 30%. The 30% is for if the customer wishes to add a tip after picking up their food, for instance.

In the case where the Payment Method ID references in app credit, this endpoint only checks to ensure the customer has the right amount of credit.

In the context of online ordering, this method should be used when the customer checks out, followed by the MakePayment method for when the order is accepted by the merchant.                 

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`AuthorizePayment`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID of the end user. This is passed to the third party from ReUp during an integration interaction.
1 | Hash | A hash unique to this merchant and user. This is passed to the third party from ReUp during an integration interaction.
2 | Amount | The amount in dollars (i.e. X.YZ) of credit the customer wishes to use.
3 | Payment Method ID | This encapsulates app credit, credit card, or any other method of payment. To retrieve this, either have ReUp pass it in via integration, or call the GetPaymentMethods method for a particular user.
4 | Invoice | A JSON string representing an invoice's details. This is stored for analytics and debugging.

## Make Payment

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "MakePayment";
$postData->params    = array("<user_id>", "<hash>", "<amount>", "<payment_method_id>", "<invoice>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "UseCredit";
postData.params      = ["<user_id>", "<hash>", "<amount>", "<payment_method_id>", "<invoice>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "No Error",
        "usermsg": "",
        "AppStoreURL": "apple URL",
        "PlayStoreURL": ""
    },
    "result": {
        "UserName": "no-reply@getreup.com",
        "CreditUsed": "10.25"
    },
    "info": {
        "Profile": 2.429417848587
    },
    "ID": 1
}
```

This endpoint allows the merchant to pass in a payment method ID and amount to charge a customer. This encapsulates either decrementing credit from their account, charging a credit card, or any other method of payment.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`MakePayment`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID of the end user. This is passed to the third party from ReUp during an integration interaction.
1 | Hash | A hash unique to this merchant and user. This is passed to the third party from ReUp during an integration interaction.
2 | Amount | The amount in dollars (i.e. X.YZ) of credit the customer wishes to use.
3 | Payment Method ID | This encapsulates app credit, credit card, or any other method of payment. To retrieve this, either have ReUp pass it in via integration, or call the GetPaymentMethods method for a particuar user.
4 | Invoice | A JSON string representing an invoice's details. This is stored for analytics and debugging.

## Redeem A Reward

```php

<?php

// appID is generated when a client signs up, while the api key will be distributed manually
$appID               = "<appID>";
$apiKey              = "<apiKey>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/vendor/V2.0/";
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "RedeemReward";
$postData->params    = array("<user_id>", "<reward_id>", "<user_type>", "<hash>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpVendor API $appID");
curl_setopt($ch, CURLOPT_USERPWD, $appID . ":" . $apiKey);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// appID is generated when a client signs up, while the api key will be distributed manually
var appID            = "<appID>";
var apiKey           = "<apiKey>";
var token            = 'Basic ' + window.btoa(appID + ':' + apiKey);

// setup the request
var apiURL           = "https://api.getreup.com/vendor/V2.0/";
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "RedeemReward";
postData.params      = ["<user_id>", "<reward_id>", "<user_type>", "<hash>"];
postData.id          = 1;
var headers          = {
                         'Accept': 'application/json',
                         'Content-Type': 'application/json',
                         'Authorization': token
                       };

// execute the fetch API call
fetch(apiURL, {
	method: 'post',
  headers: headers,
	body: JSON.stringify(postData)
}).then(function(response)
{
  if (response.status !== 200)
  {
    console.log('Looks like there was a problem. Status Code: ' +
      response.status);
    return;
  }

  // Examine the text in the response
  response.json().then(function(data)
  {
    console.log(data);
  });
}).catch(function(err)
{
  console.log('Fetch Error :-S', err);
});

```

> The above command returns JSON structured like this:

```json
{
  "jsonrpc": "2.0",
  "error": {
    "code": 0,
    "message": "No Error",
    "usermsg": ""
  },
  "result": {
    "UserName": "customer@domain.com",
    "PointsUsed": "1",
    "TransactionID": "5120",
    "FirstName": "Stephanie",
    "LastName": "Rogers",
    "CurrentCredit": "19.15",
    "CurrentPoints": "9"
  },
  "info": {
    "Profile": 0.0647549629211
  },
  "ID": 1
}
```

This endpoint allows the third party to decrement points from a customer's ReUp mobile app or ReUp gift card depending on the number of points the requested reward costs.

### HTTP Request

`POST https://api.getreup.com/vendor/V2.0/`

### JSON Method Name

`RedeemReward`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID of the end user. This is passed to the third party from ReUp during an integration interaction.
1 | Reward ID | The ID of the reward the user wishes to redeem for.
2 | User Type | For a mobile app user, this is always "U".   For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. This is passed to the third party from ReUp during an integration interaction.
