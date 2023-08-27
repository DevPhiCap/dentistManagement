function toggleButtons(patientId) {
    var openBtn = document.getElementById('openBtn_' + patientId);
    var btnDiv = document.getElementById('btnDiv_' + patientId);

    if (openBtn.style.display === 'none') {
        openBtn.style.display = '';
        btnDiv.style.display = 'none';
    } else {
        openBtn.style.display = 'none';
        btnDiv.style.display = '';
    }
}

function yearsearchButton(){
    var yearsearchDiv = document.getElementById('yearselect');
    var monthsearchDiv = document.getElementById('monthselect');
    var schesearchDiv = document.getElementById('scheselect');

        if(yearsearchDiv.style.display === 'none'){
            yearsearchDiv.style.display = 'block';
            monthsearchDiv.style.display = 'none';
            schesearchDiv.style.display = 'none';
        } else {
            yearsearchDiv.style.display = 'none';
        }
}

function monthsearchButton(){
    var yearsearchDiv = document.getElementById('yearselect');
    var monthsearchDiv = document.getElementById('monthselect');
    var schesearchDiv = document.getElementById('scheselect');

    if(monthsearchDiv.style.display === 'none'){
        monthsearchDiv.style.display = 'block';
        yearsearchDiv.style.display = 'none';
        schesearchDiv.style.display = 'none';
    } else {
        monthsearchDiv.style.display = 'none';
    }
}

function schesearchButton(){
    var yearsearchDiv = document.getElementById('yearselect');
    var monthsearchDiv = document.getElementById('monthselect');
    var schesearchDiv = document.getElementById('scheselect');

    if(schesearchDiv.style.display === 'none'){
        schesearchDiv.style.display = 'block';
        yearsearchDiv.style.display = 'none';
        monthsearchDiv.style.display = 'none';
    } else {
        schesearchDiv.style.display = 'none';
    }
}


