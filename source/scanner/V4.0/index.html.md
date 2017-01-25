---
title: ReUp Scanner API Reference

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

Welcome to the ReUp Scanner API. Our Scanner API is primarily used to enable point of sale solutions to interact with ReUp mobile app and gift card users.  This API follows RPC web service guidelines.  Customers interact with merchants by showing QR codes (which encode their intentions) to the merchant.  These QR codes could be part of a ReUp mobile app or on the back of a ReUp gift card.

# Authentication

ReUp uses a combination of the merchants subdomain (a unique, descriptive key chosen by the merchant at time of sign up) and HTTP auth username/password pairings to allow access to the ReUp Scanner API. Please [email](mailto:hello@getreup.com) if you are unaware of your subdomain or credentials.

ReUp expects your subdomain key to be included in all API requests to the server in a header that looks like the following:

`https://api.getreup.com/scanner/V4.0/SUBDOMAIN`

<aside class="notice">
Replace <code>SUBDOMAIN</code> with the merchant's unique subdomain chosen during sign up.
</aside>

Along with the API key, you must conform to the HTTP auth flow.  To do this, add your ReUp Scanner account username and password to the header of each request.

# JSON RPC
> A typical request:

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
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
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
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

The ReUp Scanner API deploys the JSON RPC standard for all requests, see [http://json-rpc.org/](http://json-rpc.org/) for more details.  Each request requires the POST body to be in the format of:

Key | Type | Description
--------- | ----------- | -----------
jsonrpc | string | Always pass 2.0 here.
method | string | The method name for this request.
params | array | An array of parameters for this method.
id | string | For debugging purposes only. Whatever is passed in here is also returned.

# QR Codes

ReUp uses various QR codes to allow users to communicate their intention to the merchant.  Each QR code is a JSON object encoded in base 64. There are many libraries that provide base 64 encoding, for details on base 64 encoding/decoding, please see: [https://www.base64decode.org/](https://www.base64decode.org/).

## Pay With Credit

When customers want to use the credit from their account, they will reveal their "Pay With Credit" QR Code, for example:

![Use Credit QR Code](scanner/V4.0/UseCreditQRCode.png)

Above QR Code Source:

eyJUeXBlIjoiY3JlZGl0IiwiQXBwSUQiOiIxMjM0NSIsIlUiOiIxMDAwIiwiSCI6IjlhMTIzYTQ0YWIiLCJUIjowLCJUVCI6IlAifQ==

Base 64 Decoded QR Code Source:

{"Type":"credit","AppID":"12345","U":"1000","H":"9a123a44ab","T":0,"TT":"P"}

Key | Name | Description
--------- | ----------- | -----------
Type | QR Code Type | The type of QR code being scanned (e.g. reward)
AppID | App ID | The unique App ID assigned to this app.  Each merchant has an App ID.
U | User ID | The user ID, unique to every customer account.
H | Hash | A unique security hash used to authenticate this customer-merchant pairing.
T | Tip Amount | The amount the user has chosen to tip.
TT | Tip Type | The type of tip the user has selected. Either "P" for percentage or "D" for dollar amount (e.g. 1.21).

## Redeem Reward

The "Redeem Reward" QR Code is used by customers wanting to redeem a reward they have earned.  The customer would select a reward from a list of rewards in their app and present the QR code, for example:

![Redeem Reward QR Code](scanner/V4.0/RedeemRewardQRCode.png)

Above QR Code Source:

eyJBcHBJRCI6IjEyMzQ1IiwiVHlwZSI6InJld2FyZCIsIlUiOiIxMDAwIiwiSCI6IjlhMTIzYTQ0YWIiLCJSIjoiMTIzIn0=

Base 64 Decoded QR Code Source:

{"AppID":"12345","Type":"reward","U":"1000","H":"9a123a44ab","R":"123"}

Key | Name | Description
--------- | ----------- | -----------
AppID | App ID | The unique App ID assigned to this app.  Each merchant has an App ID.
Type | QR Code Type | The type of QR code being scanned (e.g. reward)
U | User ID | The user ID, unique to every customer account.
H | Hash | A unique security hash used to authenticate this customer-merchant pairing.
R | Reward ID | The reward ID the user wishes to redeem points for.

## Gift Card

The "Gift Card" QR Code is on the back of every ReUp gift card.  With this code, gift card wielding customers can redeem rewards, use credit and load credit to their account.

![Gift Card QR Code](scanner/V4.0/GiftCardQRCode.png)

Above QR Code Source:

eyJVIjoiMTAwMCIsIlQiOiJHQyIsIkgiOiI2YTUyYzA2YjkwIn0=

Base 64 Decoded QR Code Source:

{"U":"1000","T":"GC","H":"6a52c06b90"}

Key | Name | Description
--------- | ----------- | -----------
U | User ID | The gift card ID, unique to every gift card account.
T | Type | Always "GC" to signify that this is a gift card and not a mobile app user.
H | Hash | A unique security hash used to authenticate this gift card-merchant pairing.

# Retrieving Information

The calls in this section are used to retrieve information on the merchant or the gift card presented by the customer.

## Validate Merchant Credentials

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetUser";
$postData->params    = array();
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetUser";
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
    "result": {
        "UserID": "32",
        "UserName": "merchant@domain.com",
        "Verified": "1",
        "Admin": 1,
        "DirtyPassword": 0,
        "DollarsPerPoint": "5",
        "AppID": "12345",
        "ScannerPIN": ""
    },
    "info": {
        "Profile": 0.0380589962006
    },
    "ID": 1
}
```

This endpoint is used to validate the merchant's login information. If credentials are deemed correct, store their subdomain, username and password in a keychain, database, or other location for future calls.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`GetUser`

### JSON Parameters

This method takes zero parameters.

## Retrieve List of Rewards

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
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
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
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

This endpoint returns a list of active rewards set by the merchant.  This is primarily used when a customer presents a gift card.  By checking the [gift card's current balance](#get-gift-card-balance), and also using this end point to retrieve a list of rewards and their required point values, you can display a list of eligible rewards to the merchant.  The requested reward can then be claimed by [redeeming a reward](#redeem-a-reward).

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`GetRewards`

### JSON Parameters

This method takes zero parameters.

## Get Gift Card Balance

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetGCUser";
$postData->params    = array("<user_id>", "<hash>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "GetGCUser";
postData.params      = ["<user_id>", "<hash>"];
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
        "UserID": "152",
        "Credit": "165.00",
        "Points": "70"
    },
    "info": {
        "Profile": 0.0338590145111
    },
    "ID": 1
}
```

This endpoint retrieves a ReUp gift card user.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`GetGCUser`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The gift card ID in the QR code.  Decode the "Gift Card QR Code" and use the value from the "U" key.
1 | Hash | A hash unique to this merchant and user. Decode the "Use Credit QR Code" and use the value from the "H" key.

# Conducting Transactions

## Pay With Credit

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "UseCredit";
$postData->params    = array("<user_id>", "<amount>", "<user_type>", "<hash>", "<tip_type>", "<tip_value>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "UseCredit";
postData.params      = ["<user_id>", "<amount>", "<user_type>", "<hash>", "<tip_type>", "<tip_value>"];
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
    "CreditUsed": 1.5,
    "Subtotal": "1.00",
    "TipTotal": 0.5,
    "PointsEarned": 1,
    "TransactionID": "5119",
    "FirstName": "Stephanie",
    "LastName": "Rogers",
    "CurrentCredit": "19.15",
    "CurrentPoints": "10"
  },
  "info": {
    "Profile": 0.115028142929
  },
  "ID": 1
}
```

This endpoint allows the merchant to decrement credit from their customer's ReUp mobile app or ReUp gift card.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`UseCredit`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code.  Decode the base 64 QR code and retrieve the value from the "U" key.
1 | Amount | The amount in dollars (i.e. X.YZ) of credit the customer wishes to use.
2 | User Type | For a mobile app user, this is always "U".  For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. Decode the "Use Credit" QR Code and use the value from the "H" key.
4 | Tip Type | This determines the tip type and can be one of two values: "P" (for percent) and "D" (for dollars).  Decode the "Use Credit QR Code" and use the value from the "TT" key.
5 | Tip Value | This is what the user has selected as either the tip amount or percentage. Decode the "Use Credit QR Code" and use the value from the "T" key.

## Redeem A Reward

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
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
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
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

This endpoint allows the merchant to decrement points from their customer's ReUp mobile app or ReUp gift card depending on the number of points the requested reward costs.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`RedeemReward`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code. Decode the "Redeem Reward QR Code" and use the value from the "U" key.
1 | Reward ID | The ID of the reward the user wishes to redeem for. Decode the "Redeem Reward QR Code" and use the value from the "R" key.
2 | User Type | For a mobile app user, this is always "U".   For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. Decode the "Redeem Reward QR Code" and use the value from the "H" key.

## Evaluate A Reward

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "EvaluateReward";
$postData->params    = array("<user_id>", "<reward_id>", "<user_type>", "<hash>",
                        array(
                          "receipt_datetime" => "2016-11-14T12:31:21+00:00",
                          "subtotal_amount" => "22.00",
                          "menu_items" => array(
                            array(
                              "menu_item_type" => "M",
                              "item_name" => "Steak Burger",
                              "item_qty" => "3",
                              "item_amount" => "24.00",
                              "menu_item_id" => "2100720",
                              "menu_family" => "1404",
                              "menu_major_group" => "1089"
                            ),
                            array(
                              "menu_item_type" => "M",
                              "item_name" => "Veggie Burger",
                              "item_qty" => "2",
                              "item_amount" => "21.00",
                              "menu_item_id" => "2100722",
                              "menu_family" => "1404",
                              "menu_major_group" => "1089"
                            ),
                            array(
                              "menu_item_type" => "D",
                              "item_name" => "$2 Off a $10 Purchase",
                              "item_qty" => 1,
                              "item_amount" => "-2.00",
                              "menu_item_id" => 10,
                              "menu_family" => 0,
                              "menu_major_group" => 0
                            )
                          )
                        ));
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "EvaluateReward";
postData.params      = ["<user_id>", "<reward_id>", "<user_type>", "<hash>",
                        {
                          "receipt_datetime": "2016-11-14T12:31:21+00:00",
                          "subtotal_amount": "22.00",
                          "menu_items": [
                            {
                              "menu_item_type": "M",
                              "item_name": "Steak Burger",
                              "item_qty": "3",
                              "item_amount": "24.00",
                              "menu_item_id": "2100720",
                              "menu_family": "1404",
                              "menu_major_group": "1089"
                            },
                            {
                              "menu_item_type": "M",
                              "item_name": "Veggie Burger",
                              "item_qty": "2",
                              "item_amount": "21.00",
                              "menu_item_id": "2100722",
                              "menu_family": "1404",
                              "menu_major_group": "1089"
                            },
                            {
                              "menu_item_type": "D",
                              "item_name": "$2 Off a $10 Purchase",
                              "item_qty": 1,
                              "item_amount": "-2.00",
                              "menu_item_id": 10,
                              "menu_family": 0,
                              "menu_major_group": 0
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
    "usermsg": ""
  },
  "result": {
    "QualifiedDiscounts": [
      {
        "Index": 0,
        "SKU": "2100720",
        "Discount": "8.00"
      },
      {
        "Index": 1,
        "SKU": "2100722",
        "Discount": "10.50"
      }
    ],
    "RewardID": 20,
    "RewardName": "Test Reward Name",
    "UserName": "customer@domain.com",
    "PointsUsed": "1",
    "FirstName": "Stephanie",
    "LastName": "Rogers",
    "Credit": "302.57",
    "CurrentPoints": "34",
    "AfterPoints": 14,
  },
  "info": {
    "Profile": 0.0647549629211
  },
  "ID": 1
}
```

