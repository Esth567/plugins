<?php

function football_games_shortcode() {
    ob_start();
    ?>
   <div id="matches-container">
    <div id="loading-indicator" class="loading">Loading matches...</div>
</div>

<script>
    // League IDs to fetch matches for
    const leagueIds = [39, 140, 2, 78, 61, 62, 135, 136, 3, 399, 6, 36, 19, 12, 29];

    // Function to fetch all matches based on date, season, and leagueId
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
            return result.response || [];
        } catch (error) {
            console.error('Error fetching matches:', error);
            return [];
        }
    }

    // Helper function to format date as YYYY-MM-DD
    function formatDateToYMD(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = (d.getMonth() + 1).toString().padStart(2, '0');
        const day = d.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Function to load matches for all leagues and display on frontend
    async function loadAllMatchesForLeagues() {
        const currentDate = new Date();
        const formattedDate = formatDateToYMD(currentDate);
        const season = currentDate.getFullYear();

        const matchesContainer = document.getElementById('matches-container');
        matchesContainer.innerHTML = ''; // Clear previous content

        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block'; // Show loading indicator
        }

        for (const leagueId of leagueIds) {
            const leagueMatches = await fetchAllMatches(formattedDate, season, leagueId);

            if (leagueMatches.length > 0) {
                const leagueInfo = leagueMatches[0].league; // Get league info from the first match
                const leagueTitle = document.createElement('div');
                leagueTitle.className = 'league-title';
                leagueTitle.innerHTML = `
                    <img src="${leagueInfo.logo}" alt="${leagueInfo.name} logo" class="league-logo">
                    <span>${leagueInfo.name}</span>
                `;
                matchesContainer.appendChild(leagueTitle);

                leagueMatches.forEach(match => {
                    const matchDiv = document.createElement('div');
                    matchDiv.className = 'match-container';
                    matchDiv.innerHTML = `
                        <div class="team-info">
                            <img src="${match.teams.home.logo}" alt="${match.teams.home.name} logo" class="team-logo">
                            <span style="font-weight: 500;">${match.teams.home.name}</span>
                        </div>
                        <div class="match-time">
                            <p style="margin-bottom: -5px;">${new Date(match.fixture.date).toLocaleDateString('en-US', { day: 'numeric', month: 'short' })}</p>
                            <p>${new Date(match.fixture.date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false })}</p>
                        </div>
                        <div class="team-info">
                            <img src="${match.teams.away.logo}" alt="${match.teams.away.name} logo" class="team-logo">
                            <span style="font-weight: 500;">${match.teams.away.name}</span>
                        </div>
                    `;
                    matchesContainer.appendChild(matchDiv);
                });
            }
        }

        if (loadingIndicator) {
            loadingIndicator.style.display = 'none'; // Hide loading indicator
        }
    }

    // Load matches immediately on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        loadAllMatchesForLeagues();
    });
</script>

<style>
    /* Styling for match information display */
    .match-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #ccc;
        padding: 5px 10px;
        margin-bottom: 10px;
    }
    .league-title {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .league-logo {
        width: 25px;
        height: 25px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .loading {
        font-size: 14px;
        color: #888;
    }
    .team-info {
        display: flex;
        align-items: center;
    }
    .team-logo {
        width: 24px;
        height: 24px;
        margin-right: 8px;
    }
    .match-time {
        text-align: center;
    }
   
</style>
    <?php
    return ob_get_clean();
}

add_shortcode('football_games4534', 'football_games_shortcode');
