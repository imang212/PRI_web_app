<div class="pt-20">
    <header class="text-center py-24 px-4 bg-gradient-to-b from-gray-900 to-black">
        <h1 class="text-4xl md:text-6xl font-extrabold text-cyan-400 mb-4">Objevuj tajemné světy</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto text-gray-300">
            Exoplanety – planety mimo naši sluneční soustavu. Poznej neznámé světy, které mohou skrývat život.
        </p>
        <a href="?page=exoplanets" class="mt-8 inline-block px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-semibold rounded-lg shadow-lg transition">
            Prozkoumat
        </a>
    </header>
    <section id="content" class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-3 gap-8">
        <?php
        $panely = [
          [
            "title" => "Co je exoplaneta?",
            "text" => "Exoplaneta je planeta obíhající jinou hvězdu než Slunce. Odhalujeme je pomocí teleskopů jako Kepler nebo TESS."
          ],
          [
            "title" => "Jak je objevujeme?",
            "text" => "Pomocí metod jako tranzitní fotometrie nebo radiální rychlosti lze sledovat změny světla nebo pohyby hvězd."
          ],
          [
            "title" => "Kolik jich známe?",
            "text" => "Do roku 2025 jsme objevili přes 5 000 exoplanet, některé z nich se nacházejí v obyvatelné zóně."
          ]
        ];

        foreach ($panely as $panel) {
          echo '
            <div class="bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-xl transition">
              <h2 class="text-xl font-bold text-cyan-300 mb-2">' . $panel["title"] . '</h2>
              <p class="text-gray-300">' . $panel["text"] . '</p>
            </div>
          ';
        }
        ?>
    </section>
</div>