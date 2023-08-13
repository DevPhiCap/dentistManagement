function redirectToCustomerTable() {
    window.location.href = 'customerTable.php';
}

function handleImageUpload(inputId) {
    var fileInput = document.getElementById(inputId);
    var file = fileInput.files[0];
    
    var reader = new FileReader();
    reader.onload = function(event) {
        var imageSrc = event.target.result;
        console.log("Image Source: " + imageSrc);
        // You can perform further actions with the image source here
    };

    reader.readAsDataURL(file);
}
