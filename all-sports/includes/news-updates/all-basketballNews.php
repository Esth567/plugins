<?php

if ( ! defined( 'ABSPATH' )) {
    die;
};

function basketball_news_shortcode() {
    ob_start();
    ?>
    <div id="wg-api-basketball-games"></div>
    <script>
    const url = 'https://api-basketball-nba.p.rapidapi.com/nba-news?limit=50';
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '83030a4babmsheb2116f25092dacp18d575jsnd997153d0ab7',
            'x-rapidapi-host': 'api-basketball-nba.p.rapidapi.com'
        }
    };

    async function fetchBasketballNews() {
        try {
            const response = await fetch(url, options);
            const result = await response.json(); // Use JSON to parse the response
            displayBasketballNews(result);
        } catch (error) {
            console.error(error);
            document.getElementById('wg-api-basketball-games').innerText = "Failed to load news.";
        }
    }

    function displayBasketballNews(newsData) {
        const newsContainer = document.getElementById('wg-api-basketball-games');
        newsContainer.innerHTML = ''; // Clear any previous content

        // Loop through news items and create HTML for each
        newsData.forEach(newsItem => {
            const newsElement = document.createElement('div');
            newsElement.innerHTML = `
                <h3>${newsItem.headline}</h3>
                <p>${newsItem.description}</p>
            `;
            newsContainer.appendChild(newsElement);
        });
    }

    // Call the async function
    fetchBasketballNews();
    </script>
    <?php
    return ob_get_clean();
}



add_shortcode('basketball_news', 'basketball_news_shortcode');