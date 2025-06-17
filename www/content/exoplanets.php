<?php
include 'exoplanetsModel.php';
$model = new ExoplanetModel();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if ($model->addExoplanet($_POST)) {
                    $message = '<div class="alert success text-center">Exoplaneta byla úspěšně přidána!</div>';
                } else {
                    $message = '<div class="alert error text-center">Chyba při přidávání exoplanety!</div>';
                }
                break;
            case 'delete':
                if ($model->deleteExoplanet($_POST['id'])) {
                    $message = '<div class="alert success text-center">Exoplaneta byla smazána!</div>';
                } else {
                    $message = '<div class="alert error text-center">Chyba při mazání!</div>';
                }
                break;
        }
    }
    if (isset($_FILES['xml_file']) && $_FILES['xml_file']['error'] === 0) {
        $uploaded = $model->importFromXML($_FILES['xml_file']['tmp_name']);
        if ($uploaded > 0) {
            $message = '<div class="alert success text-center">Importováno ' . $uploaded . ' exoplanet z XML!</div>';
        } else {
            $message = '<div class="alert error text-center">Chyba při importu XML!</div>';
        }
    }
}
// Zpracování parametrů
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;
$search = $_GET['search'] ?? '';
$filters = ['planet_type' => $_GET['planet_type'] ?? '', 'detection_method' => $_GET['detection_method'] ?? '',
    'discovery_year_from' => $_GET['year_from'] ?? '', 'discovery_year_to' => $_GET['year_to'] ?? '',
    'distance_max' => $_GET['distance_max'] ?? '' ];
// Export do XML
if (isset($_GET['export']) && $_GET['export'] === 'xml') {
    ob_clean();
    $xml = $model->exportToXML($search, $filters);
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="exoplanets_' . date('Y-m-d_H-i-s') . '.xml"');
    echo $xml;
    exit;
}
ob_end_flush();
// Načtení dat
$exoplanets = $model->getAllExoplanets($perPage, $offset, $search, $filters);
$totalCount = $model->countExoplanets($search, $filters);
$totalPages = ceil($totalCount / $perPage);
// Načtení možností pro filtry
$planetTypes = $model->getPlanetTypes();
$detectionMethods = $model->getDetectionMethods();