This endpoint allows the merchant to pass in a RewardID along with an invoice and retrieve the potential discounts the user is qualified for. This method does NOT decrement points. Apply the appropriate discount to the invoice and then execute the RedeemReward method.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`EvaluateReward`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code. Decode the "Redeem Reward QR Code" and use the value from the "U" key.
1 | Reward ID | The ID of the reward the user wishes to redeem for. Decode the "Redeem Reward QR Code" and use the value from the "R" key.
2 | User Type | For a mobile app user, this is always "U".   For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. Decode the "Redeem Reward QR Code" and use the value from the "H" key.
4 | Invoice Details | An object with a key named "menu_items", which is an array of objects each containing at least the keys "menu_item_id" (the SKU), "item_qty" (optional, 1 is used without it), and "item_amount". Feel free to send any additional information in the line items.

## Add Credit to Gift Card

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "AddCreditGiftCard";
$postData->params    = array("<user_id>", "<amount>", "<user_type>", "<hash>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "AddCreditGiftCard";
postData.params      = ["<user_id>", "<amount>", "<user_type>", "<hash>"];
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
      "TransactionID": "5116",
      "UserID": "10000",
      "Credit": "5.00",
      "Subtotal": "0.00",
      "TipTotal": "0.00",
      "Tip": "0.00",
      "TipType": "",
      "Points": "0",
      "IsCredit": "1",
      "Source": "0",
      "Timestamp": "2015-08-17 01:24:56",
      "Refunded": "0",
      "RewardID": "",
      "RewardName": ""
    }
  ],
  "info": {
    "Profile": 0.0668139457703
  },
  "ID": 1
}
```

This endpoint allows the merchant to add credit to a ReUp gift card.  It is recommended that this capability be protected behind a second locking mechanism, like a PIN, to prevent the merchant's employees from taking advantage of the service.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`AddCreditGiftCard`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code.  Decode the "Gift Card QR Code" and retrieve the value from the "U" key.
1 | Amount | The amount in dollars (i.e. X.YZ) of credit the merchant wishes to add to this gift card.
2 | User Type | For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this merchant and user. Decode the "Gift Card QR Code" and retrieve the value from the "H" key.

## Check-In (Points Only)

```php

