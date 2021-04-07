<?php
    session_start();
   // Connect to the database  
    $conn = mysqli_connect("localhost", "root", "", "spare_parts");
    if (isset($_POST['order'])) {
        if(isset($_SESSION["shopping_cart"])) {
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
            if(!in_array($_GET["id"], $item_array_id)) {  
                 $count = count($_SESSION["shopping_cart"]);  
                 $item_array = array(  
                      'item_id' => $_GET["id"],  
                      'item_name' => $_POST["hidden_part"],  
                      'item_price' => $_POST["hidden_price"],  
                      'item_quantity' => $_POST["quantity"]);  
                 $_SESSION["shopping_cart"][$count] = $item_array;  
            } else {  
                echo '<script>alert("Item Already Added")</script>';
            }  
       } else  {  
            $item_array = array(  
                 'item_id' => $_GET["id"],  
                 'item_name' => $_POST["hidden_part"],  
                 'item_price' => $_POST["hidden_price"],  
                 'item_quantity' => $_POST["quantity"]  
            );  
            $_SESSION["shopping_cart"][0] = $item_array;  
       }
    }

    if(isset($_GET["action"]))  {  
         if($_GET["action"] == "delete")  {  
              foreach($_SESSION["shopping_cart"] as $keys => $values)  {  
                   if($values["item_id"] == $_GET["id"])  {  
                        unset($_SESSION["shopping_cart"][$keys]);  
                        echo '<script>alert("Item Removed")</script>'; 
                   }  
              }  
         }  
    }
    
?>
<!DOCTYPE html>
<html>

<head>
    <title>Order</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="inventory.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2 class="text-center">PLACE YOUR ORDER</h2><br>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT  * FROM inventory";
                    $result = $conn->query($sql);
                 while($row = $result->fetch_assoc())  {  ?>
                <form method="post" action="order.php?action=add&id=<?php echo $row["id"]; ?>">
                    <tr>
                        <td width="30%">
                            <?php echo $row["part"]; ?>
                        </td>
                        <td width="10%">$
                            <?php echo $row["price"]; ?>
                        </td>
                        <td width="10%"><input type="number" name="quantity" class="form-control" min="1"
                                max="<?php echo $row["quantity"]; ?>"></td>
                        <input type="hidden" name="hidden_part" value="<?php echo $row["part"]; ?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                        <td width="5%"><input type="submit" name="order" class="btn btn-success btn-sm" value="Order">
                        </td>
                    </tr>
                </form>
                <?php } ?>
            </tbody>
        </table>
        <h3>Order Details</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Part Name</th>
                    <th width="10%">Quantity</th>
                    <th width="10%">Price</th>
                    <th width="15%">Total</th>
                    <th width="5%">Action</th>
                </tr>
                <?php   
                    if(!empty($_SESSION["shopping_cart"]))  {  
                         $total = 0;  
                         foreach($_SESSION["shopping_cart"] as $keys => $values) {  
                    ?>
                <tr>
                    <td>
                        <?php echo $values["item_name"]; ?>
                    </td>
                    <td>
                        <?php echo $values["item_quantity"]; ?>
                    </td>
                    <td>$
                        <?php echo $values["item_price"]; ?>
                    </td>
                    <td>$
                        <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?>
                    </td>
                    <td><a href="order.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span
                                class="text-danger">Remove</span></a></td>
                </tr>
                <?php  
                            $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                        }  
                    ?>
                <tr>
                    <td colspan="3" class="text-right"><b>Grand Total</b></td>
                    <td><b>$
                            <?php echo number_format($total, 2); ?></b></td>
                    <td></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>