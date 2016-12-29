<?php

require_once("./Services/Cron/classes/class.ilCronHookPlugin.php");
require_once("./Customizing/global/plugins/Services/Cron/CronHook/MPCUserSynchronization/classes/Cronjobs/class.ilMPCSuperiorJob.php");

class ilMPCUserSynchronizationPlugin extends ilCronHookPlugin {

	/**
	 * @return ilCronJob[] cron jobs.
	 */
	public function getCronJobInstances() {
		$job = new ilMPCSuperiorJob();

		return array($job);
	}

	/**
	 * @param $a_job_id
	 * @return ilMPCSuperiorJob
	 */
	public function getCronJobInstance($a_job_id) {
		return new ilMPCSuperiorJob();
	}

	/**
	 * Get Plugin Name. Must be same as in class name il<Name>Plugin
	 * and must correspond to plugins subdirectory name.
	 *
	 * Must be overwritten in plugin class of plugin
	 *
	 * @return    string    Plugin Name
	 */
	function getPluginName() {
		return "MPCUserSynchronization";
	}
}