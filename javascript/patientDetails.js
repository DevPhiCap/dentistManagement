function redirectToCustomerTable() {
    window.location.href = '../customer/customerTable.php';
}

function handleImageUpload(inputId) {
    var fileInput = document.getElementById(inputId);
    var selectedFile = fileInput.files[0];
    console.log(selectedFile);
    
    if (selectedFile) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var imageSrc = event.target.result;
            console.log("Image Source: " + imageSrc);
            // You can perform further actions with the image source here
        };

        reader.readAsDataURL(selectedFile);
    } else {
        console.log("No file selected.");
    }
}

