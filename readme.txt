
This library consists of two parts:

-application-
This php file replaces the Ushahidi API
The output is XML or JSON in the GeoReport v2 format
TODO: use the official REST interface instead of /api?task=incidents&resp=xml and other Ushahidi API parameters

-plugin-
Open311 posts all submitted reports to an Open311 server using the GeoReport v2 format for POSTs 
You could change it to post only after a report is approved or verified
You will see "Open311 enabled" on the front page
Settings let you store username, password, and API key for Open311

TODO: use config for eventing (onReport, onApprove, or onVerify)
TODO: use config for category names
TODO: access the database for the API key