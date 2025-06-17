<?php
class ExoplanetModel {
    private $db;

    public function __construct() {
        include_once "database.php";
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllExoplanets($limit = 50, $offset = 0, $search = '', $filters = []) {
        $sql = "SELECT *
                FROM exoplanets e
                LEFT JOIN dim_planet_type p ON e.planet_type = p.planet_type
                LEFT JOIN dim_detection_method d ON e.detection_method = d.detection_method
                LEFT JOIN dim_stellar_type s ON e.distance = s.distance AND e.stellar_magnitude = s.stellar_magnitude
                LEFT JOIN dim_mass_category m ON e.mass_multiplier = m.mass_multiplier
                LEFT JOIN dim_distance_category dc ON e.distance = dc.distance
                LEFT JOIN dim_orbit_category o ON e.orbital_period = o.orbital_period
                LEFT JOIN dim_brightness_category b ON e.stellar_magnitude = b.stellar_magnitude
                LEFT JOIN dim_discovery_era de ON e.discovery_year = de.discovery_year
                LEFT JOIN dim_date dt ON e.releasedate::DATE = dt.date
                WHERE 1=1";
        $params = [];
        // Vyhledávání podle názvu
        if (!empty($search)) {
            $sql .= " AND LOWER(e.name) LIKE LOWER(:search)";
            $params['search'] = '%' . $search . '%';
        }
        // Filtry
        if (!empty($filters['planet_type'])) {
            $sql .= " AND p.planet_type = :planet_type";
            $params['planet_type'] = $filters['planet_type'];
        }
        if (!empty($filters['detection_method'])) {
            $sql .= " AND d.detection_method = :detection_method";
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
                LEFT JOIN dim_planet_type pt ON e.planet_type = pt.planet_type
                LEFT JOIN dim_detection_method dm ON e.detection_method = dm.detection_method
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
    public function addExoplanet($data) {
        $sql = 'INSERT INTO exoplanets ("name", distance, stellar_magnitude, planet_type, discovery_year, mass_multiplier, mass_wrt, orbital_radius, orbital_period, eccentricity, detection_method)
            VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)';
        $stmt = $this->db->prepare($sql);
        #echo "<pre>"; print_r($data); echo "</pre>";
        return $stmt->execute([
            $data['name'], $data['distance'], $data['stellar_magnitude'], $data['planet_type'], $data['discovery_year'], $data['mass_multiplier'], $data['mass_wrt'], $data['orbital_radius'],
            $data['orbital_period'],$data['eccentricity'], $data['detection_method']
        ]);
    }
    public function deleteExoplanet($id) {
        $stmt = $this->db->prepare("DELETE FROM exoplanets WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getPlanetTypes() {
        $stmt = $this->db->query("SELECT DISTINCT planet_type FROM dim_planet_type ORDER BY planet_type");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getDetectionMethods() {
        $stmt = $this->db->query("SELECT DISTINCT detection_method FROM dim_detection_method ORDER BY detection_method");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function validateXMLWithXSD($xmlContent, $xsdPath) {
        $dom = new DOMDocument();
        $dom->loadXML($xmlContent);
        libxml_use_internal_errors(true);
        $isValid = $dom->schemaValidate($xsdPath);
        if (!$isValid) {
            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                echo "XSD Error: " . $error->message . "<br>";
            }
            libxml_clear_errors();
        }
        return $isValid;
    }
    public function exportToXML($search = '', $filters = []) {
        $exoplanets = $this->getAllExoplanets(10000, 0, $search, $filters); // Export všech nalezených
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $root = $xml->createElement('exoplanets');
        $root->setAttribute('exported_at', date('Y-m-d H:i:s'));
        $root->setAttribute('total_count', count($exoplanets));
        $xml->appendChild($root);

        $selectedColumns = ['name', 'distance', 'stellar_magnitude', 'planet_type', 'discovery_year', 'mass_multiplier', 'mass_wrt', 'orbital_radius', 'orbital_period', 'eccentricity', 'detection_method'];
        $validCount = 0;
        foreach ($exoplanets as $planet) {
            if (empty($planet['name'])) {
                continue;
            }
            $planetElement = $xml->createElement('exoplanet');

            foreach ($selectedColumns as $key) {
                if (isset($planet[$key]) && $planet[$key] !== '') {
                    $element = $xml->createElement($key, htmlspecialchars($planet[$key]));
                    $planetElement->appendChild($element);
                }
            }
            $root->appendChild($planetElement);
            $validCount++;
        }
        $root->setAttribute('total_count', $validCount);
        if (!$this->validateXMLWithXSD($xml->saveXML(), __DIR__ . '/exoplanets.xsd')) {
            die("XML is not valid.");
        }
        return $xml->saveXML();
    }

    public function importFromXML($xmlFile) {
        if (!file_exists($xmlFile)) {
            return false;
        }
        $xml = simplexml_load_file($xmlFile);
        $imported = 0;
        foreach ($xml->exoplanet as $planetXML) {
            $data = [
                'name' => trim((string)$planetXML->name) ?: null,
                'distance' => isset($planetXML->distance) && trim($planetXML->distance) !== '' ? (float)$planetXML->distance : null,
                'stellar_magnitude' => isset($planetXML->stellar_magnitude) && trim($planetXML->stellar_magnitude) !== '' ? (float)$planetXML->stellar_magnitude : null,
                'planet_type' => trim((string)$planetXML->planet_type) ?: null,
                'discovery_year' => isset($planetXML->discovery_year) && trim($planetXML->discovery_year) !== '' ? (int)$planetXML->discovery_year : null,
                'mass_multiplier' => isset($planetXML->mass_multiplier) && trim($planetXML->mass_multiplier) !== '' ? (float)$planetXML->mass_multiplier : null,
                'mass_wrt' => isset($planetXML->mass_wrt) && trim($planetXML->mass_wrt) !== '' ? (float)$planetXML->mass_wrt : null,
                'orbital_radius' => isset($planetXML->orbital_radius) && trim($planetXML->orbital_radius) !== '' ? (float)$planetXML->orbital_radius : null,
                'orbital_period' => isset($planetXML->orbital_period) && trim($planetXML->orbital_period) !== '' ? (float)$planetXML->orbital_period : null,
                'eccentricity' => isset($planetXML->eccentricity) && trim($planetXML->eccentricity) !== '' ? (float)$planetXML->eccentricity : null,
                'detection_method' => trim((string)$planetXML->detection_method) ?: null,
            ];

            if ($this->addExoplanet($data)) {
                $imported++;
            }
        }
        if (!$this->validateXMLWithXSD($xml->saveXML(), __DIR__ . '/exoplanets.xsd')) {
            die("XML is not valid.");
        }
        return $imported;
    }
}
?>