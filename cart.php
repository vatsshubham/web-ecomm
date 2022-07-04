<?php

session_start();

require_once ("php/CreateDb.php");
require_once ("php/component.php");

$db = new CreateDb("Product", "Products");

if (isset($_POST['remove'])){
  if ($_GET['action'] == 'remove'){
    //  print_r( $_SESSION['cart']);
      foreach ($_SESSION['cart'] as $key => $value){
          if($value["product_id"] == $_GET['id']){
            print_r( $_GET['id']);
              unset($_SESSION['cart'][$key]);
              echo "<script>alert('Product has been Removed...!')</script>";
              echo "<script>window.location = 'cart.php'</script>";
          }
      }
  }
}


?>

 

<?php
    require_once ('php/header.php');
?>

<div class="container-fluid">
<?php
$total = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart'])>0)  {
    // echo "shubham"
    ?>
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <hr>

                <?php
                $total = 0;
                    // if (isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'product_id');
                        $result = $db->getData();
                        //  print_r($result) ;
                        while ($row = mysqli_fetch_assoc($result)){
                            foreach ($product_id as $id){
                                if ($row['id'] == $id){
                                    // print_r($row['id']);
                                    cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                                    $total = $total + (int)$row['product_price'];
                                }
                            }
                        }
                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                           //      echo "<h6>Price ($count items)</h6>";
                            // }else{
                                echo "<h6>Price (0 items)</h6>";
                            // }
                        ?>
                        <h6>Tax</h6>
                        <hr>
                        <h6>Amount Payable</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>RS<?php echo $total; ?></h6>
                        <h6 class="text-success">18%</h6>
                        <hr>
                        <h6>RS<?php
                            echo ($total + $total*0.18);
                            ?></h6>
                    </div>
                </div>
            </div>

        </div>
   <?php }else{
                        echo "<center> <h1>Oops! Your Cart is Empty</h1></center>";
                    }?>
    </div>
</div>



<?php require_once ("php/footer.php"); ?>
