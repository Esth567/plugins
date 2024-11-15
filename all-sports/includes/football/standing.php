<?php

function football_games_standing_shortcode() {
   
        ob_start();
        ?>
        <div id="football-standings-container">
        <div id="football-standings" onload="displayStandings(39)">
        <div id="league-filters-container">
    <div id="league-filters">
        <button onclick="displayStandings(39)">Premier League</button>
        <button onclick="displayStandings(140)">La Liga</button>
        <button onclick="displayStandings(78)">Bundesliga</button>
        <button onclick="displayStandings(61)">Ligue 1</button>
        <button onclick="displayStandings(135)">Serie A</button>
        <button onclick="displayStandings(2)">UEFA Champions League</button>
        <button onclick="displayStandings(3)">UEFA Europa League</button>
        <button onclick="displayStandings(399)">NPFL Nigeria</button>
    </div>
</div>
    <!-- Section where standings will be displayed -->
    <div id="standings-display"></div>
    </div>
    </div>

    <script>
     async function fetchFootballStanding(leagueId) {
        const url = `https://api-football-v1.p.rapidapi.com/v3/standings?league=${leagueId}&season=2024`;
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


    async function displayStandings(leagueId) {
        const standings = await fetchFootballStanding(leagueId);
        
        // Display standings in the #standings-display div
        const standingsDisplay = document.getElementById('standings-display');
        standingsDisplay.innerHTML = ''; // Clear previous standings

        if (standings.length === 0) {
            standingsDisplay.innerHTML = '<p>No standings available for this league.</p>';
            return;
        }

        // Build a table to display the standings
        const table = document.createElement('table');
        table.innerHTML = `
            <tr>
                <th>Pos</th>
                <th>Team</th>
                <th>P</th>
                <th>W</th>
                <th>D</th>
                <th>L</th>
                <th>GF</th>
                <th>GA</th>
                <th>GD</th>
                <th>P</th>
            </tr>
        `;
        
        standings.forEach(team => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${team.rank}</td>
                <td>
                    <img src="${team.team.logo}" alt="${team.team.name} logo" style="height: 20px; width: 20px; vertical-align: middle; margin-right: 5px;">
                    ${team.team.name}
                </td>
                <td>${team.all.played}</td>
                <td>${team.all.win}</td>
                <td>${team.all.draw}</td>
                <td>${team.all.lose}</td>
                <td>${team.all.goals.for}</td>
                <td>${team.all.goals.against}</td>
                <td>${team.goalsDiff}</td>
                <td>${team.points}</td>
            `;
            table.appendChild(row);
        });

        standingsDisplay.appendChild(table);
    }

    

    // Load Premier League standings by default on page load
    window.onload = function() {
        displayStandings(39); 
    }
    </script>
<style>
       #football-standings-container {
        padding: 20px;
        width: 100%;
        margin: 0 auto; /* Center the container on the page */
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    #league-filters-container {
        display: flex;
        align-items: center;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    #league-filters button {
        white-space: nowrap; 
        padding: 10px 15px;
        font-size: 13px; 
        flex: 1 1 auto;  
        width: 35%;
        border: 0;        
        cursor: pointer; 
        border-radius: 5px;
        background-color: #f4f4f4;
        transition: background-color 0.3s; 
    }
    #league-filters button:focus, 
        #league-filters button:hover {
            background-color: red;
            color: white;
            font-weight: bold;
        }

    #league-filters {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 10px;
        flex-grow: 1;
    }
    
    /* Style the standings table */
    #standings-display table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: left; 
        border-radius: 20px;  
    }
    #standings-display th, #standings-display td {
        padding: 10px;
        border: 1px solid #ddd;
        font-weight: 500;
        font-size: 13px;
     
    }
    #standings-display th {
        background-color: #f4f4f4;     
    }
    @media (max-width: 480px) {
        .scroll-button {
            display: none;
        }
            #league-filters button {
                font-size: 10px; 
                padding: 5px; 
            }

            #standings-display table {
                font-size: 10px; 
            }

            #standings-display th, #standings-display td {
                padding: 5px; 
            }
        }

</style>
        <?php
        return ob_get_clean();
    }

add_shortcode('football_games_standing', 'football_games_standing_shortcode');