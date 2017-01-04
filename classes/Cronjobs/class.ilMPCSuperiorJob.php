<?php

require_once("./Services/Cron/classes/class.ilCronJob.php");
require_once('./Services/User/classes/class.ilObjUser.php');
require_once("./Modules/OrgUnit/classes/class.ilObjOrgUnit.php");

class ilMPCSuperiorJob extends ilCronJob {

	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId() {
		return "mpcSup";
	}

	/**
	 * Is to be activated on "installation"
	 *
	 * @return boolean
	 */
	public function hasAutoActivation() {
		return true;
	}

	/**
	 * Can the schedule be configured?
	 *
	 * @return boolean
	 */
	public function hasFlexibleSchedule() {
		return true;
	}

	/**
	 * Get schedule type
	 *
	 * @return int
	 */
	public function getDefaultScheduleType() {
		return ilCronJob::SCHEDULE_TYPE_IN_HOURS;
	}

	/**
	 * Get schedule value
	 *
	 * @return int|array
	 */
	function getDefaultScheduleValue() {
		return 1;
	}

	/**
	 * Run job
	 *
	 * @return ilCronJobResult
	 */
	public function run() {
		global $ilLog;
		$ilLog->write("hello world.");

		$user_ids = ilObjUser::searchUsers('', 1, true);
		$field_id = $this->getFieldIdWhereNameLike('Supervisor');
		$ilLog->write("Looking for field id: $field_id");
		if(!$field_id) {
			$ilLog->write("No field id for udf 'Supervisor'");
		} else {
			foreach($user_ids as $user_id) {
				$udata = new ilUserDefinedData($user_id);
				$superior_last_name = $udata->get("f_".$field_id);

				$ilLog->write("user with id $user_id has superior: $superior_last_name");
				$this->assignUserToLastName($superior_last_name, $user_id);

			}
		}

		$result = new ilCronJobResult();
		$result->setStatus(ilCronJobResult::STATUS_OK);
		return $result;
	}

	/**
	 * Assigns the user with $user_id to every orgunit where theres a supervisor with the lastname $last_name
	 *
	 * @param $last_name string
	 * @param $user_id int
	 */
	protected function assignUserToLastName($last_name, $user_id) {
		foreach($this->getUserIdsByLastName($last_name) as $superior_id) {
			$this->assignUserToSupervisor($superior_id, $user_id);
		}
	}

	/**
	 * Returns a list of all user ids which have th last name.
	 *
	 * @param $last_name string
	 * @return int[]
	 */
	protected function getUserIdsByLastName($last_name) {
		global $ilDB, $ilLog;

		$query = "SELECT usr_id FROM usr_data WHERE lastname LIKE '".$ilDB->quote($last_name, 'text')."'";
		$res = $ilDB->query($query);
		$userIds = array();

		while($row = $ilDB->fetchAssoc($res)) {
			$userIds[] = $row['usr_id'];
		}

		$ilLog->write("users with last name $last_name: ".implode(",", $userIds));
		return $userIds;
	}

	/**
	 * Assigns the $user_id as an employee to every org unit where $supervisor_id is a supervisor.
	 *
	 * @param $supervisor_id int
	 * @param $user_id int
	 */
	protected function assignUserToSupervisor($supervisor_id, $user_id) {
		global $ilLog;

		$orgu_ref_ids = $this->getOrgUnitsOfSuperior($supervisor_id);
		$ilLog->write("org units for superior: $supervisor_id: ".implode(", ", $orgu_ref_ids));
		foreach ($orgu_ref_ids as $orgu_ref_id) {
			$orgu = new ilObjOrgUnit($orgu_ref_id);
			$ilLog->write("Assigning user $user_id to ".$orgu->getTitle());
			$orgu->assignUsersToEmployeeRole(array($user_id));
		}
	}

	protected function getOrgUnitsOfSuperior($supervisor_id) {
		global $ilDB;

		$q = "SELECT DISTINCT refr.ref_id FROM object_data orgu
                INNER JOIN object_reference refr ON refr.obj_id = orgu.obj_id
				INNER JOIN object_data roles ON roles.title LIKE CONCAT('il_orgu_superior_',refr.ref_id)
				INNER JOIN rbac_ua rbac ON rbac.usr_id = ".$ilDB->quote($supervisor_id, "integer")." AND roles.obj_id = rbac.rol_id
				WHERE orgu.type = 'orgu' AND refr.deleted IS NULL";
		$set = $ilDB->query($q);
		$orgu_ref_ids = array();
		while($res = $ilDB->fetchAssoc($set)){
			$orgu_ref_ids[] = $res['ref_id'];
		}
		return $orgu_ref_ids;
	}


	/**
	 * Returns the id of the udf field where the name is %$name% and null if there's none.
	 *
	 * @param $name string
	 * @return null|int
	 */
	protected function getFieldIdWhereNameLike($name) {
		global $ilDB;

		$query = "SELECT field_id FROM udf_definition WHERE field_name LIKE '%".$ilDB->quote($name, "text")."%'";
		$res = $ilDB->query($query);
		if($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
			return $row['field_id'];
		}
		return null;
	}
}