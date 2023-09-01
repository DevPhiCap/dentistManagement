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
        <button onClick="redirectToCustomerTable()" class="update-btn" style="width:fit-content;">Về bảng mặc định</button>
        <button id="insertBtn" class="submit">Thêm khách hàng</button>
        <!-- search -->
        <div class="searchDiv">
            <input type="text" id="searchInputName" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng tên..." />
            <input type="text" id="searchInputAge" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng tuổi.." />
            <input type="text" id="searchInputPhone" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng số điện thoại..." />
            <input type="text" id="searchInputAddress" class="searchInput" onkeyup="searchTable()" placeholder="Tìm bằng địa chỉ..." />
        </div>
        <button id="yearBtn" class="open-btn" style="width:fit-content;" onClick="yearsearchButton()">Tìm theo năm bệnh án</button>
        <button id="monthBtn" class="open-btn" style="width:fit-content;" onClick="monthsearchButton()">Tìm theo tháng bệnh án</button>
        <button id="scheBtn" class="open-btn" style="width:fit-content;" onClick="schesearchButton()">Tìm theo lịch đến khám</button>
        <div id="yearselect" class="searchDiv" style="display:none;">
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
            <button class="open-btn" onCLick="updateURL()" style="width:fit-content;">Tim theo năm</button>

        </div>
        <div id="monthselect" class="searchDiv" style="display:none;">
            <input type="month" id="startyearmonthSelect" class="monthInput">
            <input type="month" id="endyearmonthSelect" class="monthInput">
            <button class="open-btn" onCLick="updatemonthURL()" style="width:fit-content;">Tim theo tháng</button>
        </div>
        <div id="scheselect" class="searchDiv" style="display:none;">
            <input type="date" id="schedateSelect" class="monthInput">
            <button class="open-btn" onCLick="updatescheURL()" style="width:fit-content;">Tim theo lịch khám</button>
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
                    <td class="stcol">
                        <span>Ngày đến khám</span>
                    </td>
                    <td>
                        <input class="inputform" type="date" name="schedule" placeholder="Schedule" >
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
                    <td class="stcol">
                        <span>Ngày đến khám</span>
                    </td>
                    <td>
                        <input id="scheduleInput" class="inputform" type="date" name="schedule" placeholder="Schedule" >
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
                        <th onClick="sortbySche()">Lịch đến khám</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectedStartYear = isset($_GET['startyear']) ? $_GET['startyear'] : '';
                    $selectedEndYear = isset($_GET['endyear']) ? $_GET['endyear'] : '';
                    $selectedStartYearMonth = isset($_GET['startyearmonth']) ? $_GET['startyearmonth'] : '';
                    $selectedEndYearMonth = isset($_GET['endyearmonth']) ? $_GET['endyearmonth'] : '';
                    $selectedSchedule = isset($_GET['schedule']) ? $_GET['schedule'] : '';
                    $selectedSche = isset($_GET['schedate']) ? $_GET['schedate'] : '';

                    // Select by just year
                    if (!empty($selectedStartYear) && !empty($selectedEndYear)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ? AND YEAR(dt.enddate) = ? 
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ii", $selectedStartYear, $selectedEndYear);
                        $stmt->execute();
                    } else if (!empty($selectedStartYear)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ? 
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $selectedStartYear);
                        $stmt->execute();
                    } else if (!empty($selectedEndYear)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.enddate) = ? 
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $selectedEndYear);
                        $stmt->execute();
                    } 
                    // Select by month and year
                    else if (!empty($selectedStartYearMonth) && !empty($selectedEndYearMonth)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ? AND MONTH(dt.startdate) = ?
                                AND YEAR(dt.enddate) = ? AND MONTH(dt.enddate) = ?
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);
                        
                        list($startYear, $startMonth) = explode('-', $selectedStartYearMonth);
                        list($endYear, $endMonth) = explode('-', $selectedEndYearMonth);

                        $stmt->bind_param("iiii", $startYear, $startMonth, $endYear, $endMonth);

                        $stmt->execute();
                    } else if (!empty($selectedStartYearMonth)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.startdate) = ? AND MONTH(dt.startdate) = ?
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);

                        list($startYear, $startMonth) = explode('-', $selectedStartYearMonth);

                        $stmt->bind_param("ii", $startYear, $startMonth);

                        $stmt->execute();
                    } else if (!empty($selectedEndYearMonth)) {
                        $query = "SELECT bn.*
                                FROM benhnhan bn
                                JOIN details dt ON bn.patientid = dt.patientid
                                WHERE YEAR(dt.enddate) = ? AND MONTH(dt.enddate) = ?
                                ORDER BY bn.schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);

                        list($endYear, $endMonth) = explode('-', $selectedEndYearMonth);

                        $stmt->bind_param("ii", $endYear, $endMonth);

                        $stmt->execute();
                    } 
                    // Select scheduled
                    else if (!empty($selectedSchedule)){
                        $query = "SELECT * FROM benhnhan
                                WHERE schedule = ?
                                ORDER BY schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
                        $stmt = $conn->prepare($query);

                        $stmt->bind_param("s", $selectedSchedule);

                        $stmt->execute();
                    }
                    // Select all
                    else {
                        $query = "SELECT * FROM benhnhan
                            ORDER BY schedule " . ($selectedSche == 'desc' ? 'DESC' : 'ASC');
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
                            if($row['schedule'] == '0000-00-00'){
                                echo "<td>"."</td>";
                            } else{
                                echo "<td>" . date('d/m/Y', strtotime($row['schedule'])) . "</td>";
                            }
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
    <script src="../javascript/updateURL.js"></script>
    <script src="../javascript/patientDetails.js"></script>
    <?php
        $conn->close();
    ?>
</body>
</html>