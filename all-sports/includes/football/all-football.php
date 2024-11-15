<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function football_games_with_sidebar_shortcode() {
    ob_start();
    ?>

<div style="display: flex; justify-content: space-between;">
    <!-- Sidebar Container -->
    <div id="sidebar-container">
        <h3>Competitions</h3>

        <!-- Button placeholders to be populated dynamically -->
        <button id="league-btn-39" onclick="updateLeague('39')">
            <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-39"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Premier League</span>
            <span class="league-country">USA</span>
           </div>
           </div>
        </button>

        <button id="league-btn-140" onclick="updateLeague('140')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-140"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">La Liga</span>
            <span class="league-country">Spain</span>
            </div>
           </div>
        </button>

        <button id="league-btn-2" onclick="updateLeague('2')">
        <div style="display: flex; flex-direction: row; padding: 10px 15px;">
            <span class="league-logo" id="league-logo-2"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Champions League</span>
            <span class="league-country" style="font-weight: 200;">UEFA</span>
            </div>
           </div>
        </button>

        <button id="league-btn-78" onclick="updateLeague('78')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-78"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Bundesliga</span>
            <span class="league-country">Germany</span>
            </div>
           </div>
        </button>

        <button id="league-btn-61" onclick="updateLeague('61')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-61"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Ligue 1</span>
            <span class="league-country">France</span>
            </div>
           </div>
        </button>

        <button id="league-btn-62" onclick="updateLeague('62')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-62"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Ligue 2</span>
            <span class="league-country">France</span>
            </div>
           </div>
        </button>

        <button id="league-btn-135" onclick="updateLeague('135')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-135"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Serie A</span>
            <span class="league-country">Italy</span>
            </div>
           </div>
        </button>

        <button id="league-btn-136" onclick="updateLeague('136')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-136"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Serie B</span>
            <span class="league-country">Italy</span>
            </div>
           </div>
        </button>

        <button id="league-btn-3" onclick="updateLeague('3')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-3"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Europa League</span>
            <span class="league-country">UEFA</span>
            </div>
           </div>
        </button>
        
        <button id="league-btn-399" onclick="updateLeague('399')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-399"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">NPFL</span>
            <span class="league-country">Nigeria</span>
            </div>
           </div>
        </button>

        <button id="league-btn-6" onclick="updateLeague('6')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-6"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Africa Cup of Nations</span>
            <span class="league-country">World</span>
            </div>
           </div>
        </button>

        <button id="league-btn-36" onclick="updateLeague('36')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-36"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">Africa Cup of Nations Qualification</span>
            <span class="league-country">World</span>
            </div>
           </div>
        </button>

        <button id="league-btn-19" onclick="updateLeague('19')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-19"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">African Nations Championship</span>
            <span class="league-country">World</span>
            </div>
           </div>
        </button>

        <button id="league-btn-12" onclick="updateLeague('12')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-12"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">CAF Champions League</span>
            <span class="league-country">World</span>
            </div>
           </div>
        </button>

        <button id="league-btn-29" onclick="updateLeague('29')">
        <div style="display: flex; flex-direction: row;">
            <span class="league-logo" id="league-logo-29"></span>
            <div style="display: flex; flex-direction: column; text-align: left;">
            <span class="league-name">World Cup Qualification Africa</span>
            <span class="league-country">World</span>
            </div>
           </div>
        </button>
    </div>
    <div>
        <div>
    <div id="match-filters" style="display: flex; flex-direction: row; justify-content: start; gap: 10px; margin-bottom: 20px;">
        <button onclick="displayMatches('all', selectedLeagueId)">All Matches</button>
        <button onclick="displayMatches('future', selectedLeagueId)">Future Fixtures</button>
        <button onclick="displayMatches('live', selectedLeagueId)">Live Matches</button>
        <input type="date" id="match-date-picker" style="margin-left: auto;" />
    </div>
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 15px; margin-left: 10px;">
    <!-- Search input with margin-left: auto to push it to the right -->
    <input type="text" id="search-input" placeholder="Search by league or team name" style="padding: 8px; width: 80%; border: 1px solid #ccc; border-radius: 4px;">
    
    <!-- Search icon button, aligned right next to the input -->
    <button onclick="searchMatches()" style="background: none; border: none; cursor: pointer; margin-left: 8px;">
    <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/img/search-icon.png" alt="Search" style="width: 20px; height: 20px;">
    </button>
</div>
    <div id="loading-indicator" style="display: none; margin-left: 10px;">Loading matches...</div>
    <div style="margin-left: 10px;" id="matches-info"></div>
</div>


<script>

   // Function to load league logos and countries on page load
async function loadLeagueButtons() {
    const leagueIds = [39, 140, 2, 78, 61, 62, 135, 136, 3, 399, 6, 36, 19, 12, 29];
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
            'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
        }
    };

    // Loop through each league and fetch its details
    for (const leagueId of leagueIds) {
        try {
            const leagueUrl = `https://api-football-v1.p.rapidapi.com/v3/leagues?id=${leagueId}`;
            const response = await fetch(leagueUrl, options);
            const result = await response.json();

            if (result.response && result.response.length > 0) {
                const league = result.response[0];

                // Set league logo and country for each button
                const leagueLogoElement = document.getElementById(`league-logo-${leagueId}`);
                const leagueCountryElement = document.getElementById(`league-country-${leagueId}`);
                const leagueButtonElement = document.getElementById(`league-btn-${leagueId}`); 

                if (leagueLogoElement) {
                    leagueLogoElement.innerHTML = `
                        <img src="${league.league.logo}" alt="${league.league.name} logo" width="20" style="margin-right: 8px;"/>
                    `;
                }

                if (leagueCountryElement) {
                    leagueCountryElement.innerHTML = `<small>${league.country.name}</small>`;
                }

                // Add event listener to each league button only if it exists
                if (leagueButtonElement) {
                    leagueButtonElement.addEventListener('click', () => {
                        updateLeague(leagueId);  // Update matches when league button is clicked
                    });
                } else {
                    console.error(`Button with ID league-btn-${leagueId} not found`);
                }
            }
        } catch (error) {
            console.error(`Error fetching league data for ID ${leagueId}:`, error);
        }
    }

    // Load all matches by default
    fetchAllMatches();
}


