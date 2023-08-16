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