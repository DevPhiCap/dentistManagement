// Get references to the modal elements
const insertModal = document.getElementById("insertModal");
const updateModal = document.getElementById("updateModal");
const updateBtns = document.querySelectorAll('.update-btn');
const closeInsert = document.querySelector(".closeInsert");
const closeUpdate = document.querySelector(".closeUpdate");
const container = document.getElementById("container");

// Function to open the modal
function openModal(modal) {
  container.classList.add("active");
  modal.style.display = "block";
  setTimeout(function() {
    modal.style.opacity = 1;
    modal.style.transform = "translateY(0)";
  }, 10);
  container.classList.add("normal-bg");
}

// Function to close the modal
function closeModal(modal) {
  modal.style.display = "none";
  container.classList.remove("active");
  setTimeout(function() {
    modal.style.opacity = 0;
    modal.style.transform = "translateY(-20px)";
  }, 300);
  container.classList.remove("normal-bg");
  container.classList.remove("active");
}

// Event listener for the insert modal button
document.getElementById("insertBtn").addEventListener("click", function() {
  openModal(insertModal);
});

// Event listener for the update modal button
function openUpdatePatientModal(patientId) {
  var patientidInput = document.getElementById("patientidInput");
  var nameInput = document.getElementById("nameInput");
  var ageInput = document.getElementById("ageInput");
  var phoneInput = document.getElementById("phoneInput");
  var addressInput = document.getElementById("addressInput");

  // Set the form values based on the selected row's data
  var row = document.querySelector(".row-clickable[data-patientid='" + patientId + "']");
  if (row) {
    console.log(patientId);
    var cells = row.getElementsByTagName("td");
    patientidInput.value = patientId;
    nameInput.value = cells[1].textContent;
    ageInput.value = cells[2].textContent;
    phoneInput.value = cells[3].textContent;
    addressInput.value = cells[4].textContent;
    // Open the modal
    openModal(updateModal); // Use the updated variable
  } else {
    console.error("Row not found for patientId: " + patientId);
  }
}

function openUpdateDetailsModal(detailsid) {
  var detailsidInput = document.getElementById("detailsidInput");
  var motaInput = document.getElementById("motaInput");
  var startdateInput = document.getElementById("startdateInput");
  var enddateInput = document.getElementById("enddateInput");
  // var befimgInput = document.getElementById("befimgInput");
  // var aftimgInput = document.getElementById("aftimgInput");

  // Set the form values based on the selected row's data
  var row = document.querySelector(".row-clickable[data-patientid='" + detailsid + "']");
  if (row) {
    console.log(detailsid);
    var cells = row.getElementsByTagName("td");
    detailsidInput.value = detailsid;
    motaInput.value = cells[1].textContent;
    startdateInput.value = parseDate(cells[2].textContent);
    enddateInput.value = parseDate(cells[3].textContent);
    // Open the modal
    openModal(updateModal); // Use the updated variable
  } else {
    console.error("Row not found for patientId: " + patientId);
  }
}


// Function to parse the date from "dd/mm/yyyy" format to "mm/dd/yyyy" format
function parseDate(dateString) {
  const parts = dateString.split("/");
  if (parts.length !== 3) {
    return "";
  }
  const day = parts[0];
  const month = parts[1];
  const year = parts[2];
  const formattedDate = `${year}-${month}-${day}`;
  return formattedDate;
}



// Event listener for the close button
closeInsert.addEventListener("click", function() {
  closeModal(insertModal); // Pass the insertModal as an argument
});
closeUpdate.addEventListener("click", function() {
  closeModal(updateModal); // Pass the updateModal as an argument
});

// Event listener for clicking outside the modal (to close it)
window.addEventListener("click", function (event) {
  if (event.target === insertModal || event.target === updateModal) {
    closeModal(insertModal);
    closeModal(updateModal);
  }
});
