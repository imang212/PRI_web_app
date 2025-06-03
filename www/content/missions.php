<div class="pt-20 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-cyan-400 mb-8 text-center">Vesmírné mise</h1>

        <div class="space-y-8">
            <?php
            $missions = [
                [
                    "name" => "Kepler Space Telescope",
                    "status" => "Ukončena (2009-2018)",
                    "description" => "Mise Kepler objevila tisíce exoplanet pomocí tranzitní metody."
                ],
                [
                    "name" => "TESS (Transiting Exoplanet Survey Satellite)",
                    "status" => "Aktivní (2018-současnost)",
                    "description" => "TESS pokračuje v hledání exoplanet v celé obloze."
                ],
                [
                    "name" => "James Webb Space Telescope",
                    "status" => "Aktivní (2021-současnost)",
                    "description" => "Nejmodernější teleskop studuje atmosféry exoplanet."
                ]
            ];

            foreach ($missions as $mission) {
                echo '
                <div class="bg-gray-800 rounded-xl p-6 shadow-md">
                    <h3 class="text-2xl font-bold text-cyan-300 mb-2">' . $mission["name"] . '</h3>
                    <p class="text-cyan-400 mb-3 font-semibold">' . $mission["status"] . '</p>
                    <p class="text-gray-300">' . $mission["description"] . '</p>
                </div>
                ';
            }
            ?>
        </div>
    </div>
</div>
