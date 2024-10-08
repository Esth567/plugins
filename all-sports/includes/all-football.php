<?php

function football_games_with_sidebar_shortcode() {
    ob_start();
    ?>
    <div style="display: flex;">
        <!-- Left Sidebar -->
        <div id="football-leagues-sidebar" style="width: 250px; border-right: 1px solid #ccc; padding: 10px;">
            <h3>Leagues</h3>
            <ul>
                <li><a href="#" data-league-id="39">Premier League</a></li>
                <li><a href="#" data-league-id="140">La Liga</a></li>
                <li><a href="#" data-league-id="78">Bundesliga</a></li>
                <li><a href="#" data-league-id="135">Serie A</a></li>
                <li><a href="#" data-league-id="61">Ligue 1</a></li>
                <!-- Add more leagues here -->
            </ul>
        </div>

        <!-- Main Content (Football Games Widget) -->
        <div style="flex: 1; padding: 10px;">
            <div id="wg-api-football-games"
                data-host="api-football-v1.p.rapidapi.com"
                data-key="83030a4babmsheb2116f25092dacp18d575jsnd997153d0ab7"
                data-date="<?php echo date('Y-m-d'); ?>" 
                data-league="" 
                data-season=""
                data-theme="dark"
                data-refresh="15"
                data-show-toolbar="true"
                data-show-errors="false"
                data-show-logos="true"
                data-modal-game="false"
                data-modal-standings="false"
                data-modal-show-logos="false">
            </div>
            <script type="module" src="https://widgets.api-sports.io/2.0.3/widgets.js"></script>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('#football-leagues-sidebar a');
            const widget = document.getElementById('wg-api-football-games');

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const leagueId = this.getAttribute('data-league-id');
                    widget.setAttribute('data-league', leagueId);

                    // Re-initialize the widget to load new data
                    reinitializeWidget();
                });
            });

            function reinitializeWidget() {
                const oldWidget = document.getElementById('wg-api-football-games');
                const newWidget = oldWidget.cloneNode(true);
                oldWidget.parentNode.replaceChild(newWidget, oldWidget);

                // Load the widget script again to apply the changes
                const script = document.createElement('script');
                script.type = 'module';
                script.src = 'https://widgets.api-sports.io/2.0.3/widgets.js';
                document.body.appendChild(script);
            }
        });
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode('football_games_with_sidebar', 'football_games_with_sidebar_shortcode');


