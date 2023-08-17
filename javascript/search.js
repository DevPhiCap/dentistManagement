function searchTable() {
    // Get the input value entered by the user
    var input = document.getElementById('searchInput').value.toLowerCase();

    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');

    // Iterate through each row and hide/show based on the input value
    for (var i = 0; i < rows.length; i++) {
        var name = rows[i].getElementsByTagName('td')[1]; // Assuming the name is in the first column

        if (name) {
        var nameText = name.textContent.toLowerCase();

        // Check if the name contains the input value
        if (nameText.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
        }
    }
}
