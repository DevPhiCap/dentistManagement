<?php
// Database connection configuration
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/customer.css">
  <title>Quản lý khách hàng</title>
</head>
<body>
    <div id="container" class="container">
        <h2>Quản lý khách hàng</h2>
        <button id="insertBtn" class="submit">Thêm khách hàng</button>
        <!-- search -->
        <div class="searchDiv">
            <input type="text" id="searchInput" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng tên..." />

            <select id="startyearSelect" class="selectInput">
                <?php
                echo "<option value='' selected disabled>Chọn năm bắt đầu</option>";
                echo "<option value='' unselected>none</option>";
                //getcurrent year
                $currentYear = date("Y");
                //generate start year
                for ($year = $currentYear; $year >= 1970; $year--) {
                    $selected = ($selectedYear == $year) ? 'selected' : 'unselected';
                    echo "<option value='$year' $selected>$year</option>";
                }
                ?>
            </select>
            <select id="endyearSelect" class="selectInput">
                <?php 
                echo "<option value='' selected disabled>Chọn năm hoàn thành</option>";
                echo "<option value='' unselected>none</option>";
                // generate end year
                for ($year = $currentYear; $year >= 1970; $year--) {
                    $selected = ($selectedYear == $year) ? 'selected' : 'unselected';
                    echo "<option value='$year' $selected>$year</option>";
                }
                ?>
            </select>
            <button onCLick="updateURL()">Tim</button>
        </div>
        
        <!-- insert form -->
        <div id="insertModal" class="modal">
            <div id="modalContent" class="modal-content">
            <span class="closeInsert">&times;</span>
                <form action="insertCustomer.php" method="POST">
                <table class="form">
                    <tr>
                        <th colspan="2">
                            <h3>Thêm thông tin khách hàng</h3>
                        </th>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Tên</span>
                        </td>
                        <td>
                            <input class="inputform" type="text" name="name" placeholder="Name" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Tuổi</span>
                        </td>
                        <td>
                            <input class="inputform" type="text" name="age" placeholder="Age" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Số điện thoại</span>
                        </td>
                        <td>
                            <input class="inputform" type="text" name="phone" placeholder="Phone" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Địa chỉ</span>
                        </td>
                        <td>
                            <input class="inputform" type="text" name="address" placeholder="Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="addBtn">
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
                <form action="updateCustomer.php" method="POST">
                <table class="form">
                    <tr>
                    <th colspan="2">
                        <h3>Cập nhật thông tin khách hàng</h3>
                    </th>
                    </tr>
                    <tr>
                    <td class="stcol">
                        <span>Tên</span>
                    </td>
                    <td>
                        <input id="nameInput" class="inputform" type="text" name="name" placeholder="Name" required>
                    </td>
                    </tr>
                    <tr>
                    <td class="stcol">
                        <span>Tuổi</span>
                    </td>
                    <td>
                        <input id="ageInput" class="inputform" type="text" name="age" placeholder="Age" required>
                    </td>
                    </tr>
                    <tr>
                    <td class="stcol">
                        <span>Số điện thoại</span>
                    </td>
                    <td>
                        <input id="phoneInput" class="inputform" type="text" name="phone" placeholder="Phone" required>
                    </td>
                    </tr>
                    <tr>
                    <td class="stcol">
                        <span>Địa chỉ</span>
                    </td>
                    <td>
                        <input id="addressInput" class="inputform" type="text" name="address" placeholder="Address" required>
                    </td>
                    </tr>
                    <tr>
                    <td></td>
                    <td class="addBtn">
                        <input id="patientidInput" type="hidden" name="patientid">
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
                        <th id="nameHeader" >Tên</th>
                        <th>Tuổi</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectedStartYear = isset($_GET['startyear']) ? $_GET['startyear'] : '';
                    $selectedEndYear = isset($_GET['endyear']) ? $_GET['endyear'] : '';
                    // Prepare and execute the query
                    if (!empty($selectedStartYear) && !empty($selectedEndYear)) {
                        // Query with both start year and end year condition
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ? AND YEAR(dt.enddate) = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ii", $selectedStartYear, $selectedEndYear);
                        $stmt->execute();
                    } else if (!empty($selectedStartYear)) {
                        // Query with start year condition
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $selectedStartYear);
                        $stmt->execute();
                    } else if (!empty($selectedEndYear)) {
                        // Query with end year condition
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.enddate) = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $selectedEndYear);
                        $stmt->execute();
                    } else {
                        // Query without year condition
                        $query = "SELECT * FROM benhnhan";
                        $result = $conn->query($query);
                    }

                    // Retrieve the results
                    $result = isset($stmt) ? $stmt->get_result() : $result;

                    $count = 1;
                    // Display the sorted data in the HTML table
                    if (!empty($result)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='row-clickable' data-patientid=". $row['patientid'] .">";
                            echo "<td>" . $count . "</td>";
                            echo "<td onclick='redirectToPatientDetails(". $row['patientid'] .")'>" . $row['name'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['phoneno'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td class='button-cell'>
                                <button class='open-btn' id='openBtn_". $row['patientid'] ."' onclick='toggleButtons(". $row['patientid'] .")'>Open</button>
                                <div class='btn-div' id='btnDiv_". $row['patientid'] ."' style='display: none;'>
                                    <button class='update-btn' onClick='openUpdatePatientModal(".$row['patientid'].")'>Sửa</Button>
                                    <form method='POST' action='deleteCustomer.php'>
                                        <input type='hidden' name='patientid' value='". $row['patientid'] ."'>
                                        <button class='delete-btn' type='submit'>Xóa</button>
                                    </form>
                                    <span class='closeBtnDiv' onclick='toggleButtons(". $row['patientid'] .")'>&times;</span>
                                </div>
                            </td>";
                            echo "</tr>";
                            $count++;
                        }
                        if (isset($stmt)) {
                            $stmt->close();
                        }
                        $result->free();
                    } else {
                        echo "<tr><td colspan='4'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
                
            </table>
        </div>
    </div>


    <script src="../javascript/modal.js"></script>
    <script src="../javascript/sort.js"></script>
    <script src="../javascript/search.js"></script>
    <script src="../javascript/buttonDiv.js"></script>
    <script>
        function updateURL() {
            var startyearSelect = document.getElementById("startyearSelect");
            var endyearSelect = document.getElementById("endyearSelect");
            var selectedStartYear = startyearSelect.options[startyearSelect.selectedIndex].value;
            var selectedEndYear = endyearSelect.options[endyearSelect.selectedIndex].value;

            // Store the selected values in variables
            var newStartYearValue = selectedStartYear ? selectedStartYear : '';
            var newEndYearValue = selectedEndYear ? selectedEndYear : '';

            // Update the URL with the selected years
            if (newStartYearValue || newEndYearValue) {
                var currentURL = new URL(window.location.href);
                currentURL.searchParams.set('startyear', newStartYearValue);
                currentURL.searchParams.set('endyear', newEndYearValue);
                window.history.pushState({}, '', currentURL);
            } else {
                var currentURL = new URL(window.location.href);
                currentURL.searchParams.set('startyear', '');
                currentURL.searchParams.set('endyear', '');
                window.history.pushState({}, '', currentURL);
            }

            window.location.reload();
        }
    </script>
    <?php
        $conn->close();
    ?>
</body>
</html>