<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function basketball_games_standing_shortcode() {
    ob_start();
    ?>
    <div style="display: flex; justify-content: space-between;">
        <!-- Sidebar Container -->
        <div id="sidebar-container">
            <h3>Competitions</h3>

            <!-- Buttons for popular leagues -->
            <button id="league-btn-12" onclick="updateLeague('12')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-12"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">NBA</span>
                        <span class="league-country" 
                        style="font-size: 12px; font-weight: 200; margin-top: -2px;">USA</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-120" onclick="updateLeague('120')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-120"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">Euroleague</span>
                        <span class="league-country" style="font-size: 12px; font-weight: 200; margin-top: -2px;">Europe</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-359" onclick="updateLeague('359')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-359"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">Euroleague Women</span>
                        <span class="league-country">Europe</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-369" onclick="updateLeague('369')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-369"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">ENBL</span>
                        <span class="league-country">Europe</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-368" onclick="updateLeague('368')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-368"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">BNXT League</span>
                        <span class="league-country">Europe</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-360" onclick="updateLeague('360')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-360"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">EuroCup Women</span>
                        <span class="league-country">Europe</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-117" onclick="updateLeague('117')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-117"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">ACB</span>
                        <span class="league-country">Spain</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-18" onclick="updateLeague('18')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-18"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">Liga A</span>
                        <span class="league-country">Argentina</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-242" onclick="updateLeague('242')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-242"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> Serie A2</span>
                        <span class="league-country">Italy</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-52" onclick="updateLeague('52')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-52"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> Lega A</span>
                        <span class="league-country">Italy</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-9" onclick="updateLeague('9')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-9"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> French Cup</span>
                        <span class="league-country">France</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-386" onclick="updateLeague('386')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-386"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> EASL</span>
                        <span class="league-country">Asia</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-301" onclick="updateLeague('301')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-301"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> Asia Cup</span>
                        <span class="league-country">Asia</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-282" onclick="updateLeague('282')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-282"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> AmeriCup</span>
                        <span class="league-country">World</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-421" onclick="updateLeague('421')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-421"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name"> WBLA Women</span>
                        <span class="league-country">World</span>
                    </div>
                </div>
            </button>


            <button id="league-btn-10" onclick="updateLeague('10')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-10"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">LFB W</span>
                        <span class="league-country">France</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-6" onclick="updateLeague('6')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-6"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">WNBA: Regular Season</span>
                        <span class="league-country">USA</span>
                    </div>
                </div>
            </button>

            <button id="league-btn-324" onclick="updateLeague('324')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-324"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">AfroBasket</span>
                        <span class="league-country">Africa</span>
                    </div>
                </div>
            </button>


            <button id="league-btn-8" onclick="updateLeague('8')">
                <div style="display: flex; flex-direction: row;">
                    <span class="league-logo" id="league-logo-8"></span>
                    <div style="display: flex; flex-direction: column; text-align: left;">
                        <span class="league-name">Pro B</span>
                        <span class="league-country">France</span>
                    </div>
                </div>
            </button>         
        </div>
        <div>
        <div>
    <div id="match-filters" style="display: flex; flex-direction: row; justify-content: start; gap: 10px; margin-bottom: 20px;">
        <button onclick="displayMatches('all', selectedLeagueId)">All Matches</button>
        <button onclick="displayMatches('live', selectedLeagueId)">Live Matches</button>
        <input type="date" id="match-date-picker" style="margin-left: auto;" />
    </div>
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 15px;">
    <!-- Search input with margin-left: auto to push it to the right -->
    <input type="text" id="search-input" placeholder="Search by league or team name" style="padding: 8px; width: 80%; border: 1px solid #ccc; border-radius: 4px;">
    
    <!-- Search icon button, aligned right next to the input -->
    <button onclick="searchMatches()" style="padding: 8px; background: none; border: none; cursor: pointer; margin-left: 8px;">
        <img src="../assets/img/search-icon.png" style="width: 20px; height: 20px;">
    </button>
</div>
    <div id="loading-indicator" style="display: none; margin-left: 10px;">Loading matches...</div>
        <div style="margin-left: 10px;" id="league-list"></div>
</div>
<script>

      // Function to load league logos and countries on page load
      async function fetchLeagues() {
    const url = 'https://api-basketball.p.rapidapi.com/leagues';
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': 'YOUR_API_KEY_HERE',
            'x-rapidapi-host': 'api-basketball.p.rapidapi.com'
        }
    };

    try {
        const response = await fetch(url, options);
        const data = await response.json();

        if (data.response) {
            const leagues = data.response;
            leagues.forEach(league => {
                console.log(`League ID: ${league.league.id}, Name: ${league.league.name}, Country: ${league.country.name}`);
            });
        } else {
            console.warn('No leagues data available');
        }
    } catch (error) {
        console.error('Error fetching leagues:', error);
    }
}

