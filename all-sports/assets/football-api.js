document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('#football-leagues-sidebar a');
    const widget = document.getElementById('wg-api-football-games');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const leagueId = this.getAttribute('data-league-id');
            widget.setAttribute('data-league', leagueId);

            reinitializeWidget();
        });
    });

    function reinitializeWidget() {
        const oldWidget = document.getElementById('wg-api-football-games');
        const newWidget = oldWidget.cloneNode(true);
        oldWidget.parentNode.replaceChild(newWidget, oldWidget);

        // Load the widget script again to apply the changes
        const script = document.createElement('script');
        script.type = 'module';
        script.src = 'https://widgets.api-sports.io/2.0.3/widgets.js';
        document.body.appendChild(script);
    }
});


