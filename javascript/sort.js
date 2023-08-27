document.addEventListener('DOMContentLoaded', function () {
  // Get the table header elements by ID
  const nameHeader = document.getElementById('nameHeader');

  // Get the table body rows
  const tableBody = document.querySelector('.data tbody');
  const rows = Array.from(tableBody.getElementsByTagName('tr'));

  // Add a click event listener to the name header
  nameHeader.addEventListener('click', function () {
    sortTableByColumn(1, nameHeader);
  });

  function sortTableByColumn(columnIndex, header) {
    // Check the current sorting order
    const isAscending = header.classList.contains('asc');

    // Sort the rows based on the column
    rows.sort(function (rowA, rowB) {
      const cellA = rowA.cells[columnIndex].textContent.trim();
      const cellB = rowB.cells[columnIndex].textContent.trim();

      if (isAscending) {
        return cellA.localeCompare(cellB);
      } else {
        return cellB.localeCompare(cellA);
      }
    });

    // Remove existing rows from the table
    while (tableBody.firstChild) {
      tableBody.removeChild(tableBody.firstChild);
    }

    // Append the sorted rows back to the table
    rows.forEach(function (row) {
      tableBody.appendChild(row);
    });

    // Toggle the sorting order class
    header.classList.toggle('asc');
  }
});

function redirectToPatientDetails(patientId) {
  // Redirect to patientDetails.php with the patientId parameter
  window.location.href = '../details/patientDetails.php?patientId=' + patientId + '&startdate=asc';
}