let selectedLeagueId = null;

function updateLeague(leagueId) {
    selectedLeagueId = leagueId;
    displayMatches('all', selectedLeagueId);  // Load all matches by default when a league is clicked
}


document.addEventListener('DOMContentLoaded', function () {
    loadLeagueButtons();

    // Set default date in the calendar to today
    const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('match-date-picker').value = today;

    // Trigger match display when a date is selected
    document.getElementById('match-date-picker').addEventListener('change', () => {
        displayMatches('all');
    });
})

document.addEventListener('DOMContentLoaded', function () {
    loadLeagueButtons(); // Load league buttons
    displayMatches('all', selectedLeagueId, '', true); // Show 'all' matches on initial load without loading indicator
});


// Function to search matches by league or team name
function searchMatches() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    displayMatches('all', null, searchTerm); // Pass searchTerm as an additional parameter
}

   // Function to update matches display based on button clicks
   async function displayMatches(type, leagueId = selectedLeagueId, searchTerm = '', isInitialLoad = false) {
    const loadingIndicator = document.getElementById('loading-indicator');
    const matchesContainer = document.getElementById('matches-info');
    
 
        loadingIndicator.style.display = 'block'; // Show loading indicator
        matchesContainer.style.display = 'none'; // Hide matches container during load

    try {
        const currentYear = new Date().getFullYear();
        const currentSeason = currentYear;
        const selectedDate = document.getElementById('match-date-picker').value;

        let matchesUrl = `https://api-football-v1.p.rapidapi.com/v3/fixtures?date=${selectedDate}&season=${currentSeason}`;

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
    const matchType = event.target.textContent.toLowerCase(); 
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
        let matchesUrl = `https://api-football-v1.p.rapidapi.com/v3/fixtures?season=${currentSeason}`;

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
        'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
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
    let matchesUrl = `https://api-football-v1.p.rapidapi.com/v3/fixtures?status=NS&season=${currentSeason}`;

    if (leagueId) {
        matchesUrl += `&league=${leagueId}`; // Add league filter if a specific league is selected
    }

    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
            'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
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
    let matchesUrl = `https://api-football-v1.p.rapidapi.com/v3/fixtures?live=all&season=${currentSeason}`;
    
    if (leagueId) {
        matchesUrl += `&league=${leagueId}`; // Add league filter if a specific league is selected
    }
    
    const options = {
        method: 'GET',
        headers: {
		'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
		'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
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

                const fixtureId = match.fixture.id;

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
                   <div class="match-container" style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; cursor: pointer;"
         onclick="toggleMatchDetails(${fixtureId})"> <!-- Add onclick event to toggle details -->
        <div class="date-time" style="display: flex; flex-direction: column;">
            <span style="font-size: 12px">${displayTime}</span>  <!-- Display time/status -->
        </div>
        <div class="teams-container" style="display: flex; flex-direction: column; flex-grow: 1; margin-left: 15px;">
            <!-- Home Team -->
            <div class="home-team" style="display: flex; align-items: center; margin-bottom: 5px;">
                <img src="${homeTeamLogo}" alt="${homeTeam} logo" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 14px; font-weight: 500;">${homeTeam}</span>
            </div>

            <!-- Away Team -->
            <div class="away-team" style="display: flex; align-items: center;">
                <img src="${awayTeamLogo}" alt="${awayTeam} logo" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 14px; font-weight: 500;">${awayTeam}</span>
            </div>
        </div>

        <!-- Display score only if match has started -->
        ${matchStatus !== "NS" ? `
        <div class="score" style="display: flex; flex-direction: column; align-items: center;">
            <span style="font-size: 14px; font-weight: 500;">${homeScore}</span>
            <span style="font-size: 14px; font-weight: 500;">${awayScore}</span>
        </div>
        ` : ''}
      </div>
    
         <!-- Hidden container for lineups and H2H -->
         <div id="details-${fixtureId}" style="display: none; padding: 10px; border: 1px solid #eee; margin-top: -10px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <button onclick="displayLineups(${fixtureId})">Lineups</button>
            <button onclick="displayH2H(${fixtureId})">H2H</button>
          </div>
         <div id="lineups-${fixtureId}" style="display: none;"></div>
         <div id="h2h-${fixtureId}" style="display: none;"></div>
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


// Function to fetch and display lineups
async function displayLineups(fixtureId) {
    const lineupsContainer = document.getElementById(`lineups-${fixtureId}`);
    lineupsContainer.style.display = 'block';
    lineupsContainer.innerHTML = 'Loading lineups...';

    const url = `https://api-football-v1.p.rapidapi.com/v3/fixtures/lineups?fixture=${fixtureId}`;
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
            'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
        }
    };

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        if (result.response && result.response.length > 0) {
            const lineupData = result.response[0];
            lineupsContainer.innerHTML = `
                <p><strong>${lineupData.team.name} Lineup:</strong></p>
                <p>Formation: ${lineupData.formation}</p>
                <ul>
                    ${lineupData.startXI.map(player => `<li>${player.player.name}</li>`).join('')}
                </ul>
            `;
        } else {
            lineupsContainer.innerHTML = '<p>No lineup data available.</p>';
        }
    } catch (error) {
        console.error('Error fetching lineups:', error);
        lineupsContainer.innerHTML = '<p>Error loading lineups.</p>';
    }
}

async function displayH2H(fixtureId) {
    const h2hContainer = document.getElementById(`h2h-${fixtureId}`);
    h2hContainer.style.display = 'block';
    h2hContainer.innerHTML = 'Loading H2H data...';

    // Assuming you have an H2H endpoint, similar to the lineups one
    const url = `https://api-football-v1.p.rapidapi.com/v3/fixtures/headtohead?fixture=${fixtureId}`;
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '0662a59b11msh8493d65e935a1e5p112b5ajsn25887d0e8c13',
            'x-rapidapi-host': 'api-football-v1.p.rapidapi.com'
        }
    };

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        if (result.response && result.response.length > 0) {
            h2hContainer.innerHTML = `
                <p><strong>Head-to-Head Matches:</strong></p>
                <ul>
                    ${result.response.map(match => `
                        <li>${match.teams.home.name} ${match.goals.home} - ${match.goals.away} ${match.teams.away.name} (${new Date(match.fixture.date).toLocaleDateString()})</li>
                    `).join('')}
                </ul>
            `;
        } else {
            h2hContainer.innerHTML = '<p>No H2H data available.</p>';
        }
    } catch (error) {
        console.error('Error fetching H2H:', error);
        h2hContainer.innerHTML = '<p>Error loading H2H data.</p>';
    }
}

