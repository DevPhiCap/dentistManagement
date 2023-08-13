// Get references to the modal elements
const modal = document.getElementById("myModal");
const closeButton = document.querySelector(".close");
const container = document.getElementById("container");

// Function to open the modal
function openModal() {
  container.classList.add("active");
  modal.style.display = "block";
  setTimeout(function() {
    modal.style.opacity = 1;
    modal.style.transform = "translateY(0)";
  }, 10);
  container.classList.add("normal-bg");
}

// Function to close the modal
function closeModal() {
  modal.style.opacity = 0;
  modal.style.transform = "translateY(-20px)";
  setTimeout(function() {
    modal.style.display = "none";
    modal.classList.remove("active");
  }, 300);
  container.classList.remove("normal-bg");
  container.classList.remove("active");
}

// Event listener for the open modal button
document.getElementById("openModal").addEventListener("click", openModal);

// Event listener for the close button
closeButton.addEventListener("click", closeModal);

// Event listener for clicking outside the modal (to close it)
window.addEventListener("click", function (event) {
  if (event.target === modal) {
    closeModal();
  }
});
