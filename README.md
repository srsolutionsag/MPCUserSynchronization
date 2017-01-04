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
