<?php
class ModelCatalogReviewAdmin extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO `oc_review` SET author = :author, product_id = :product_id, text = :text, rating = :rating, status = :status",
            [
                ':author' => $data['author'],
                ':product_id' => $data['product_id'],
                ':text' => strip_tags($data['text']),
                ':rating' => $data['rating'],
                ':status' => $data['status']
            ]);

		$review_id = $this->db->getLastId();

		$this->cache->delete('product');

		return $review_id;
	}

	public function editReview($review_id, $data) {
		$this->db->query("UPDATE `oc_review` SET author = :author, product_id = :product_id, text = :text, rating = :rating, status = :status WHERE review_id = :review_id",
            [
                ':author' => $data['author'],
                ':product_id' => $data['product_id'],
                ':text' => strip_tags($data['text']),
                ':rating' => $data['rating'],
                ':status' => $data['status'],
                ':review_id' => $review_id
            ]);

		$this->cache->delete('product');
	}

	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM `oc_review` WHERE review_id = :review_id",
            [
                ':review_id' => $review_id,
            ]);

		$this->cache->delete('product');
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM `oc_product_description` pd WHERE pd.product_id = r.product_id AND pd.language_id = :language_id AS product FROM `oc_review` r WHERE r.review_id = :review_id",
            [
                ':language_id' => $this->config->get('config_language_id'),
                ':review_id' => $review_id
            ]);

		return $query->row;
	}

	public function getReviews($data = []) {
		$sql = "SELECT r.review_id, pd.name, r.author, r.rating, r.status, r.date_added FROM `oc_review` r LEFT JOIN `oc_product_description` pd ON (r.product_id = pd.product_id) WHERE pd.language_id = :language_id";

        $args[':language_id'] = $this->config->get('config_language_id');

		if (!empty($data['filter_product'])) {
			$sql .= " AND pd.name LIKE :name";
            $args[':name'] = $data['filter_product'] . '%';
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE :author";
            $args[':author'] = $data['filter_author'] . '%';
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = :status";
            $args[':status'] = $data['filter_status'];
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE(:date_added)";
            $args[':date_added'] = $data['filter_date_added'];
		}

		$sort_data = [
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

		$query = $this->db->query($sql, $args);

		return $query->rows;
	}

	public function getTotalReviews($data = []) {
		$sql = "SELECT COUNT(*) AS total FROM `oc_review` r LEFT JOIN `oc_product_description` pd ON (r.product_id = pd.product_id) WHERE pd.language_id = :language_id";

        $args[':language_id'] = $this->config->get('config_language_id');

		if (!empty($data['filter_product'])) {
			$sql .= " AND pd.name LIKE :name";
            $args['name'] = $data['filter_product'] . '%';
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE :author";
            $args[':author'] = $data['filter_author'] . '%';
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = :status";
            $args[':status'] = $data['filter_status'];
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE(:date_added)";
            $args[':date_added'] = $data['filter_date_added'];
		}

		$query = $this->db->query($sql, $args);

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `oc_review` WHERE status = '0'");

		return $query->row['total'];
	}
}