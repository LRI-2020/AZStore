<?php
require_once('./shopping-cart-manager.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class='summary'>
        <div class="products">
            <?php display_item_cart() ?>
        </div>
        <div class="globalPrice">
            <p>Total price:<?php display_total_price() ?></p>
        </div>
    </div>
</body>

</html>

<?php


function display_item_cart()
{
    $all_items_cart = total_items_shopping_cart();

    foreach ($all_items_cart as $item_cart) {
        echo item_checkout_template($item_cart);
    }
}

function item_checkout_template($item_cart)
{
    $item_checkout =
        '<div class="product">
        <h3>' . $item_cart["productName"] . '</h3>
        <p class="items-cart">' . $item_cart["count"] . '</p>
        <p class="price-items-cart">' . $item_cart["totalPriceItem"] . '</p>
    </div>';
    //get/post va stocker l'id dans une variable id car name = id dont la valeur se trouve dans value
    return $item_checkout;
}


function display_total_price()
{
    if (isset($_SESSION['shoppingCart'])) {
        echo $_SESSION['shoppingCart']['TotalPriceCart'];
    } else {
        echo "0";
    }
}
