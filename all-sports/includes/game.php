<?php


function game_show() {
   
    ob_start();
    ?>
         <div id="wg-api-football-game"
          data-host="v3.football.api-sports.io"
          data-key="Your-Api-Key-Here"
          data-id="718243"
          data-theme=""
          data-refresh="15"
          data-show-errors="false"
         data-show-logos="true">
    </div>
   <script
      type="module"
      src="https://widgets.api-sports.io/2.0.3/widgets.js">
   </script>
        <?php
        return ob_get_clean();
    }


add_shortcode('game045678', 'game_show');
