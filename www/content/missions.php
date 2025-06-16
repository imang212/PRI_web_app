<div id="main" class="pt-20 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-cyan-400 mb-8 text-center" style="font-size: x-large; padding-bottom: 30px;">Vesmírné mise</h1>

        <div class="max-w-6xl mx-auto px-4 py-16 h-50 flex flex-wrap gap-10" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 6rem;">
            <?php
            $missions = [
                ["name" => "Kepler Space Telescope", "status" => "Ukončena (2009-2018)", "description" => "Mise Kepler objevila tisíce exoplanet pomocí tranzitní metody."],
                ["name" => "TESS (Transiting Exoplanet Survey Satellite)", "status" => "Aktivní (2018-současnost)", "description" => "TESS pokračuje v hledání exoplanet v celé obloze."],
                ["name" => "James Webb Space Telescope", "status" => "Aktivní (2021-současnost)", "description" => "Nejmodernější teleskop studuje atmosféry exoplanet."]
            ];
            foreach ($missions as $mission) {
                echo '
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-600 shadow-lg flex-1 min-w-80 h-48 md:h-56 lg:h-64 flex flex-col justify-center items-center" style="border-radius: 12px; padding: 24px; border: 1px solid #4b5563; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); flex: 1; min-width: 320px; height: 256px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h3 class="text-2xl font-bold text-cyan-300 mb-2">' . $mission["name"] . '</h3>
                    <p class="text-cyan-400 mb-3 font-semibold text-start">' . $mission["status"] . '</p>
                    <p class="text-gray-300">' . $mission["description"] . '</p>
                </div>
                ';
            }
            ?>
        </div>
    </div>
</div>
