<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function volleyball_games_shortcode() {
   
        ob_start();
        ?>
<div id="wg-api-hockey-games"
     data-host="v1.hockey.api-sports.io"
     data-key="98d45d2663225579ca56dc3a7ef9a278"
     data-date=""
     data-league=""
     data-season=""
     data-theme=""
     data-refresh="15"
     data-show-toolbar="true"
     data-show-errors="false"
     data-show-logos="false"
     data-modal-game="true"
     data-modal-standings="true"
     data-modal-show-logos="true">
</div>
<script
    type="module"
    src="https://widgets.api-sports.io/2.0.3/widgets.js">
</script>
        <?php
        return ob_get_clean();
    }

add_shortcode('volleyball795_games', 'volleyball_games_shortcode');