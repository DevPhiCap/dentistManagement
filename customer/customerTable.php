<?php
// Database connection configuration
$conn = new mysqli("localhost", "root", "", "customer");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$query = "SELECT * FROM benhnhan";
$result = $conn->query($query);

// Close the database connection
$conn->close();
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
</body>
</html>