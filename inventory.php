<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="inventory.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<h2><b>Inventory </b></h2>
		<table class="table  table-hover">
			<thead class="thead-dark">
				<tr>
				<th>Part</th>
				<th>Price($)</th>
				<th>Quantity</th>
				</tr>
</thead>
				<?php
				$conn = mysqli_connect("localhost", "root", "", "spare_parts");
				
				$sql = "SELECT  part, price, quantity FROM inventory";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["part"]. "</td><td>" . $row["price"] . "</td><td>"
				. $row["quantity"]. "</td></tr>";
				}
				echo "</table>";
				} else { echo "0 results"; }
				
				?>
				</table>
  <button type="button" onclick="check(this.form)">Next</button>
</div>

<script>
function check(form) {
	window.location.replace("Cust_info.html")
  }
	</script>

</body>
</html>

