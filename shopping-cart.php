<?php
require_once('./shopping-cart-manager.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
startAllListeners();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/scss/style.css">
    <title>Document</title>
</head>

<body class='body-shopping'>
<div class="allProducts">

<div class="products">
    <?php displayCartItems(); ?>
</div>
</div>

<div class="form">

    <div class='buttonsDiv'>
        <form action="index.php" method="POST">
            <input type="submit" value="Index" name="index" class="redirect">
        </form>
        <form action="checkout.php" method="POST">
            <input type="submit" value="Checkout" name="checkout" class="redirect">
        </form>

        <p class="cartInfo"> <?php echo 'Total price : '; echo totalPrice(); echo '$'; ?></p>
        <p class="cartInfo"> <?php echo 'Total articles count : '; echo totalCountCart(); ?></p>
    </div>

</body>

</html>

<?php
    function displayCartItems()
    {
        if(isset($_SESSION['shoppingCart']))
        foreach ($_SESSION['shoppingCart'] as $key => $value) {
            if (is_int($key)) {
                //Display $article
                echo '<div class="product">
                        <div class="image_url">
                                <img src="' . $value["image_url"] . '">
                        </div>
                        <p class="itemPrice">' . $value["itemPrice"] . '$</p>
                        <div class="articleCount">
                          <form method="POST">
                             <button value="'.$key.'" type="submit" name="inc" class="Inc"> + </button>
                          </form>
                          <p class="itemCount">' . $value["count"] . '</p>
                          <form method="POST">
                             <button value="'.$key.'" type="submit" name="dec" class="Dec"> - </button>
                          </form>
                        </div>
                        <p class="totalPriceItem">' . $value["totalPriceItem"] . '$</p>
                  <form method="POST">
                      <button value="'.$key.'" type="submit" name="delete" class="delete">Delete product</button>
                  </form>
                    </div>';
            }
        }
    }

    function startAllListeners(){
        listenForDelete();
        listenForInc();
        listenForDec();
    }

    function listenForDelete()
    {
        if (isset($_POST["delete"])) {
            $id = $_POST["delete"];
            removeArticleFromCart($id);
            header('Location: shopping-cart.php');
        }

   }

   function removeArticleFromCart($itemId){

       if (array_key_exists($itemId, $_SESSION['shoppingCart'])){
           unset($_SESSION['shoppingCart'][$itemId]);
       }
       //recompute total count
       update_totalCount_cart();
       //recompute total price of cart
       update_totalPrrice_cart();
   }

function listenForInc()
{
    if (isset($_POST["inc"])) {
        $id = $_POST["inc"];
        IncrementItemCount($id);
        update_totalCount_cart();
        update_totalPrrice_cart();
         header('Location: shopping-cart.php');
    }

}

function listenForDec()
{
    if (isset($_POST["dec"])) {
        $id = $_POST["dec"];
        decrementItemCount($id);
        update_totalCount_cart();
        update_totalPrrice_cart();
        header('Location: shopping-cart.php');
    }

}


?>