<?php
class ModelUserApiAdmin extends Model {
	public function addApi($data) {
		$this->db->query("INSERT INTO `oc_api` SET username = '" . $this->db->escape((string)$data['username']) . "', `key` = '" . $this->db->escape((string)$data['key']) . "', status = '" . (int)$data['status'] . "'");

		$api_id = $this->db->getLastId();

		if (isset($data['api_ip'])) {
			foreach ($data['api_ip'] as $ip) {
				if ($ip) {
					$this->db->query("INSERT INTO `oc_api_ip` SET api_id = '" . (int)$api_id . "', ip = '" . $this->db->escape($ip) . "'");
				}
			}
		}
		
		return $api_id;
	}

	public function editApi($api_id, $data) {
		$this->db->query("UPDATE `oc_api` SET username = '" . $this->db->escape((string)$data['username']) . "', `key` = '" . $this->db->escape((string)$data['key']) . "', status = '" . (int)$data['status'] . "' WHERE api_id = '" . (int)$api_id . "'");

		$this->db->query("DELETE FROM oc_api_ip WHERE api_id = '" . (int)$api_id . "'");

		if (isset($data['api_ip'])) {
			foreach ($data['api_ip'] as $ip) {
				if ($ip) {
					$this->db->query("INSERT INTO `oc_api_ip` SET api_id = '" . (int)$api_id . "', ip = '" . $this->db->escape($ip) . "'");
				}
			}
		}
	}

	public function deleteApi($api_id) {
		$this->db->query("DELETE FROM `oc_api` WHERE api_id = '" . (int)$api_id . "'");
	}

	public function getApi($api_id) {
		$query = $this->db->query("SELECT * FROM `oc_api` WHERE api_id = '" . (int)$api_id . "'");

		return $query->row;
	}

	public function getApis($data = array()) {
		$sql = "SELECT * FROM `oc_api`";

		$sort_data = array(
			'username',
			'status',
			'date_added',
			'date_modified'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY username";
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

	public function getTotalApis() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `oc_api`");

		return $query->row['total'];
	}

	public function addApiIp($api_id, $ip) {
		$this->db->query("INSERT INTO `oc_api_ip` SET api_id = '" . (int)$api_id . "', ip = '" . $this->db->escape($ip) . "'");
	}

	public function getApiIps($api_id) {
		$query = $this->db->query("SELECT * FROM `oc_api_ip` WHERE api_id = '" . (int)$api_id . "'");

		return $query->rows;
	}

	public function addApiSession($api_id, $session_id, $ip) {
		$api_ip_query = $this->db->query("SELECT * FROM `oc_api_ip` WHERE ip = '" . $this->db->escape($ip) . "'");
		
		if (!$api_ip_query->num_rows) {
			$this->db->query("INSERT INTO `oc_api_ip` SET api_id = '" . (int)$api_id . "', ip = '" . $this->db->escape($ip) . "'");
		}
 		
		$this->db->query("INSERT INTO `oc_api_session` SET api_id = '" . (int)$api_id . "', session_id = '" . $this->db->escape($session_id) . "', ip = '" . $this->db->escape($ip) . "'");

		return $this->db->getLastId();
	}
	
	public function getApiSessions($api_id) {
		$query = $this->db->query("SELECT * FROM `oc_api_session` WHERE api_id = '" . (int)$api_id . "'");

		return $query->rows;
	}
	
	public function deleteApiSession($api_session_id) {
		$this->db->query("DELETE FROM `oc_api_session` WHERE api_session_id = '" . (int)$api_session_id . "'");
	}
	
	public function deleteApiSessionBySessonId($session_id) {
		$this->db->query("DELETE FROM `oc_api_session` WHERE session_id = '" . $this->db->escape($session_id) . "'");
	}		
}