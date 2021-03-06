<?php
class ModelLocalisationOrderStatus extends Model {
	public function getOrderStatus($order_status_id) {
		$query = $this->db->query("SELECT * FROM oc_order_status WHERE order_status_id = :order_status_id AND language_id = :language_id",
            [
                ':order_status_id' => $order_status_id,
                ':language_id' => $this->config->get('config_language_id')
            ]);

		return $query->row;
	}

	public function getOrderStatuses() {
		$order_status_data = $this->cache->get('order_status.' . (int)$this->config->get('config_language_id'));

		if (!$order_status_data) {
			$query = $this->db->query("SELECT order_status_id, name FROM oc_order_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name",
                [
                    ':language_id' => $this->config->get('config_language_id')
                ]);

			$order_status_data = $query->rows;

			$this->cache->set('order_status.' . (int)$this->config->get('config_language_id'), $order_status_data);
		}
		
		return $order_status_data;
	}
}