// Function to toggle the visibility of match details
function toggleMatchDetails(fixtureId) {
    const detailsContainer = document.getElementById(`details-${fixtureId}`);
    if (detailsContainer.style.display === 'none' || detailsContainer.style.display === '') {
        detailsContainer.style.display = 'block';
    } else {
        detailsContainer.style.display = 'none';
    }
}

</script>

<style>
    .league-country {
        font-size: 12px; 
        font-weight: 200; 
        margin-top: -2px; 
    }
    .details-buttons button {
        margin-right: 10px; /* Spacing between buttons */
        padding: 5px 10px; /* Button padding */
        cursor: pointer; /* Pointer cursor on hover */
        border: 1px solid #007BFF; /* Button border */
        background-color: #007BFF; /* Button background */
        color: #fff; /* Button text color */
        border-radius: 4px; /* Rounded corners */
        transition: background-color 0.3s; /* Smooth background transition */
        width: 50%;
    }

    /* Button hover effect */
    .details-buttons button:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
    #lineups-${fixtureId}, #h2h-${fixtureId} {
        padding: 10px;
        border-top: 1px solid #eee; /* Top border for separation */
        margin-top: 10px; /* Margin above each section */
    }
</style>


        </div>
    </div>

    <?php
    return ob_get_clean();
}



add_shortcode('football_games', 'football_games_with_sidebar_shortcode');