<?php

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "<your subdomain>";
$user                = "<username>";
$pass                = "<password>";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "CheckIn";
$postData->params    = array("<user_id>", "<hash>", "<dollar_amount>");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

?>

```

```javascript

// subdomain, username, password are selected by merchant during sign up
var subdomain        = "<your subdomain>";
var username         = "<username>";
var password         = "<password>";
var token            = 'Basic ' + window.btoa(username + ':' + password);

// setup the request
var apiURL           = "https://api.getreup.com/scanner/V4.0/" + subdomain;
var postData         = {}            
postData.jsonrpc     = "2.0";
postData.method      = "CheckIn";
postData.params      = ["<user_id>", "<hash>", "<dollar_amount>"];
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
        "AppStoreURL": "",
        "PlayStoreURL": ""
    },
    "result": {
        "PointsEarned": 5,
        "UserName": "customer@domain.com",
        "TransactionID": "3143",
        "FirstName": "Stephanie",
        "LastName": "Rogers",
        "CurrentCredit": "19.80",
        "CurrentPoints": "65"
    },
    "info": {
        "Profile": 0.38250303268433
    },
    "ID": null
}
```

This endpoint allows the merchant to give a customer points without the customer paying with their app.  This allows customers who prefer to pay with debit, credit, cash, etc. to still earn points on their purchase.  It is recommended that you suggest customers pay with credit to earn points as it requires a single interaction (pay with your app, automatically earn points) rather than a cash/debit/credit payment followed by scanning a QR code to earn points.

### HTTP Request

`POST https://api.getreup.com/client/V4.0/SUBDOMAIN`

### JSON Method Name

`CheckIn`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code.  Decode the "Gift Card QR Code" and retrieve the value from the "U" key.
1 | Hash | A hash unique to this merchant and user. Decode the "Gift Card QR Code" and retrieve the value from the "H" key.
2 | Dollar Amount | The dollar amount this user will earn points on.  The amount of dollars per point is set in the ReUp Dashboard.
