# Errors

This API uses the following error codes:

Error Code | String | Description
---------- | ------- | -------
0 | ERROR_NONE | Success.
-3 | ERROR_NO_ACCOUNT_FOUND | User ID not found.
-7 | ERROR_NO_FUNCTION | Method name is incorrect.
-9 | ERROR_NO_HTTPS | HTTPS is not being used.
-10 | ERROR_AUTH_FAIL | Login username/password incorrect.
-11 | ERROR_NSF | Customer does not have sufficient credit on their account.
-12 | ERROR_NSP | Customer does not have sufficient points on their account.
-18 | ERROR_NON_ADMIN | Vendor does not have access to this feature.
-19 |	ERROR_NEG_TRANS	| Negative transaction amount entered.  Only positive transactions amounts are allowed.
-21 | ERROR_INCORRECT_LOGIN | Login username/password incorrect.
-22 | ERROR_NO_SUCH_USER | Login username/password incorrect, or user ID does not exist.
-23 | ERROR_NOT_VERIFIED | User has not verified their account.
-25 | ERROR_NON_POST | Non post request used.
-26 | ERROR_APP_DISABLED | App or API has been disabled.
-27 | ERROR_NOT_SUPPORTED | App or API is not supported.
-31 | ERROR_NO_REWARD	| Invalid Reward ID.  This is an invalid or deleted reward.
-32 | ERROR_WRONG_APP | User does not belong to this app.
-33 |	ERROR_GC_ADD_CREDIT	| Error adding credit to gift card.
-34 | ERROR_QR_CODE_HASH | QR Code embedded hash is incorrect or invalid.
-35 |	ERROR_NON_GC_TRANS | This QR code is not a physical gift card or is an invalid gift card.
-36 |	ERROR_NEGATIVE_TIP | Tip amount entered is less than 0.  Only positive tip amounts are allowed.
-57 | ERROR_INVALID_SUBDOMAIN | Invalid subdomain (entered during signup) provided.
-59 | ERROR_INVALID_JSON | Incorrect or malformed JSON request.
