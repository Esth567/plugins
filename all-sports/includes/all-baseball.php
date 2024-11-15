<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function baseball_games_standing_shortcode() {
    ob_start();
    ?>
    <div id="wg-api-baseball-data">
        <!-- Baseball data will be displayed here -->
    </div>

    <script>
     async function fetchBaseballData() {
    const leagueUrl = 'https://api-baseball.p.rapidapi.com/leagues';
    const seasonUrl = 'https://api-baseball.p.rapidapi.com/seasons';
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '83030a4babmsheb2116f25092dacp18d575jsnd997153d0ab7',
            'x-rapidapi-host': 'api-baseball.p.rapidapi.com'
        }
    };

    try {
        // Fetch leagues
        const leagueResponse = await fetch(leagueUrl, options);
        const leagueData = await leagueResponse.json();

        // Fetch seasons
        const seasonResponse = await fetch(seasonUrl, options);
        const seasonData = await seasonResponse.json();

        // Get current year
        const currentYear = new Date().getFullYear();

        // Filter seasons to exclude future seasons and sort in descending order
        const validSeasons = seasonData.response.filter(season => season <= currentYear);
        const mostRecentSeason = validSeasons.sort((a, b) => b - a)[0]; // Get the latest valid season

        console.log('Fetching games for season:', mostRecentSeason);

        // Fetch live and pending games for the most recent valid season
        const gamesUrl = `https://api-baseball.p.rapidapi.com/games?season=${mostRecentSeason}&status=live|pending&league=1`;
        const gamesResponse = await fetch(gamesUrl, options);
        const gamesData = await gamesResponse.json();
        console.log('Games API Response:', gamesData);

        // Fetch standings for the most recent valid season
        const standingsUrl = `https://api-baseball.p.rapidapi.com/standings?season=${mostRecentSeason}&league=1`;
        const standingsResponse = await fetch(standingsUrl, options);
        const standingsData = await standingsResponse.json();
        console.log('Standings API Response:', standingsData);

        displayBaseballData(leagueData, mostRecentSeason, gamesData, standingsData);

    } catch (error) {
        console.error('Error fetching baseball data:', error);
    }
}


        // Function to display the fetched data (Games and Standings)
        function displayBaseballData(leagueData, season, gamesData, standingsData) {
    const container = document.getElementById('wg-api-baseball-data');
    container.innerHTML = ''; // Clear previous content

    // Display all leagues and countries
    if (leagueData && leagueData.response && leagueData.response.length > 0) {
        const leagueElement = document.createElement('div');
        leagueElement.innerHTML = `<h2>Baseball Leagues (Season: ${season}):</h2>`;
        container.appendChild(leagueElement);

        leagueData.response.forEach(league => {
            const leagueName = league.name ? league.name : 'Unknown League';
            const countryName = league.country && league.country.name ? league.country.name : 'Unknown Country';
            const leagueItem = document.createElement('p');
            leagueItem.innerHTML = `League: ${leagueName} (${countryName})`;
            container.appendChild(leagueItem);
        });
    } else {
        container.innerHTML += '<p>No leagues found.</p>';
    }

    // Display games data grouped by country and date
    if (gamesData && gamesData.response && gamesData.response.length > 0) {
        const gamesByDate = {};
        gamesData.response.forEach(game => {
            const gameDate = new Date(game.date).toLocaleDateString();
            const gameTime = new Date(game.date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const country = game.country ? game.country.name : 'Unknown Country';
            const homeTeam = game.teams && game.teams.home ? game.teams.home.name : 'Unknown Home Team';
            const awayTeam = game.teams && game.teams.away ? game.teams.away.name : 'Unknown Away Team';

            if (!gamesByDate[gameDate]) {
                gamesByDate[gameDate] = [];
            }

            gamesByDate[gameDate].push({
                homeTeam: homeTeam,
                awayTeam: awayTeam,
                country: country, // Use the checked value
                time: gameTime
            });
        });

        for (const date in gamesByDate) {
            const dateElement = document.createElement('h3');
            dateElement.textContent = `Date: ${date}`;
            container.appendChild(dateElement);

            gamesByDate[date].forEach(game => {
                const gameElement = document.createElement('div');
                gameElement.textContent = `Game: ${game.homeTeam} vs ${game.awayTeam} - Country: ${game.country} - Time: ${game.time}`;
                container.appendChild(gameElement);
            });
        }
    } else {
        container.innerHTML += '<p>No live or pending games available.</p>';
    }

    // Display standings
    if (standingsData && standingsData.response && standingsData.response.length > 0) {
        const standingsElement = document.createElement('div');
        standingsElement.innerHTML = `<h2>Standings (Season: ${season}):</h2>`;
        container.appendChild(standingsElement);

        standingsData.response.forEach(standing => {
            const teamName = standing.team && standing.team.name ? standing.team.name : 'Unknown Team';
            const standingItem = document.createElement('p');
            standingItem.innerHTML = `Team: ${teamName} - Position: ${standing.rank} - Wins: ${standing.win.total}`;
            container.appendChild(standingItem);
        });
    } else {
        container.innerHTML += '<p>No standings available for the selected season.</p>';
    }
}


        // Call the fetch function to load data when the script runs
        fetchBaseballData();
    </script>
    <?php
    return ob_get_clean();
}





add_shortcode('baseball_games_standing', 'baseball_games_standing_shortcode');