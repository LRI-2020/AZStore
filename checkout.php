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

    <form method="post" action="">

        <label for="firstname">Firstname:</label>
        <input type="text" name="firstname" id="firstname" required><br><br>

        <label for="lastname">Lastname:</label>
        <input type="text" name="lastname" id="lastname" required><br><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br><br>

        <label for="address">Adress:</label>
        <input type="text" name="address" for="adress" required><br><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" required><br><br>

        <label for="zip">Zip code:</label>
        <input type="number" name="zip" id="zip" required><br><br>

        <label for="country">Country:</label>
        <input type="text" name="country" id="country" required><br><br>

        <input type="submit">

    </form>
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


function send_form()
{
    //vérifie si le form a été soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $address = isset($_POST['address']) ? $_POST['address'] : "";
        $city = isset($_POST['city']) ? $_POST['city'] : "";
        $zip = isset($_POST['zip']) ? $_POST['zip'] : "";
        $country = isset($_POST['country']) ? $_POST['country'] : "";
        //verifier si les champs ne sont pas vides
        if (!empty($firstname) and !empty($lastname) and !empty($email) && !empty($address) && !empty($city) && !empty($zip) && !empty($country)) {
            echo '<script> alert("Your order is validated!");</script>';
            unset($_SESSION['shoppingCart']);
        } else {
            // Affichez un message d'erreur si des données sont manquantes
            echo '<script>alert("Please fill in all required fields.");</script>';
        }
    }
};
send_form();
