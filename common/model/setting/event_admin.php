<?php
class ModelSettingEventAdmin extends Model {
	public function addEvent($code, $trigger, $action, $status = 1, $sort_order = 0) {
		$this->db->query("INSERT INTO `oc_event` SET `code` = '" . $this->db->escape($code) . "', `trigger` = '" . $this->db->escape($trigger) . "', `action` = '" . $this->db->escape($action) . "', `sort_order` = '" . (int)$sort_order . "', `status` = '" . (int)$status . "'");
	
		return $this->db->getLastId();
	}

	public function deleteEvent($event_id) {
		$this->db->query("DELETE FROM `oc_event` WHERE `event_id` = '" . (int)$event_id . "'");
	}
	
	public function deleteEventByCode($code) {
		$this->db->query("DELETE FROM `oc_event` WHERE `code` = '" . $this->db->escape($code) . "'");
	}

	public function editStatus($event_id, $status) {
		$this->db->query("UPDATE `oc_event` SET `status` = '" . (int)$status . "' WHERE event_id = '" . (int)$event_id . "'");
	}
	
	public function uninstall($type, $code) {
		$this->db->query("DELETE FROM `oc_extension` WHERE `type` = '" . $this->db->escape($type) . "' AND `code` = '" . $this->db->escape($code) . "'");
		$this->db->query("DELETE FROM `oc_setting` WHERE `code` = '" . $this->db->escape($code) . "'");
	}

	public function getEvent($event_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM `oc_event` WHERE `event_id` = '" . (int)$event_id . "' LIMIT 1");

		return $query->row;
	}

	public function getEventByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM `oc_event` WHERE `code` = '" . $this->db->escape($code) . "' LIMIT 1");

		return $query->row;
	}
		
	public function getEvents($data = array()) {
		$sql = "SELECT * FROM `oc_event`";

		$sort_data = array(
			'code',
			'trigger',
			'action',
			'sort_order',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY `" . $data['sort'] . "`";
		} else {
			$sql .= " ORDER BY `sort_order`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalEvents() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `oc_event`");

		return $query->row['total'];
	}
}