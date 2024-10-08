<?php

function football_games_standing_shortcode() {
   
        ob_start();
        ?>
        <div id="wg-api-football-games"
             data-host="api-football-v1.p.rapidapi.com"
             data-key="83030a4babmsheb2116f25092dacp18d575jsnd997153d0ab7"
             data-league="39"
             data-team=""
             data-season="2021"
             data-theme=""
            data-show-errors="false"
            data-show-logos="true"
            class="wg_loader">
        </div>
        <script type="module" src="https://widgets.api-sports.io/2.0.3/widgets.js"></script>
        <?php
        return ob_get_clean();
    }

add_shortcode('football_games_standing', 'football_games_standing_shortcode');