<?php
class ModelExtensionDashboardSaleAdmin extends Model {
	public function getTotalSales($data = []) {
	    $args = [];
		$sql = "SELECT SUM(total) AS total FROM `oc_order` WHERE order_status_id > '0'";

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE(:date_added)";
            $args[':date_added'] = $data['filter_date_added'];
		}

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}

	public function getTotalOrdersByCountry() {
		$query = $this->db->query("SELECT COUNT(*) AS total, SUM(o.total) AS amount, c.iso_code_2 FROM `oc_order` o LEFT JOIN `oc_country` c ON (o.payment_country_id = c.country_id) WHERE o.order_status_id > '0' GROUP BY o.payment_country_id");

		return $query->rows;
	}

	public function getTotalOrdersByDay() {
		$implode = [];

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = [];

		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = array(
				'hour'  => $i,
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour FROM `oc_order` WHERE order_status_id IN(" . implode(",", $implode) . ") AND DATE(date_added) = DATE(NOW()) GROUP BY HOUR(date_added) ORDER BY date_added ASC");

		foreach ($query->rows as $result) {
			$order_data[$result['hour']] = array(
				'hour'  => $result['hour'],
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByWeek() {
		$implode = [];

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = [];

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$order_data[date('w', strtotime($date))] = array(
				'day'   => date('D', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `oc_order` WHERE order_status_id IN(" . implode(",", $implode) . ") AND DATE(date_added) >= DATE(:date_added) GROUP BY DAYNAME(date_added)",
            [
                ':date_added' => date('Y-m-d', $date_start)
            ]);

		foreach ($query->rows as $result) {
			$order_data[date('w', strtotime($result['date_added']))] = array(
				'day'   => date('D', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByMonth() {
		$implode = [];

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = [];

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `oc_order` WHERE order_status_id IN(" . implode(",", $implode) . ") AND DATE(date_added) >= :date_added GROUP BY DATE(date_added)",
            [
                ':date_added' => date('Y') . '-' . date('m') . '-1'
            ]);

		foreach ($query->rows as $result) {
			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByYear() {
		$implode = [];

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = [];

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
				'month' => date('M', mktime(0, 0, 0, $i)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `oc_order` WHERE order_status_id IN(" . implode(",", $implode) . ") AND YEAR(date_added) = YEAR(NOW()) GROUP BY MONTH(date_added)");

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getOrders($data = []) {
	    $args = [];
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(*) AS `orders`, SUM((SELECT SUM(op.quantity) FROM `oc_order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS products, SUM((SELECT SUM(ot.value) FROM `oc_order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id)) AS tax, SUM(o.total) AS `total` FROM `oc_order` o";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = :order_status";
            $arg[':order_status'] = $data['filter_order_status_id'];
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added)";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;
		}

		$sql .= " ORDER BY o.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql, $args);

		return $query->rows;
	}

	public function getTotalOrders($data = []) {
        $args = [];

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added), DAY(date_added)) AS total FROM `oc_order`";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), WEEK(date_added)) AS total FROM `oc_order`";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added)) AS total FROM `oc_order`";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added)) AS total FROM `oc_order`";
				break;
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE order_status_id = :order_status_id";
            $args[':order_status_id'] = $data['filter_order_status_id'];

		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
		}

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}

	public function getTaxes($data = []) {
	    $args = [];
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `oc_order` o LEFT JOIN `oc_order_total` ot ON (ot.order_id = o.order_id) WHERE ot.code = 'tax'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = :order_status_id";
            $args[':order_status_id'] = $data['filter_order_status_id'];
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
        }

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];

        }

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
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

		$query = $this->db->query($sql, $args);

		return $query->rows;
	}

	public function getTotalTaxes($data = []) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), WEEK(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
		}

		$sql .= " LEFT JOIN `oc_order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'tax'";
        $args = [];

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = :order_status_id";
            $args[':order_status_id'] = $data['filter_order_status_id'];
        } else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
        }

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
        }

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}

	public function getShipping($data = []) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `oc_order` o LEFT JOIN `oc_order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'shipping'";
        $args = [];

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = :order_status_id";
            $args[':order_status_id'] = $data['filter_order_status_id'];
        } else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
        }

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
        }

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
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

		$query = $this->db->query($sql, $args);

		return $query->rows;
	}

	public function getTotalShipping($data = []) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), WEEK(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), ot.title) AS total FROM `oc_order` o";
				break;
		}

		$sql .= " LEFT JOIN `oc_order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'shipping'";
        $args = [];

        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id = :order_status_id";
            $args[':order_status_id'] = $data['filter_order_status_id'];
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= :date_start";
            $args[':date_start'] = $data['filter_date_start'];
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= :date_end";
            $args[':date_end'] = $data['filter_date_end'];
        }

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}
}