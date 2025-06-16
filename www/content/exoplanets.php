<?php
$model = new ExoplanetModel();
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
    $xml = $model->exportToXML($search, $filters);
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="exoplanets_' . date('Y-m-d_H-i-s') . '.xml"');
    echo $xml;
    exit;
}
// Načtení dat
$exoplanets = $model->getAllExoplanets($perPage, $offset, $search, $filters);
$totalCount = $model->countExoplanets($search, $filters);
$totalPages = ceil($totalCount / $perPage);
// Načtení možností pro filtry
$planetTypes = $model->getPlanetTypes();
$detectionMethods = $model->getDetectionMethods();
?>
<div class="pt-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-cyan-400 mb-8 text-center">Katalog Exoplanet</h1>
        <div class="bg-gray-800 rounded-xl p-6 mb-8">
            <form method="GET" class="space-y-4">
                <input type="hidden" name="page" value="exoplanets">
                <!-- Vyhledávání -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-cyan-300 mb-2">Hledat podle názvu:</label>
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Název exoplanety..." class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Maximální vzdálenost (ly):</label>
                        <input type="number" name="distance_max" value="<?php echo htmlspecialchars($filters['distance_max']); ?>" placeholder="např. 100" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                    </div>
                </div>
                <!-- Filtry -->
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-cyan-300 mb-2">Typ planety:</label>
                        <select name="planet_type" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                            <option value="">Všechny typy</option>
                            <?php foreach ($planetTypes as $type): ?>
                                <option value="<?php echo htmlspecialchars($type); ?>"
                                        <?php echo $filters['planet_type'] === $type ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($type); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Metoda detekce:</label>
                        <select name="detection_method" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                            <option value="">Všechny metody</option>
                            <?php foreach ($detectionMethods as $method): ?>
                                <option value="<?php echo htmlspecialchars($method); ?>"
                                        <?php echo $filters['detection_method'] === $method ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($method); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Rok objevení od:</label>
                        <input type="number" name="year_from" value="<?php echo htmlspecialchars($filters['discovery_year_from']); ?>" min="1990" max="2025" placeholder="1995" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Rok objevení do:</label>
                        <input type="number" name="year_to" value="<?php echo htmlspecialchars($filters['discovery_year_to']); ?>" min="1990" max="2025" placeholder="2025" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-cyan-400 focus:outline-none">
                    </div>
                </div>
                <!-- Tlačítka -->
                <div class="flex flex-wrap gap-4">
                    <button type="submit" class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-semibold rounded-lg transition">🔍 Vyhledat</button>
                    <a href="?page=exoplanets" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition">🔄 Resetovat</a>
                    <button type="submit" name="export" value="xml" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">📥 Export XML</button>
                </div>
            </form>
        </div>

        <div class="mb-6">
            <p class="text-gray-300">
                Nalezeno <strong class="text-cyan-400"><?php echo number_format($totalCount); ?></strong> exoplanet
                <?php if ($search || array_filter($filters)): ?>
                    odpovídajících vašim kritériím
                <?php endif; ?>
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <?php foreach ($exoplanets as $planet): ?>
                <div class="bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-cyan-300 mb-3"><?php echo htmlspecialchars($planet['name']); ?></h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <?php if ($planet['planet_type']): ?>
                            <div>
                                <span class="text-gray-400">Typ:</span>
                                <span class="text-white"><?php echo htmlspecialchars($planet['planet_type']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['distance']): ?>
                            <div>
                                <span class="text-gray-400">Vzdálenost:</span>
                                <span class="text-white"><?php echo number_format($planet['distance'], 1); ?> ly</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['discovery_year']): ?>
                            <div>
                                <span class="text-gray-400">Objevena:</span>
                                <span class="text-white"><?php echo $planet['discovery_year']; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['detection_method']): ?>
                            <div>
                                <span class="text-gray-400">Metoda:</span>
                                <span class="text-white"><?php echo htmlspecialchars($planet['detection_method']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['mass_multiplier']): ?>
                            <div>
                                <span class="text-gray-400">Hmotnost:</span>
                                <span class="text-white"><?php echo number_format($planet['mass_multiplier'], 2); ?>x <?php echo $planet['mass_wrt'] ?? 'Země'; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['radius_multiplier']): ?>
                            <div>
                                <span class="text-gray-400">Poloměr:</span>
                                <span class="text-white"><?php echo number_format($planet['radius_multiplier'], 2); ?>x <?php echo $planet['radius_wrt'] ?? 'Země'; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['orbital_period']): ?>
                            <div>
                                <span class="text-gray-400">Oběžná doba:</span>
                                <span class="text-white"><?php echo number_format($planet['orbital_period'], 1); ?> dní</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($planet['stellar_magnitude']): ?>
                            <div>
                                <span class="text-gray-400">Magnituda hvězdy:</span>
                                <span class="text-white"><?php echo number_format($planet['stellar_magnitude'], 2); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($planet['mass_category'] || $planet['distance_category'] || $planet['discovery_era']): ?>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <?php if ($planet['mass_category']): ?>
                                <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['mass_category']); ?></span>
                            <?php endif; ?>
                            <?php if ($planet['distance_category']): ?>
                                <span class="px-2 py-1 bg-green-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['distance_category']); ?></span>
                            <?php endif; ?>
                            <?php if ($planet['discovery_era']): ?>
                                <span class="px-2 py-1 bg-purple-600 text-white text-xs rounded"><?php echo htmlspecialchars($planet['discovery_era']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="flex justify-center space-x-2">
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