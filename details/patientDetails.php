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


// Close the database connection
$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ bệnh nhân</title>
    <link rel="stylesheet" href="../css/customer.css">
</head>
<body>
    
    <div id="container" class="container">
        <button onclick="redirectToCustomerTable()" class="submit">Back</button>

        <?php echo "<h2>Hồ sơ bệnh nhân " . $patientName . "</h2>"; ?>
        
        <button id="insertBtn" class="submit">Thêm bệnh án</button>
        <!-- search -->
        <div class="searchDiv">
            <input type="text" id="searchInput" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng mô tả..." />
            <!-- <button id="searchBtn" class="searchBtn" onClick="searchTable()">Tìm</button> -->
        </div>
        <!-- insert form -->
        <div id="insertModal" class="modal">
            <div id="modalContent" class="modal-content">
                <span class="closeInsert">&times;</span>
                <form action="insertDetails.php?patientId=<?php echo $_GET['patientId']; ?>" method="POST" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <th colspan="2">
                                <h3>Thêm bệnh án</h3>
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
                                <input class="inputform" type="date" name="enddate" >
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh trước khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="befimg" id="insertefImgFileInput" onchange="handleImageUpload('insertefImgFileInput')" >
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh sau khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="aftimg" id="insertaftImgFileInput" onchange="handleImageUpload('insertaftImgFileInput')" >
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

        <!-- update form -->
        <div id="updateModal" class="modal">
            <div id="modalContent" class="modal-content">
                <span class="closeUpdate">&times;</span>
                <form id="patientInfo" action="updateDetails.php?patientId=<?php echo $_GET['patientId']; ?>" method="POST" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <th colspan="2">
                                <h3>Sửa bệnh án</h3>
                            </th>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Mô tả</span>
                            </td>
                            <td>
                                <input id="motaInput" class="inputform" type="text" name="mota" placeholder="Mo ta chan doan" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ngày bắt đầu</span>
                            </td>
                            <td>
                                <input id="startdateInput" class="inputform" type="date" name="startdate" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ngày hoàn thành</span>
                            </td>
                            <td>
                                <input id="enddateInput" class="inputform" type="date" name="enddate">
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh trước khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="befimg" id="updatebefImgFileInput" onchange="handleImageUpload('updatebefImgFileInput')">
                            </td>
                        </tr>
                        <tr>
                            <td class="stcol">
                                <span>Ảnh sau khi điều trị</span>
                            </td>
                            <td>
                                <input class="inputform" type="file" name="aftimg" id="updateaftImgFileInput" onchange="handleImageUpload('updateaftImgFileInput')">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="addbutton" class="addBtn">
                                <input id="detailsidInput" type="hidden" name="detailsid">
                                <input type="submit" value="Update" class="submit">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <!-- data table -->
        <div class="dataTable">
            <table id="customerTable" class="data">
                <thead>
                    <tr class="head">
                        <th>Stt</th>
                        <th>Mô tả</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày hoàn thành</th>
                        <th>Trước điều trị</th>
                        <th>Sau điều trị</th>
                        <th>Chức năng</th>
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

                    $count = 1;
                    // Display the sorted data in the HTML table
                    if (!empty($result)) {
                        foreach ($sortedData as $row) {
                            echo "<tr class='row-clickable' data-patientid=". $row['detailsid'] .">";
                            echo "<td>".$count."</td>";
                            echo "<td style='max-width: 160px;word-wrap: break-word;padding:10px;'>" . $row['mota'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['startdate'])) . "</td>";
                            if($row['enddate'] == null){
                                echo "<td>".$row['enddate'] . "</td>";
                            } else{
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
                            echo "<td class='button-cell'>
                                <button class='open-btn' id='openBtn_". $row['detailsid'] ."' onclick='toggleButtons(". $row['detailsid'] .")'>Open</button>
                                <div class='btn-div' id='btnDiv_". $row['detailsid'] ."' style='display: none;'>
                                    <button class='update-btn' onClick='openUpdateDetailsModal(".$row['detailsid'].")'>Sửa</Button>
                                    <form method='POST' action='deleteDetails.php'>
                                        <input type='hidden' name='patientid' value='" . $row['patientid'] . "'>
                                        <input type='hidden' name='detailsid' value='" . $row['detailsid'] . "'>
                                        <button class='delete-btn' type='submit'>Xóa</button>
                                    </form>
                                    <span class='closeBtnDiv' onclick='toggleButtons(". $row['detailsid'] .")'>&times;</span>
                                </div>
                                </td>";
                            echo "</tr>";
                            $count++;
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

    <script src="../javascript/patientDetails.js"></script>
    <script src="../javascript/modal.js"></script>
    <script src="../javascript/search.js"></script>
    <script src="../javascript/buttonDiv.js"></script>
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