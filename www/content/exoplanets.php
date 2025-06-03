<div class="pt-20 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-cyan-400 mb-8 text-center">Katalog Exoplanet</h1>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $exoplanets = [
                ["name" => "Kepler-452b", "type" => "Super-Země", "distance" => "1,400 světelných let"],
                ["name" => "Proxima Centauri b", "type" => "Zemského typu", "distance" => "4.24 světelných let"],
                ["name" => "TRAPPIST-1e", "type" => "Zemského typu", "distance" => "40 světelných let"],
                ["name" => "HD 209458 b", "type" => "Horký Jupiter", "distance" => "159 světelných let"],
                ["name" => "55 Cancri e", "type" => "Super-Země", "distance" => "41 světelných let"],
                ["name" => "WASP-121b", "type" => "Horký Jupiter", "distance" => "855 světelných let"]
            ];
            foreach ($exoplanets as $planet) {
                echo '
                <div class="bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-cyan-300 mb-2">' . $planet["name"] . '</h3>
                    <p class="text-gray-300 mb-1"><strong>Typ:</strong> ' . $planet["type"] . '</p>
                    <p class="text-gray-300"><strong>Vzdálenost:</strong> ' . $planet["distance"] . '</p>
                </div>
                ';
            }
            ?>
        </div>
    </div>
</div>