fetchLeagues();

// Function to fetch games for the selected league and display them
let selectedLeagueId = null;

function updateLeague(leagueId) {
    selectedLeagueId = leagueId;
    displayMatches('all', selectedLeagueId);  // Load all matches by default when a league is clicked
}


document.addEventListener('DOMContentLoaded', () => {
    loadLeagueButtons();

    // Set default date in the calendar to today
    const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('match-date-picker').value = today;

    // Trigger match display when a date is selected
    document.getElementById('match-date-picker').addEventListener('change', () => {
        displayMatches('all');
    });
})


// Function to search matches by league or team name
function searchMatches() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    displayMatches('all', null, searchTerm); // Pass searchTerm as an additional parameter
}

   // Function to update matches display based on button clicks
   async function displayMatches(type, leagueId = selectedLeagueId, searchTerm = '') {
    const loadingIndicator = document.getElementById('loading-indicator');
    const matchesContainer = document.getElementById('matches-info');
    
    loadingIndicator.style.display = 'block'; // Show loading indicator
    matchesContainer.style.display = 'none'; // Hide matches container during load

    try {
        const currentYear = new Date().getFullYear();
        const currentSeason = currentYear;
        const selectedDate = document.getElementById('match-date-picker').value;

        let matchesUrl = `https://api-basketball.p.rapidapi.com/games?date=${selectedDate}&season=${currentSeason}`;

    if (leagueId) {
       matchesUrl += `&league=${leagueId}`;  // Filter by selected league
     }

        let matches = [];
        switch (type) {
            case 'all':
                matches = await fetchAllMatches(selectedDate, currentSeason, leagueId);
                break;
            case 'future':
                matches = await fetchFutureMatches(currentSeason, leagueId);
                break;
            case 'live':
                matches = await fetchLiveMatches(currentSeason, leagueId);
                break;
            default:
                matches = [];
        }

        // Filter matches by search term
        if (searchTerm) {
            matches = matches.filter(match =>
                match.league.name.toLowerCase().includes(searchTerm) ||
                match.teams.home.name.toLowerCase().includes(searchTerm) ||
                match.teams.away.name.toLowerCase().includes(searchTerm)
            );
        }

        renderMatches(matches, type, selectedDate);
    } catch (error) {
        console.error('Error fetching matches:', error);
    } finally {
        loadingIndicator.style.display = 'none'; // Hide loading indicator
        matchesContainer.style.display = 'block'; // Show matches container
    }
}

// Add event listener for match filters
document.getElementById("match-filters").addEventListener("click", (event) => {
    const matchType = event.target.textContent.toLowerCase(); // Type from button
    displayMatches(matchType, selectedLeagueId); // Use 'future', 'all', 'live'
});


