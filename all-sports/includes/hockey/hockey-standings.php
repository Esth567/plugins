<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function volleyball_games_standing_shortcode() {
   
    ob_start();
    ?>
     <div id="wg-api-hockey-standings"
    data-host="v1.hockey.api-sports.io"
    data-key="98d45d2663225579ca56dc3a7ef9a278"
    data-league=""
    data-season=""
    data-theme=""
    data-show-errors="false"
    data-show-logos="true"
    class="wg_loader">
</div>
<script
    type="module"
    src="https://widgets.api-sports.io/2.0.3/widgets.js">
</script>
        <?php
        return ob_get_clean();
    }

add_shortcode('volleyball795_standing', 'volleyball_games_standing_shortcode');