<div id="main">
    <header class="text-center py-24 px-4 bg-gradient-to-b from-gray-900 to-black pb-30" style="margin-bottom: 30px;">
        <h1 class="text-4xl md:text-6xl font-extrabold text-cyan-400 mb-7" style="font-size: x-large;">Objevuj tajemné světy</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto text-gray-300 p-10" style="padding-top: 5px; padding-bottom: 30px; font-size: medium;">
            Exoplanety – planety mimo naši sluneční soustavu. Poznej neznámé světy, které mohou skrývat život.
        </p>
        <a href="?page=exoplanets" class="mt-8 inline-block px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-semibold rounded-lg shadow-lg transition" style="font-size: x-large; padding-top: 30px;">
            Prozkoumat
        </a>
    </header>
    <section id="content" class="max-w-6xl mx-auto px-4 py-16 h-20 flex flex-wrap gap-10" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 6rem;">
        <?php
        $panely = [
          ["title" => "Co je exoplaneta?", "text" => "Exoplaneta je planeta obíhající jinou hvězdu než Slunce. Odhalujeme je pomocí teleskopů jako Kepler nebo TESS."],
          ["title" => "Jak je objevujeme?", "text" => "Pomocí metod jako tranzitní fotometrie nebo radiální rychlosti lze sledovat změny světla nebo pohyby hvězd."],
          ["title" => "Kolik jich známe?", "text" => "Do roku 2025 jsme objevili přes 5 000 exoplanet, některé z nich se nacházejí v obyvatelné zóně."]
        ];

        foreach ($panely as $panel) {
          echo '
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-600 shadow-lg flex-1 min-w-80 h-48 md:h-56 lg:h-64 flex flex-col justify-center items-center" style="border-radius: 12px; padding: 24px; border: 1px solid #4b5563; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); flex: 1; min-width: 320px; height: 256px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
              <h2 class="text-xl font-bold text-cyan-300 mb-2 text-center">' . $panel["title"] . '</h2>
              <p class="text-gray-300">' . $panel["text"] . '</p>
            </div>
          ';
        }
        ?>
    </section>
</div>