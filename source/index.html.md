---
title: ReUp API Reference

language_tabs:
  - php
  - javascript

toc_footers:
  - <a href='http://www.getreup.com'>Sign Up for a ReUp Developer Account</a>

includes:
  - errors

search: true
---

# Introduction

Welcome to the ReUp Vendor API. Our vendor API is primarily used to enabled point of sale, gift card consumers and other mobile payments platforms to interact with ReUp.  This API follows RPC web service guidelines.  Customers interact with Vendors by showing QR codes which represent their intentions with the vendor.  These QR codes could be part of a ReUp mobile app or on the back of a gift card.

# Authentication

ReUp uses a combination of a ReUp API Key and HTTP auth username/password pairings to allow access to the ReUp Vendor API. Please [email](mailto:hello@getreup.com) to apply for an account.

ReUp expects your API key to be included in all API requests to the server in a header that looks like the following:

`https://api.getreup.com/client/VX.Y/REUP_API_KEY`

<aside class="notice">
You must replace <code>REUP_API_KEY</code> with your personal API key.
</aside>

Along with the API key, you must conform to the HTTP auth flow.  To do this, add your ReUp vendor account username and password to the header of each request.

# JSON RPC
> A typical request:

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "method_name";
$postData->params    = array("var1", "var2");
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
```

> Make sure to replace `method_name` with a method name and `array("var1", "var2")` with parameters outlined in following sections.

The ReUp Vendor API deploys the JSON RPC standard for all requests.  Each request requires the POST body to be in the format of:

Key | Type | Description
--------- | ----------- | -----------
jsonrpc | string | Always pass 2.0 here.
method | string | The method name for this request.
params | array | An array of parameters for this method.
id | string | For debugging purposes only. Whatever is passed in here is also returned.

# QR Codes

ReUp uses various QR codes to allow users to communicate their intention to the vendors.  Each QR code is a JSON object encoded in base 64.

## Use Credit

When customers want to use the credit from their account, they will reveal their "Use Credit QR Code", which consists of the following.

![Use Credit QR Code](images/UseCreditQRCode.png)

Base 64 Encoded:

e+KAnFXigJ064oCcMTAwMOKAnSzigJxI4oCdOuKAnDZhNTJjMDZiOTDigJ0s
4oCcVOKAnTrigJw1LjAw4oCdLOKAnFRU4oCdOuKAnETigJ19

Base 64 Decoded:

{"U":"1000","H":"6a52c06b90","T":"5.00","TT":"D"}

Key | Name | Description
--------- | ----------- | -----------
U | User ID | The user ID.
AppID | App ID | The app ID the user is using.
H | Hash | A hash unique to this vendor and user pairing.
T | Tip Amount | The amount the user has chosen to tip.  This may be a percentage or dollar amount.
TT | Tip Type | The type of tip the user has selected. Either "P" for percentage or "D" for dollar amount.

## Redeem Reward

The "Redeem Reward QR Code" is used by customers wishing to redeem for a reward.  They would select a reward from a list of ReUp rewards and show the presented QR code as follows.

![Redeem Reward QR Code](images/RedeemRewardQRCode.png)

Base 64 Encoded:

eyJVIjoiMTAwMCIsIkFwcElEIjoiYWJjMTIiLCJUIjo
iVSIsIlIiOiIxMjMiLCJIIjoiNmE1MmMwNmI5MCJ9

Base 64 Decoded:

{"U":"1000","AppID":"abc12","T":"U","R":"123","H":"6a52c06b90"}

Key | Name | Description
--------- | ----------- | -----------
U | User ID | The user ID.
AppID | App ID | The app ID the user is using.
R | Reward ID | The reward ID the user wishes to redeem points for.
H | Hash | A hash unique to this vendor and user.

## Gift Card

The "Gift Card QR Code" is on the back of all ReUp gift cards.  With this code, gift card wielding customers can show it to the vendor to redeem rewards, use credit and add credit to their account.  This is explained in later sections.

![Gift Card QR Code](images/GiftCardQRCode.png)

Base 64 Encoded:

eyJVIjoiMTAwMCIsIlQiOiJHQyIsIkgiOiI2YTUyYzA2YjkwIn0=

Base 64 Decoded:

{"U":"1000","T":"GC","H":"6a52c06b90"}

Key | Name | Description
--------- | ----------- | -----------
U | User ID | The gift card ID.
T | Type | Always "GC" to signify that this is a gift card and not a mobile app user.
H | Hash | A hash unique to this vendor and gift card.

# Retrieving User Info

## Get User

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetUser";
$postData->params    = array();
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
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
    "UserID": "22",
    "UserName": "some_vendor@email.com",
    "FirstName": "John",
    "LastName": "Doe",
    "DOB": "1984-01-25",
    "Verified": "1",
    "AppStoreURL": "",
    "PlayStoreURL": "",
    "Hash": "ab7111fd19"
  },
  "info": {
    "Profile": 0.0422658920288
  },
  "ID": 1
}
```

