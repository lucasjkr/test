<?php
class ModelExtensionShippingWeight extends Model {
	public function getQuote($address) {
		$this->load->language('extension/shipping/weight');

		$quote_data = [];

		$query = $this->db->query("SELECT * FROM oc_geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('shipping_weight_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM oc_zone_to_geo_zone WHERE geo_zone_id = :geo_zone_id AND country_id = :country_id AND (zone_id = :zone_id_1 OR zone_id = :zone_id_2)",
                    [
                        ':geo_zone_id' => $result['geo_zone_id'],
                        ':country_id' => $address['country_id'],
                        ':zone_id_1' => $address['zone_id'],
                        ':zone_id_2' => 0
                    ]);

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}

			if ($status) {
				$cost = '';
				$weight = $this->cart->getWeight();

				$rates = explode(',', $this->config->get('shipping_weight_' . $result['geo_zone_id'] . '_rate'));

				foreach ($rates as $rate) {
					$data = explode(':', $rate);

					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}

						break;
					}
				}

				if ((string)$cost != '') {
					$quote_data['weight_' . $result['geo_zone_id']] = [
						'code'         => 'weight.weight_' . $result['geo_zone_id'],
						'title'        => $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('shipping_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('shipping_weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
                    ];
				}
			}
		}

		$method_data = [];

		if ($quote_data) {
			$method_data = [
				'code'       => 'weight',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_weight_sort_order'),
				'error'      => false
            ];
		}

		return $method_data;
	}
}
