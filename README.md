MPCUserSync
----------
There needs to be a user defined field with the string "Supervisor" in it. If given the cron job will assign users as employees to orgunits where one of the superiors' last name is equal to the string given in the users "Supervisor" user defined field.

Installation
------------
```
mkdir -p Customizing/global/plugins/Services/Cron/CronHook
cd Customizing/global/plugins/Services/Cron/CronHook
git clone https://github.com/studer-raimann/MPCUserSynchronization.git
```
Make sure you have your ILIAS cronjob activated. $cronUser is a ILIAS user E.g.:
```
*/5 * * * * php /var/www/ilias_44/cron/cron.php $cronUser $cronUserPassword $iliasClient
``` 
You can activate the plugin in the Administration.

If you want to run the Job manually goto: Administration -> General Settings -> Cron Jobs -> Click on "Execute" at pl__MPCUserSynchronization__mpcSup


###Hinweis Plugin-Patenschaft
Grundsätzlich veröffentlichen wir unsere Plugins (Extensions, Add-Ons), weil wir sie für alle Community-Mitglieder zugänglich machen möchten. Auch diese Extension wird der ILIAS Community durch die studer + raimann ag als open source zur Verfügung gestellt. Diese Plugin hat noch keinen Plugin-Paten. Das bedeutet, dass die studer + raimann ag etwaige Fehlerbehebungen, Supportanfragen oder die Release-Pflege lediglich für Kunden mit entsprechendem Hosting-/Wartungsvertrag leistet. Falls Sie nicht zu unseren Hosting-Kunden gehören, bitten wir Sie um Verständnis, dass wir leider weder kostenlosen Support noch Release-Pflege für Sie garantieren können.

Sind Sie interessiert an einer Plugin-Patenschaft (https://studer-raimann.ch/produkte/ilias-plugins/plugin-patenschaften/ ) Rufen Sie uns an oder senden Sie uns eine E-Mail.