This endpoint retrieves details about the vendor user. It is also used to validate login. If user's credentials are deemed correct, store their ReUp API key, username and password in keychain for future calls.

### HTTP Request

`GET https://api.getreup.com/client/VX.Y/REUP_API_KEY`

### JSON Method Name

`GetUser`

### JSON Parameters

This method takes zero parameters.

## Get Gift Card User

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "GetUser";
$postData->params    = array(0=>"User ID");
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
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
    "UserID": "10000",
    "Credit": "5.25",
    "Points": "10"
  },
  "info": {
    "Profile": 0.0354671478271
  },
  "ID": 1
}
```

This endpoint retrieves a ReUp gift card user.

### HTTP Request

`GET https://api.getreup.com/client/VX.Y/REUP_API_KEY`

### JSON Method Name

`VendorGetGCUser`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The gift card ID in the QR code.  Decode the "Gift Card QR Code" and use the value from the "U" key.

# Conducting Transactions

## Use Credit

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "VendorUseCredit";
$postData->params    = array(0=>"<user_id>", 1=>"<amount>", 2=>"U", 3=>"<user_hash>", 4=>"<tip_type>", 5=>"<tip_amount>");
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
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
    "UserName": "some_customer@email.com",
    "CreditUsed": 1.1,
    "Subtotal": "1.00",
    "TipTotal": 0.1,
    "PointsEarned": 0,
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

This endpoint allows the vendor to decrement credit from their customer's ReUp mobile app or ReUp gift card.

### HTTP Request

`GET https://api.getreup.com/client/VX.Y/REUP_API_KEY`

### JSON Method Name

`VendorUseCredit`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code.  Decode the base 64 QR code and retrieve the value from the "U" key.
1 | Amount | The amount in dollars of credit the customer wishes to use.
2 | User Type | For a mobile app user, this is always "U".
3 | Hash | A hash unique to this vendor and user. Decode the "Use Credit QR Code" and use the value from the "H" key.
4 | Tip Type | This determines the tip type and can be one of two values: "P" (for percent) and "D" (for dollars).  Decode the "Use Credit QR Code" and use the value from the "TT" key.
5 | Tip Amount | This is what the user has selected as either the tip amount or percentage. Decode the "Use Credit QR Code" and use the value from the "T" key.

## Redeem Reward

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "VendorUseCredit";
$postData->params    = array(0=>"<user_id>", 1=>"<reward_id>", 2=>"U", 3=>"<user_hash>", 4=>"<tip_type>", 5=>"<tip_amount>");
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
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
    "UserName": "customer_email@email.com",
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

This endpoint allows the vendor to decrement points from their customer's ReUp mobile app or ReUp gift card depending on the number of points the requested reward costs.

### HTTP Request

`GET https://api.getreup.com/client/VX.Y/REUP_API_KEY`

### JSON Method Name

`VendorRedeemReward`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code. Decode the "Redeem Reward QR Code" and use the value from the "U" key.
1 | Reward ID | The ID of the reward the user wishes to redeem for. Decode the "Redeem Reward QR Code" and use the value from the "R" key.
2 | Type | For a mobile app user, this is always "U".
3 | Hash | A hash unique to this vendor and user. Decode the "Redeem Reward QR Code" and use the value from the "H" key.

## Add Credit to Gift Card

```php
$APIURL              = "https://api.getreup.com/client/VX.Y/" . $REUP_API_KEY
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "VendorUseCredit";
$postData->params    = array(0=>"<user_id>", 1=>"<amount>", 2=>"giftcard", 3=>"<user_hash>");
$postData->id        = 1;

curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '5');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT,'ReUpScanner');

curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

$content = trim(curl_exec($ch));

curl_close($ch);
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

This endpoint allows the vendor to add credit to a ReUp gift card.  It is recommended that this capability be protected behind a second locking mechanism, like a PIN, to prevent the vendor's employees from taking advantage of the service.

### HTTP Request

`GET https://api.getreup.com/client/VX.Y/REUP_API_KEY`

### JSON Method Name

`VendorAddCreditGiftCard`

### JSON Parameters

Index | Name | Description
--------- | ------- | -----------
0 | User ID | The user ID in the QR code.  Decode the "Gift Card QR Code" and retrieve the value from the "U" key.
1 | Amount | The amount in dollars of credit the vendor wishes to add to this gift card.
2 | User Type | For a gift card, this is always "giftcard".
3 | Hash | A hash unique to this vendor and user. Decode the "Gift Card QR Code" and retrieve the value from the "H" key.
