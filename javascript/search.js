function namesearchTable() {
    // Get the input value entered by the user
    var input = document.getElementById('searchInputName').value.toLowerCase();

    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');

    // Iterate through each row and hide/show based on the input value
    for (var i = 0; i < rows.length; i++) {
        var name = rows[i].getElementsByTagName('td')[1]; 

        if (name) {
        var nameText = name.textContent.toLowerCase();

        if (nameText.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
        }
    }
}
function agesearchTable() {
    // Get the input value entered by the user
    var input = document.getElementById('searchInputAge').value.toLowerCase();

    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');

    // Iterate through each row and hide/show based on the input value
    for (var i = 0; i < rows.length; i++) {
        var age = rows[i].getElementsByTagName('td')[2];

        if (age) {
        var ageText = age.textContent.toLowerCase();

        // Check if the name contains the input value
        if (ageText.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
        }
    }
}
function phonesearchTable() {
    // Get the input value entered by the user
    var input = document.getElementById('searchInputPhone').value.toLowerCase();

    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');

    // Iterate through each row and hide/show based on the input value
    for (var i = 0; i < rows.length; i++) {
        var phone = rows[i].getElementsByTagName('td')[3];

        if (phone) {
        var phoneText = phone.textContent.toLowerCase();

        if (phoneText.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
        }
    }
}
function addresssearchTable() {
    // Get the input value entered by the user
    var input = document.getElementById('searchInputAddress').value.toLowerCase();

    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');

    // Iterate through each row and hide/show based on the input value
    for (var i = 0; i < rows.length; i++) {
        var address = rows[i].getElementsByTagName('td')[4]; 

        if (address) {
        var addressText = address.textContent.toLowerCase();

        if (addressText.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
        }
    }
}