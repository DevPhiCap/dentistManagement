<?php
// Database connection configuration
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the patientId from the URL
$patientId = $_GET['patientId'];
// Retrieve the patient name from the benhnhan table
$patientName = "";
$patientQuery = "SELECT name FROM benhnhan WHERE patientId = ?";
$stmt = $conn->prepare($patientQuery);
$stmt->bind_param("s", $patientId);
$stmt->execute();
$stmt->bind_result($patientName);
$stmt->fetch();
$stmt->close();

// Fetch data from the details table
$query = "SELECT * FROM details WHERE patientId = $patientId";
$result = $conn->query($query);

// Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Update status and enddate if the "Hoanthien" button is clicked
//     if(isset($_POST['hoanthien']) && isset($_POST['detailId'])) {
//         $getDetailId = $_POST['detailId'];
//         $updateQuery = "UPDATE details SET status = 'da hoan thanh', enddate = CURDATE() WHERE detailsid = ? AND status = 'chua hoan thien'";
//         $stmt = $conn->prepare($updateQuery);
//         $stmt->bind_param("i", $getDetailId);
//         $stmt->execute();
//         $stmt->close();

//         // Redirect back to the current page
//         header("Location: patientDetails.php?patientId=" . $patientId);
//         exit();
//     }
// }

// Close the database connection
$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ho so benh nhan</title>
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    
    <div id="container" class="container">
        <button onclick="redirectToCustomerTable()" class="submit">Back</button>

        <?php echo "<h2>Ho so benh nhan " . $patientName . "</h2>"; ?>
        
        <button id="openModal" class="submit">Them benh an</button>

        <div id="myModal" class="modal">
            <div id="modalContent" class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
                <form id="patientInfo" action="insertDetails.php?patientId=<?php echo $_GET['patientId']; ?>" method="POST" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <th colspan="2">
                                <h3>Them benh an</h3>
                            </th>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Mô tả</span>
                            </td>
                            <td>
                                <input class="inputform" type="text" name="mota" placeholder="Mo ta chan doan" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ngày bắt đầu</span>
                            </td>
                            <td>
                                <input class="inputform" type="date" name="startdate" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ngày hoàn thành</span>
                            </td>
                            <td>
                                <input class="inputform" type="date" name="enddate" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh trước khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="befimg" id="befImgFileInput" onchange="handleImageUpload('befImgFileInput')" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh sau khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="aftimg" id="aftImgFileInput" onchange="handleImageUpload('aftImgFileInput')" required>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="addbutton" class="addBtn">
                                <input type="submit" value="Add" class="submit">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="dataTable">
            <table class="data">
                <thead>
                    <tr class="head">
                        <th id="nameHeader">Mota</th>
                        <th id="startdateHeader">Ngay bat dau</th>
                        <th id="enddateHeader">Ngay hoan thanh</th>
                        <th>Truoc dieu tri</th>
                        <th>Sau dieu tri</th>
                        <!-- <th>Trang thai</th> -->
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Retrieve and store the sorted data in an array
                    $sortedData = array();
                    if (!empty($result)) {
                        while ($row = $result->fetch_assoc()) {
                            $sortedData[] = $row;
                        }
                    }

                    // Display the sorted data in the HTML table
                    if (!empty($result)) {
                        foreach ($sortedData as $row) {
                            echo "<tr>";
                            echo "<td style='max-width: 160px;word-wrap: break-word;padding:10px;'>" . $row['mota'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['startdate'])) . "</td>";
                            // Check if the enddate is 'chua co' or a valid date
                            if ($row['enddate'] == 'chua co') {
                                echo "<td>" . $row['enddate'] . "</td>";
                            } else {
                                echo "<td>" . date('d/m/Y', strtotime($row['enddate'])) . "</td>";
                            }
                            
                            // Add the image cell
                            echo "<td>";
                            if (!empty($row['befimg'])) {
                                echo "<img src='" . $row['befimg'] . "' alt='before' style='width: 100px; height: auto;' onclick='enlargeImage(this)'>";
                            }
                            echo "</td>";
                            echo "<td>";
                            if (!empty($row['aftimg'])) {
                                echo "<img src='" . $row['aftimg'] . "' alt='after' style='width: 100px; height: auto;' onclick='enlargeImage(this)'>";
                            }
                            echo "</td>";

                            // echo "<td>" . $row['status'] . "</td>";
                            
                            // Add the "Hoanthien" button if status is "chua hoan thien"
                            // if ($row['status'] == "chua hoan thien") {
                            //     echo "<td>
                            //             <form method='post'>
                            //                 <input type='hidden' name='detailId' value='" . $row['detailsid'] . "'>
                            //                 <button type='submit' name='hoanthien' value='hoanthien' class='submit'>Hoanthien</button>
                            //             </form>
                            //         </td>";
                            // } else {
                            //     echo "<td></td>";
                            // }
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                ?>
            </tbody>
                </tbody>
                
            </table>
        </div>
    </div>

    <script src="patientDetails.js"></script>
    <script src="test.js"></script>
    <script src="script.js"></script>
    <script>
        function enlargeImage(image) {
            var enlargedImage = document.createElement("div");
            enlargedImage.className = "enlarged-image";
            enlargedImage.style.backgroundImage = "url('" + image.src + "')";
            document.body.appendChild(enlargedImage);

            enlargedImage.addEventListener("click", function () {
            document.body.removeChild(enlargedImage);
            });
        }
    </script>
</body>
</html>