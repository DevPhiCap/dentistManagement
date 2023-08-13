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
  <link rel="stylesheet" href="customer.css">
  <title>Quan ly khach hang</title>
</head>
<body>
    <div id="container" class="container">
        <h2>quan ly khach hang</h2>
        <button id="openModal" class="submit" onclick="openModal()">Them khach hang</button>

        <div id="myModal" class="modal">
            <div id="modalContent" class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
                <form action="insertCustomer.php" method="post">
                <table class="form">
                    <tr>
                        <th colspan="2">
                            <h3>Them thong tin khach hang</h3>
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
                            <input class="inputform" type="age" name="age" placeholder="Age" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Số điện thoại</span>
                        </td>
                        <td>
                            <input class="inputform" type="phone" name="phone" placeholder="Phone" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="stcol">
                            <span>Địa chỉ</span>
                        </td>
                        <td>
                            <input class="inputform" type="address" name="address" placeholder="Address" required>
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


        <div class="dataTable">
            <table class="data">
                <thead>
                    <tr class="head">
                        <th id="nameHeader" >Name</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the sorted data in the HTML table
                    if (!empty($result)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='row-clickable' onclick='redirectToPatientDetails(" . $row['patientid'] . ")'>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['phoneno'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
                
            </table>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="test.js"></script>
</body>
</html>