function formatDateToYMD(date) {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = (d.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed
    const day = d.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}

     // Function to fetch all matches
     async function fetchAllMatches(date, currentSeason, leagueId = null) {
        let matchesUrl = `https://api-basketball.p.rapidapi.com/games?season=${currentSeason}`;

if (date) {
    matchesUrl += `&date=${formatDateToYMD(date)}`;
}

if (leagueId) {
    matchesUrl += `&league=${leagueId}`;
}

const options = {
    method: 'GET',
    headers: {
        'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
        'x-rapidapi-host': 'api-basketball.p.rapidapi.com'
    }
};

    try {
        const response = await fetch(matchesUrl, options);
        const result = await response.json();
        console.log(result);
        return result.response || [];
    } catch (error) {
        console.error('Error fetching all matches:', error);
        return [];
    }
}

// Function to fetch future matches
async function fetchFutureMatches(currentSeason, leagueId = null) {
    // Ensure currentSeason is defined
    if (!currentSeason) {
        console.error("Season is not defined!");
        return [];
    }

    // Construct the URL with status and season
    let matchesUrl = `https://api-basketball.p.rapidapi.com/games?status=NS&season=${currentSeason}`;

    if (leagueId) {
        matchesUrl += `&league=${leagueId}`; // Add league filter if a specific league is selected
    }

    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
            'x-rapidapi-host': 'api-basketball.p.rapidapi.com'
        }
    };

    try {
        const response = await fetch(matchesUrl, options);
        const result = await response.json();
        console.log(result); // Keep this for debugging purposes

        // Check for API errors
        if (result.errors && Object.keys(result.errors).length > 0) {
            console.error('API returned errors:', result.errors);
            return [];
        }

        return result.response || [];
    } catch (error) {
        console.error('Error fetching future matches:', error);
        return [];
    }
}


