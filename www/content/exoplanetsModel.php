<?php
class ExoplanetModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllExoplanets($limit = 50, $offset = 0, $search = '', $filters = []) {
        $sql = "SELECT e.*,
                       pt.planet_type,
                       dm.detection_method,
                       mc.mass_category,
                       dc.distance_category,
                       oc.period_class,
                       bc.brightness_category,
                       de.discovery_era
                FROM exoplanets e
                LEFT JOIN dim_planet_type pt ON e.planet_type_id = pt.planet_type_id
                LEFT JOIN dim_detection_method dm ON e.detection_method_id = dm.detection_method_id
                LEFT JOIN dim_mass_category mc ON e.mass_category_id = mc.mass_category_id
                LEFT JOIN dim_distance_category dc ON e.distance_category_id = dc.distance_category_id
                LEFT JOIN dim_orbit_category oc ON e.orbit_category_id = oc.orbit_category_id
                LEFT JOIN dim_brightness_category bc ON e.brightness_category_id = bc.brightness_category_id
                LEFT JOIN dim_discovery_era de ON e.discovery_era_id = de.discovery_era_id
                WHERE 1=1";

        $params = [];
        // Vyhledávání podle názvu
        if (!empty($search)) {
            $sql .= " AND LOWER(e.name) LIKE LOWER(:search)";
            $params['search'] = '%' . $search . '%';
        }
        // Filtry
        if (!empty($filters['planet_type'])) {
            $sql .= " AND pt.planet_type = :planet_type";
            $params['planet_type'] = $filters['planet_type'];
        }
        if (!empty($filters['detection_method'])) {
            $sql .= " AND dm.detection_method = :detection_method";
            $params['detection_method'] = $filters['detection_method'];
        }
        if (!empty($filters['discovery_year_from'])) {
            $sql .= " AND e.discovery_year >= :year_from";
            $params['year_from'] = $filters['discovery_year_from'];
        }
        if (!empty($filters['discovery_year_to'])) {
            $sql .= " AND e.discovery_year <= :year_to";
            $params['year_to'] = $filters['discovery_year_to'];
        }
        if (!empty($filters['distance_max'])) {
            $sql .= " AND e.distance <= :distance_max";
            $params['distance_max'] = $filters['distance_max'];
        }

        $sql .= " ORDER BY e.name LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) { $stmt->bindValue(':' . $key, $value); }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countExoplanets($search = '', $filters = []) {
        $sql = "SELECT COUNT(*) as total FROM exoplanets e
                LEFT JOIN dim_planet_type pt ON e.planet_type_id = pt.planet_type_id
                LEFT JOIN dim_detection_method dm ON e.detection_method_id = dm.detection_method_id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND LOWER(e.name) LIKE LOWER(:search)";
            $params['search'] = '%' . $search . '%';
        }
        if (!empty($filters['planet_type'])) {
            $sql .= " AND pt.planet_type = :planet_type";
            $params['planet_type'] = $filters['planet_type'];
        }
        if (!empty($filters['detection_method'])) {
            $sql .= " AND dm.detection_method = :detection_method";
            $params['detection_method'] = $filters['detection_method'];
        }
        if (!empty($filters['discovery_year_from'])) {
            $sql .= " AND e.discovery_year >= :year_from";
            $params['year_from'] = $filters['discovery_year_from'];
        }
        if (!empty($filters['discovery_year_to'])) {
            $sql .= " AND e.discovery_year <= :year_to";
            $params['year_to'] = $filters['discovery_year_to'];
        }
        if (!empty($filters['distance_max'])) {
            $sql .= " AND e.distance <= :distance_max";
            $params['distance_max'] = $filters['distance_max'];
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getPlanetTypes() {
        $stmt = $this->db->query("SELECT DISTINCT planet_type FROM dim_planet_type ORDER BY planet_type");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getDetectionMethods() {
        $stmt = $this->db->query("SELECT DISTINCT detection_method FROM dim_detection_method ORDER BY detection_method");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function exportToXML($search = '', $filters = []) {
        $exoplanets = $this->getAllExoplanets(10000, 0, $search, $filters); // Export všech nalezených

        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $root = $xml->createElement('exoplanets');
        $root->setAttribute('exported_at', date('Y-m-d H:i:s'));
        $root->setAttribute('total_count', count($exoplanets));
        $xml->appendChild($root);

        foreach ($exoplanets as $planet) {
            $planetElement = $xml->createElement('exoplanet');
            foreach ($planet as $key => $value) {
                if ($value !== null && $value !== '') {
                    $element = $xml->createElement($key, htmlspecialchars($value));
                    $planetElement->appendChild($element);
                }
            }
            $root->appendChild($planetElement);
        }
        return $xml->saveXML();
    }
}
?>