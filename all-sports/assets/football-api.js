document.addEventListener('DOMContentLoaded', function() {
    // Initialize any other code here
});

function updateLeague(leagueId) {
    console.log("Selected League ID:", leagueId); // Log selected league ID

    const widget = document.getElementById('wg-api-football-games');
    
    if (!widget) {
        console.error("Widget element not found.");
        return;
    }

    // Update the data-league attribute with the selected league
    widget.setAttribute('data-league', leagueId);
    console.log("Updated widget data-league to:", leagueId); // Log updated league ID

    // Optionally refresh or re-initialize the widget here
    // Example: if there's a refresh method
    // refreshWidget();
}