// Function to fetch live matches
async function fetchLiveMatches(currentSeason, leagueId = null) {
    let matchesUrl = `https://api-basketball.p.rapidapi.com/games?live=all&season=${currentSeason}`;
    
    if (leagueId) {
        matchesUrl += `&league=${leagueId}`; // Add league filter if a specific league is selected
    }
    
    const options = {
        method: 'GET',
        headers: {
		'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
		'x-rapidapi-host': 'api-basketball.p.rapidapi.com'
	}
    };

    try {
        const response = await fetch(matchesUrl, options);
        const result = await response.json();
        return result.response || [];
    } catch (error) {
        console.error('Error fetching live matches:', error);
        return [];
    }
}

 // Function to render matches
 function renderMatches(matches, type, selectedDate) {
    let matchesHtml = ``;

    if (matches.length === 0) {
        matchesHtml = '<p>No matches available.</p>';
    } else {
        // Group matches by league
        const leaguesMap = {};

        matches.forEach((match) => {
            const leagueId = match.league.id; // Get league ID to group matches
            if (!leaguesMap[leagueId]) {
                leaguesMap[leagueId] = {
                    leagueName: match.league.name,
                    leagueLogo: match.league.logo,
                    leagueCountry: match.league.country,
                    matches: []
                };
            }
            leaguesMap[leagueId].matches.push(match); // Add match to the league
        });

        // Render matches grouped by league
        for (const leagueId in leaguesMap) {
            const leagueInfo = leaguesMap[leagueId];
            matchesHtml += `
                <div>
                    <div class="league-info" style="display: flex; flex-direction: row; align-items: center; padding-top: 10px; margin-bottom: 10px;">
                        <!-- League Logo and Name in Flex Row -->
                        <img src="${leagueInfo.leagueLogo}" alt="League logo" style="width: 20px; height: 20px;">
                        <div style="display: flex; flex-direction: column; margin-left: 8px;">
                            <span style="font-size: 14px; font-weight: bold;">${leagueInfo.leagueName}</span>
                            <span style="font-size: 12px; font-weight: 200; margin-top: -2px;">${leagueInfo.leagueCountry}</span>
                        </div>
                    </div>
                </div>`;

            // Render matches for this league
            leagueInfo.matches.forEach((match) => {
                const fixtureDate = new Date(match.fixture.date);
                const options = { day: 'numeric', month: 'short' };
                const date = fixtureDate.toLocaleDateString('en-US', options);
                const time = fixtureDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
                const homeTeam = match.teams.home.name;
                const awayTeam = match.teams.away.name;
                const homeTeamLogo = match.teams.home.logo;
                const awayTeamLogo = match.teams.away.logo;

                const matchStatus = match.fixture.status.short; // E.g., "NS", "FT", "1H" (First Half), etc.
                const elapsedTime = match.fixture.status.elapsed; // Elapsed time for ongoing matches

                // Show score only if the match has started
                const homeScore = matchStatus !== "NS" ? (match.goals.home !== null ? match.goals.home : '0') : '';
                const awayScore = matchStatus !== "NS" ? (match.goals.away !== null ? match.goals.away : '0') : '';

                // Determine what to display for time based on status
                let displayTime = '';
                if (matchStatus === "NS") {
                    displayTime = time; // Match not started, show scheduled time
                } else if (matchStatus === "FT") {
                    displayTime = "FT"; // Match finished, show "FT"
                } else if (elapsedTime) {
                    displayTime = `${elapsedTime}'`; // Ongoing match, show elapsed time
                } else {
                    displayTime = matchStatus; // Other statuses like "PST" for postponed
                }


                matchesHtml += `
                   <div class="match-container" style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
                      <div class="date-time" style="display: flex; flex-direction: column;">
                        <span style="font-size: 12px">${displayTime}</span>  <!-- Display time/status -->
                      </div>
                        <div class="teams-container" style="display: flex; flex-direction: column; justify-content: space-between;">
                      <div class="home-team" style="display: flex; margin-left: 10px;">
                        <span style="font-size: 14px; font-weight: 500;">${homeTeam}</span>
                       <img src="${homeTeamLogo}" alt="${homeTeam} logo" style="width: 20px; height: 20px; margin-left: 5px;">
                     </div>
                    <div class="away-team" style="display: flex;">
                      <span style="font-size: 14px; font-weight: 500;">${awayTeam}</span>
                    <img src="${awayTeamLogo}" alt="${awayTeam} logo" style="width: 20px; height: 20px; margin-left: 5px;">
                   </div>
                   </div>
                         <!-- Display score only if match has started -->
                            ${matchStatus !== "NS" ? ` 
                                 <div class="score" style="display: flex; align-items: center;">
                                  <span style="font-size: 14px; font-weight: 500;">${homeScore}</span>
                                   <span style="font-size: 14px; font-weight: 500; margin-left: 10px;">${awayScore}</span>
                                 </div>
                            ` : ''}
                    </div>`;
            });
        }
    }

    const matchesContainer = document.getElementById('matches-info');
    if (matchesContainer) {
        matchesContainer.innerHTML = matchesHtml;
        matchesContainer.style.display = 'block'; // Always show matches-info
    }
}
</script>


<style>
    /* Add some styles for the game container */
    .game-container {
        padding: 15px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .game-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .team {
        display: flex;
        align-items: center;
    }

    .team-logo {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .team-name {
        font-size: 1.2em;
    }

    .game-info {
        text-align: center;
        flex-shrink: 0;
    }

    .game-info p {
        margin: 0;
        font-size: 1em;
        font-weight: bold;
    }

    .game-score {
        font-weight: bold;
        color: red;
    }

    /* Date dropdown styling */
    .date-dropdown {
        position: relative;
        display: inline-block;
        font-size: 1.2em;
        margin-bottom: 20px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .date-dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content p {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content p:hover {
        background-color: #f1f1f1;
    }

    body {
            display: flex;
        }
        #sidebar {
            width: 200px; /* Set the width for the sidebar */
            background-color: #f4f4f4; /* Background color for the sidebar */
            padding: 15px; /* Padding for the sidebar */
        }
        #wg-api-basketball-games {
            flex-grow: 1; /* Allow the games container to fill the remaining space */
            padding: 15px; /* Padding for the games container */
        }
        .league-item {
            margin: 5px 0; /* Space between league items */
            cursor: pointer; /* Pointer cursor for clickable items */
        }
</style>

    <?php
    return ob_get_clean();
}


add_shortcode('basketball_games_standing', 'basketball_games_standing_shortcode');