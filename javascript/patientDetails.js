function redirectToCustomerTable() {
    var currentURL = new URL(window.location.href);
    var startYear = currentURL.searchParams.get('startyear');
    var endYear = currentURL.searchParams.get('endyear');

    // Update the URL with query parameters
    var newURL = '/customerManagement/customer/customerTable.php';
    if (startYear && endYear) {
        newURL += '?startyear=' + startYear + '&endyear=' + endYear;
    } else if (startYear) {
        newURL += '?startyear=' + startYear;
    } else if (endYear) {
        newURL += '?endyear=' + endYear;
    }

    // Replace the current state with the updated URL
    history.replaceState({}, '', newURL);

    // Go back to the previous page
    window.history.back();
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

