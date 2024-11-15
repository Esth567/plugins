<?php


function game_show() {
   
    ob_start();
    ?>
      <div id="standings-container"></div>
    <script>
    async function fetchFootballStanding() {
        const url = 'https://api-football-v1.p.rapidapi.com/v3/standings?league=39&season=2024';
        const options = {
            method: 'GET',
            headers: {
                'x-rapidapi-key': '83030a4babmsheb2116f25092dacp18d575jsnd997153d0ab7',
                'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
            }
        };

        try {
        const response = await fetch(url, options);
        const result = await response.json();

        // Extract standings data from the response
        const standings = result.response && result.response.length ? result.response[0].league.standings[0] : [];
        return standings;
    } catch (error) {
        console.error('Error fetching football standings:', error);
        return [];
    }
    }

    // Function to render standings on the frontend
async function displayStandings() {
    const standings = await fetchFootballStanding();

    const standingsContainer = document.getElementById('standings-container');
    standingsContainer.innerHTML = '';  // Clear any existing data

    standings.forEach(team => {
        const teamElement = document.createElement('div');
        teamElement.className = 'team-standing';
        
        teamElement.innerHTML = `
            <div class="team-name">${team.team.name}</div>
            <div class="team-position">Position: ${team.rank}</div>
            <div class="team-points">Points: ${team.points}</div>
            <div class="team-goals">Goals: ${team.all.goals.for} - ${team.all.goals.against}</div>
        `;
        
        standingsContainer.appendChild(teamElement);
    });
}

   // Call displayStandings on page load
   window.addEventListener('load', displayStandings);

</script>

<style>
    /* Add some basic styles for the standings table */
    .standings-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .standings-table th, .standings-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .standings-table th {
        background-color: #f2f2f2;
    }
</style>

        <?php
        return ob_get_clean();
 }


add_shortcode('footballStandi4512', 'game_show');
