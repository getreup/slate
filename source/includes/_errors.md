# Errors

The ReUp Vendor API uses the following error codes:

Error Code | String | Description
---------- | ------- | -------
1 | ERROR_NEW_VERSION | A soft update is available.
0 | ERROR_NONE | No error.
-1 | ERROR_INVALID_LOGIN | Login username/password incorrect.
-2 | ERROR_LOGIN_MISMATCH | Login username/password incorrect.
-3 | ERROR_NO_ACCOUNT_FOUND | User ID not found.
-4 | ERROR_USERNAME_EXISTS | Username already exists.
-5 | ERROR_BAD_REQUEST | Malformed request.
-6 | ERROR_SERVER_ERROR | Server error.
-7 | ERROR_NO_FUNCTION | Method name is incorrect.
-8 | ERROR_PW_CHANGE | Error changing password.
-9 | ERROR_NO_HTTPS | HTTPS is not being used.
-10 | ERROR_AUTH_FAIL | Login username/password incorrect.
-11 | ERROR_NSF | Customer does not have sufficient credit.
-12 | ERROR_NSP | Customer does not have sufficient points.
-13 | ERROR_NO_CONFIG | Config is invalid.
-14 | ERROR_ZIP | Error zipping file.
-15 | ERROR_OPEN_DIR | Error opening directory.
-16 | ERROR_EMAIL_FORMAT | Email is malformed.
-17 | ERROR_EMAIL_DOMAIN | Email domain does not exist.
-18 | ERROR_NON_ADMIN | Vendor does not have access to this feature.
-19 | ERROR_NEG_TRANS | Vendor cannot use negative credit.
-20 | ERROR_STRIPE | Error with stripe processing.
-21 | ERROR_INCORRECT_LOGIN | Login username/password incorrect.
-22 | ERROR_NO_SUCH_USER | Login username/password incorrect, or user ID does not exist.
-23 | ERROR_NOT_VERIFIED | User has not verified their account.
-24 | ERROR_ALREADY_VERIFIED | User already verified their account.
-25 | ERROR_NON_POST | Non post request used.
-26 | ERROR_APP_DISABLED | App or API has been disabled.
-27 | ERROR_NOT_SUPPORTED | App or API is not supported.
-28 | ERROR_NEW_CONFIG | New config available for download.
-29 | ERROR_NO_CONFIG_FOLDERS | No folder for config.
-30 | ERROR_NO_CONFIG_FILE | No config file present.
-31 | ERROR_NO_REWARD | No reward by this ID.
-32 | ERROR_WRONG_APP | User does not belong to this app.
-33 | ERROR_GC_ADD_CREDIT | Error adding credit to gift card.
-34 | ERROR_QR_CODE_HASH | Hash is invalid.
-35 | ERROR_NON_GC_TRANS | User ID is not a gift card.
-36 | ERROR_NEGATIVE_TIP | Cannot use negative tip.
-37 | ERROR_INVALID_GC | Invalid gift card.
-38 | ERROR_INVALID_GC_PIN | Invalid gift card PIN.
-39 | ERROR_PAYPAL_AUTH | PayPal authorization failed.
-40 | ERROR_PAYPAL_PAYMENT') | PayPal payment failed.
-41 | ERROR_UNKNOWN_PAYTYPE') | Unknown payment type.
-42 | ERROR_INVALID_PAYOBJECT') | Invalid pay object.
-43 | ERROR_NO_GATEWAY') | No gateway defined.
