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