$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$distanceMax = isset($_GET['distance_max']) ? htmlspecialchars($_GET['distance_max']) : '';
$planetType = isset($_GET['planet_type']) ? $_GET['planet_type'] : '';
$detectionMethod = isset($_GET['detection_method']) ? $_GET['detection_method'] : '';
$yearFrom = isset($_GET['year_from']) ? htmlspecialchars($_GET['year_from']) : '';
$yearTo = isset($_GET['year_to']) ? htmlspecialchars($_GET['year_to']) : '';
?>
<style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:Arial,sans-serif;background-color:#111827;color:#fff}.form-container{background-color:#1f2937;border-radius:12px;border:2px solid #374151;padding:24px;margin-bottom:32px;max-width:1250px;margin:0 auto}.form-content{display:flex;flex-direction:column;gap:20px}.form-row{display:flex;flex-wrap:wrap;gap:16px}.form-row.search-row .form-group{flex:1;min-width:300px}.form-row.filter-row .form-group{flex:1;min-width:250px}.form-group{display:flex;flex-direction:column}.form-label{color:#67e8f9;margin-bottom:8px;font-size:16px;font-weight:500}.form-input,.form-select{width:100%;padding:12px;background-color:#374151;color:#fff;border:2px solid #4b5563;border-radius:8px;font-size:16px;transition:border-color .3s}.form-input:focus,.form-select:focus{outline:none;border-color:#22d3ee}.form-input::placeholder{color:#9ca3af}.button-row{display:flex;flex-wrap:wrap;gap:16px;margin-top:8px}.btn{padding:12px 24px;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;transition:all .3s;min-width:140px}.btn-primary{background-color:#06b6d4;color:#000}.btn-primary:hover{background-color:#0891b2}.btn-secondary{background-color:#4b5563;color:#fff}.btn-secondary:hover{background-color:#374151}.btn-success{background-color:#059669;color:#fff}.btn-success:hover{background-color:#047857}@media(max-width:768px){.form-row.search-row .form-group,.form-row.filter-row .form-group{min-width:100%}.btn{min-width:100%}.form-container{padding:16px}}.results-info{margin-bottom:24px;color:#d1d5db;font-size:16px}.results-count{color:#22d3ee;font-weight:bold}.exoplanet-grid{display:flex;flex-wrap:wrap;gap:24px;margin-bottom:32px}.exoplanet-card{background-color:#1f2937;border:2px solid #374151;border-radius:12px;padding:24px;flex:1;min-width:450px;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:all .3s}.exoplanet-card:hover{box-shadow:0 20px 25px rgba(0,0,0,.25);transform:translateY(-2px)}.planet-name{color:#67e8f9;font-size:20px;font-weight:bold;margin-bottom:12px}.planet-details{display:flex;flex-wrap:wrap;gap:16px;font-size:14px}.detail-item{flex:1;min-width:180px;display:flex;flex-direction:column;gap:2px}.detail-label{color:#9ca3af}.detail-value{color:#fff;font-weight:500}.planet-tags{margin-top:16px;display:flex;flex-wrap:wrap;gap:8px}.tag{padding:4px 8px;border-radius:4px;color:#fff;font-size:12px;font-weight:500}.tag-mass{background-color:#2563eb}.tag-distance{background-color:#059669}.tag-era{background-color:#7c3aed}.pagination{display:flex;justify-content:center;align-items:center;gap:8px;margin-top:32px}.pagination-btn{padding:8px 16px;border:2px solid #4b5563;border-radius:8px;text-decoration:none;font-weight:500;transition:all .3s;color:#fff;background-color:#374151;min-width:44px;text-align:center}.pagination-btn:hover{background-color:#4b5563;transform:translateY(-1px)}.pagination-btn.active{background-color:#06b6d4;color:#000;border-color:#06b6d4}.pagination-btn.active:hover{background-color:#0891b2}@media(max-width:1024px){.exoplanet-card{min-width:100%}}@media(max-width:768px){.container{padding:0 10px}.exoplanet-card{padding:16px;min-width:100%}.detail-item{min-width:140px}.pagination{flex-wrap:wrap}.pagination-btn{min-width:40px;padding:6px 12px}}@media(max-width:480px){.detail-item{min-width:100%}.planet-details{gap:12px}
.alert { padding:16px; padding-top: 0; padding-bottom: 10px;margin:0;border-radius:8px; border:2px solid; font-size:16px; font-weight:500; display:flex; align-items:center; gap:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1); animation:slideInDown 0.3s ease-out; }.alert.success{background-color:#065f46;border-color:#059669;color:#d1fae5;}.alert.success:before{content:"✅";font-size:18px;}.alert.error{background-color:#7f1d1d;border-color:#dc2626;color:#fecaca;}.alert.error:before{content:"❌";font-size:18px;}.alert.warning{background-color:#92400e;border-color:#d97706;color:#fed7aa;}.alert.warning:before{content:"⚠️";font-size:18px;}.alert.info{background-color:#1e3a8a;border-color:#3b82f6;color:#dbeafe;}.alert.info:before{content:"ℹ️";font-size:18px;}@keyframes slideInDown{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}.alert:hover{transform:translateY(-1px);box-shadow:0 6px 12px rgba(0,0,0,0.15);transition:all 0.2s ease;}.alert .close-btn{margin-left:auto;background:none;border:none;color:inherit;font-size:20px;cursor:pointer;padding:0;opacity:.7;transition:opacity .2s ease;}.alert .close-btn:hover{opacity:1;}@media (max-width:768px){.alert{padding:12px 16px;font-size:14px;margin:12px 0;}.alert:before{font-size:16px;}}.messages-container{position:fixed;z-index:1000;max-width:400px;}.messages-container .alert{margin-bottom:10px; padding-top: -40px;box-shadow:0 8px 25px rgba(0,0,0,0.2);}.alert.inline{position:relative;margin:16px auto;max-width:800px;}}</style>
<div id="main" class="pt-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-4xl text-lg font-bold text-cyan-400 mb-10 text-center" style="font-size: 24px; margin-bottom: 5px;">Katalog Exoplanet</h1>
        <div class="messages-container" style="min-height: 15px; max-height: 15px; padding-top: -10px;">
            <?php if (isset($message)): ?>
                <?php echo $message; ?>
            <?php endif; ?>
        </div>
        <div class="form-container" style="margin-bottom: 10px; margin-top: 10px;">
        <form method="GET" class="form-content">
            <input type="hidden" name="page" value="exoplanets">
            <!-- Vyhledávání -->
            <div class="form-row search-row">
                <div class="form-group">
                    <label class="form-label">Hledat podle názvu:</label>
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Název exoplanety..." class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Maximální vzdálenost (ly):</label>
                    <input type="number" name="distance_max" value="<?php echo $distanceMax; ?>" placeholder="např. 100" class="form-input">
                </div>
            </div>
            <!-- Filtry -->
            <div class="form-row filter-row">
                <div class="form-group">
                    <label class="form-label">Typ planety:</label>
                    <select name="planet_type" class="form-select">
                        <option value="">Všechny typy</option>
                        <option value="Super Earth" <?php echo ($planetType == 'Super Earth') ? 'selected' : ''; ?>>Super Earth</option>
                        <option value="Neptune-like" <?php echo ($planetType == 'Neptune-like') ? 'selected' : ''; ?>>Neptune-like</option>
                        <option value="Gas Giant" <?php echo ($planetType == 'Gas Giant') ? 'selected' : ''; ?>>Gas Giant</option>
                        <option value="Terrestrial" <?php echo ($planetType == 'Terrestrial') ? 'selected' : ''; ?>>Terrestrial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Metoda detekce:</label>
                    <select name="detection_method" class="form-select">
                        <option value="">Všechny metody</option>
                        <option value="Transit" <?php echo ($detectionMethod == 'Transit') ? 'selected' : ''; ?>>Transit</option>
                        <option value="Radial Velocity" <?php echo ($detectionMethod == 'Radial Velocity') ? 'selected' : ''; ?>>Radial Velocity</option>
                        <option value="Imaging" <?php echo ($detectionMethod == 'Imaging') ? 'selected' : ''; ?>>Imaging</option>
                        <option value="Microlensing" <?php echo ($detectionMethod == 'Microlensing') ? 'selected' : ''; ?>>Microlensing</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Rok objevení od:</label>
                    <input type="number" name="year_from" value="<?php echo $yearFrom; ?>" min="1990" max="2025" placeholder="1995" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Rok objevení do:</label>
                    <input type="number" name="year_to" value="<?php echo $yearTo; ?>" min="1990" max="2025" placeholder="2025" class="form-input">
                </div>
            </div>
            <div class="button-row">
                <button type="submit" class="btn btn-primary">🔍 Vyhledat</button>
                <a href="?page=exoplanets" class="btn btn-secondary">🔄 Resetovat</a>
                <button type="submit" name="export" value="xml" class="btn btn-success">📥 Export XML</button>
            </div>
        </form>
    </div>
        <div class="section mb-10" style="margin-bottom: 30px;">
            <form method="POST" enctype="multipart/form-data">
                <div class="button-row">
                    <div class="form-group" style="max-width: 400px;">
                        <label>Vyberte XML soubor:</label>
                        <input type="file" name="xml_file" accept=".xml" required>
                    </div>
                    <button type="submit" class="btn btn-primary">📤 Importovat</button>
                </div>
            </form>
        </div>

        <div class="results-info mb-6">
            <p class="text-gray-300">
                Nalezeno <strong class="results-count text-cyan-400"><?php echo number_format($totalCount); ?></strong> exoplanet
                <?php if ($search || array_filter($filters)): ?>
                    odpovídajících vašim kritériím
                <?php endif; ?>
            </p>
        </div>
        <div class="exoplanet-grid grid lg:grid-cols-2 gap-6 mb-8">
            <?php foreach ($exoplanets as $planet): ?>
                <div class="exoplanet-card bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-xl transition">
                    <h3 class="planet-name text-xl font-bold text-cyan-300 mb-3"><?php echo htmlspecialchars($planet['name']); ?></h3>
                    <div class="planet-details grid grid-cols-2 gap-4 text-sm">
                        <?php if ($planet['planet_type']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Typ:</span>
                                <span class="detail-value text-white"><?php echo htmlspecialchars($planet['planet_type']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['distance']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Vzdálenost:</span>
                                <span class="detail-value text-white"><?php echo number_format($planet['distance'], 1); ?> ly</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['discovery_year']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Objevena:</span>
                                <span class="detail-value text-white"><?php echo $planet['discovery_year']; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['detection_method']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Metoda:</span>
                                <span class="detail-value text-white"><?php echo htmlspecialchars($planet['detection_method']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['mass_multiplier']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Hmotnost:</span>
                                <span class="detail-value text-white"><?php echo number_format($planet['mass_multiplier'], 2); ?>x <?php echo $planet['mass_wrt'] ?? 'Země'; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['radius_multiplier']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Poloměr:</span>
                                <span class="detail-value text-white"><?php echo number_format($planet['radius_multiplier'], 2); ?>x <?php echo $planet['radius_wrt'] ?? 'Země'; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['orbital_period']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Oběžná doba:</span>
                                <span class="detail-value text-white"><?php echo number_format($planet['orbital_period'], 1); ?> dní</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['stellar_magnitude']): ?>
                            <div class="detail-item">
                                <span class="detail-label text-gray-400">Magnituda hvězdy:</span>
                                <span class="detail-value text-white"><?php echo number_format($planet['stellar_magnitude'], 2); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($planet['mass_category'] || $planet['distance_category'] || $planet['discovery_era']): ?>
                        <div class="planet-tags mt-4 flex flex-wrap gap-2">
                            <?php if ($planet['mass_category']): ?>
                                <span class="tag tag-mass px-2 py-1 bg-blue-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['mass_category']); ?></span>
                            <?php endif; ?>
                            <?php if ($planet['distance_category']): ?>
                                <span class="tag tag-distance px-2 py-1 bg-green-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['distance_category']); ?></span>
                            <?php endif; ?>
                            <?php if ($planet['discovery_era']): ?>
                                <span class="tag tag-era px-2 py-1 bg-purple-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['discovery_era']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination flex justify-center space-x-2">
                <?php
                $baseUrl = '?page=exoplanets';
                if ($search) $baseUrl .= '&search=' . urlencode($search);
                foreach ($filters as $key => $value) {
                    if ($value) $baseUrl .= '&' . $key . '=' . urlencode($value);
                }
                ?>

                <?php if ($page > 1): ?>
                    <a href="<?php echo $baseUrl; ?>&p=<?php echo $page - 1; ?>" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">‹ Předchozí</a>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($totalPages, $page + 2);
                for ($i = $start; $i <= $end; $i++):
                ?>
                    <a href="<?php echo $baseUrl; ?>&p=<?php echo $i; ?>" class="px-4 py-2 <?php echo $i === $page ? 'bg-cyan-500 text-black' : 'bg-gray-700 hover:bg-gray-600 text-white'; ?> rounded-lg transition"> <?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="<?php echo $baseUrl; ?>&p=<?php echo $page + 1; ?>" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">Další ›</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>