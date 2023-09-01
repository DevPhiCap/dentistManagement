function updateURL() {
    var startyearSelect = document.getElementById("startyearSelect");
    var endyearSelect = document.getElementById("endyearSelect");
    var selectedStartYear = startyearSelect.options[startyearSelect.selectedIndex].value;
    var selectedEndYear = endyearSelect.options[endyearSelect.selectedIndex].value;
    var currentURL = new URL(window.location.href);
    currentURL.searchParams.delete('startyearmonth');
    currentURL.searchParams.delete('endyearmonth');
    currentURL.searchParams.delete('schedule');

    // Store the selected values in variables
    var newStartYearValue = selectedStartYear ? selectedStartYear : '';
    var newEndYearValue = selectedEndYear ? selectedEndYear : '';

    currentURL.searchParams.set('startyear', newStartYearValue);
    currentURL.searchParams.set('endyear', newEndYearValue);
    window.history.pushState({}, '', currentURL);

    window.location.reload();
}

function updatemonthURL() {
    var startyearmonthSelect = document.getElementById("startyearmonthSelect");
    var endyearmonthSelect = document.getElementById("endyearmonthSelect");
    var selectedStartYearMonth = startyearmonthSelect.value;
    var selectedEndYearMonth = endyearmonthSelect.value;
    var currentURL = new URL(window.location.href);

    currentURL.searchParams.delete('startyear');
    currentURL.searchParams.delete('endyear');
    currentURL.searchParams.delete('schedule');

    currentURL.searchParams.set('startyearmonth', selectedStartYearMonth);
    currentURL.searchParams.set('endyearmonth', selectedEndYearMonth);
    window.history.pushState({}, '', currentURL);

    window.location.reload();
}
function updatescheURL() {
    var scheSelect = document.getElementById("schedateSelect");
    var selectedSche = scheSelect.value;
    var currentURL = new URL(window.location.href);

    currentURL.searchParams.delete('startyear');
    currentURL.searchParams.delete('endyear');
    currentURL.searchParams.delete('startyearmonth');
    currentURL.searchParams.delete('endyearmonth');

    currentURL.searchParams.set('schedule', selectedSche);
    window.history.pushState({}, '', currentURL);

    window.location.reload();
}
function sortbySche() {
    var currentURL = new URL(window.location.href);
    var sortingParam = currentURL.searchParams.get('schedate');

    if (sortingParam === 'asc') {
        currentURL.searchParams.set('schedate', 'desc');
    } else if (sortingParam === 'desc') {
        currentURL.searchParams.set('schedate', 'asc');
    } else {
        currentURL.searchParams.set('schedate', 'desc');
    }

    window.location.href = currentURL;
}