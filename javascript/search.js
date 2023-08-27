function searchTable() {
    // Get the input values entered by the user
    var inputname = document.getElementById('searchInputName').value.toLowerCase();
    var inputage = document.getElementById('searchInputAge').value.toLowerCase();
    var inputphone = document.getElementById('searchInputPhone').value.toLowerCase();
    var inputaddress = document.getElementById('searchInputAddress').value.toLowerCase();
  
    // Get all the rows of the table
    var table = document.getElementById('customerTable');
    var rows = table.getElementsByTagName('tr');
  
    // Iterate through each row and hide/show based on the input values
    for (var i = 0; i < rows.length; i++) {
      var name = rows[i].getElementsByTagName('td')[1];
      var age = rows[i].getElementsByTagName('td')[2];
      var phone = rows[i].getElementsByTagName('td')[3];
      var address = rows[i].getElementsByTagName('td')[4];
  
      var displayRow = true; // Assume the row should be displayed
  
      if (name) {
        var nameText = name.textContent.toLowerCase();
        if (inputname && !nameText.includes(inputname)) {
          displayRow = false;
        }
      }
      if (age) {
        var ageText = age.textContent.toLowerCase();
        if (inputage && !ageText.includes(inputage)) {
          displayRow = false;
        }
      }
      if (phone) {
        var phoneText = phone.textContent.toLowerCase();
        if (inputphone && !phoneText.includes(inputphone)) {
          displayRow = false;
        }
      }
      if (address) {
        var addressText = address.textContent.toLowerCase();
        if (inputaddress && !addressText.includes(inputaddress)) {
          displayRow = false;
        }
      }
  
      // Set the display style based on the flag variable
      rows[i].style.display = displayRow ? '' : 'none';
    }
  }