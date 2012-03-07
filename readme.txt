This library consists of three parts:

-application-
This php file replaces the Ushahidi API
The output is XML or JSON in the GeoReport v2 format

-plugin-
Acts as an Open311 client - sends all submitted reports to an Open311 server using the GeoReport v2 format for POSTs 
You could change it to post only after a report is approved or verified
You will see "Open311 enabled" on the front page
Settings let you store username, password, and API key for Open311
TODO: use config for eventing (onReport, onApprove, or onVerify)
TODO: use config for category names
TODO: access the database for the API key

-v2-
OpenPlans project to make Ushahidi act as an Open311 server
Adapted here to include media_url, title, verified, active elements
Also added JSON support