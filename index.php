<?php

//chmod("./shopping-cart-manager.php", 0755);
require_once('./shopping-cart-manager.php');
// Start the session
session_start();
add_to_cart();
// echo '<pre>';
// print_r($_SESSION['shoppingCart']);
// echo '<pre>';
// test();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./assets/scss/style.css">
    <title>AZStore</title>
</head>

<body class="body-index">
    <header>
        <h1>AZ[store]</h1>
        <div class="cart">
            <form action="shopping-cart.php" method="post">
                <button type="submit" class="btn-cart"><img src="./assets/img/shopping-cart.svg" alt="shopping-cart" class="shopping-cart"></button>
            </form>
            <div class="bubble"><?php displayTotalCount() ?></div>
        </div>
    </header>


    <main>
        <section>
        <div class="slogan">
            <div class="right-one-div">
                <h2 class="right-one">shoe the right <i class="blue">one</i>.</h2>
                <button class="slogan-btn">See our store</button>
            </div>
        </section>
        <section>
            <div class="shoe-nike-div">
                    <img src="./assets/img/shoe_one.png" alt="big shoe" class="big-shoe">
                    <p class="nike">NIKE</p>
                </div>
            </div>
            <div class="container itemsContainer">
                <div class="last-products">
                    <h2 class="last"><i>Our</i> last products</h2>
                </div>

                <?php
                //on appele la fonction dans l'html
                all_items(); ?>
            </div>
        </section>
    </main>
</body>

</html>
<?php



//afficher les items de la base de données
function all_items()
{
    //mettre fonction data_items(entièreté de la dtae base) dans une variable
    $items = data_items();
    //pour chaque item
    foreach ($items as $item) {
        //on génère l'élément html
        $current_item = item_html_template($item["image_url"], $item["product"], $item["price"], $item["id"]);
        //on l'affiche
        echo $current_item;
    }
}

//fonction pour générer les items dans l'html
function item_html_template($image_url, $product_name, $price, $id)
{
    $item_html =
    '<div class="item">
        <img src="' . $image_url . '"alt="img" class="imgShoe">
        <div class="div-add-infos">
            <h3 class="productName">' . $product_name . '</h3>
            <p class="price">' . $price . '€</p>
        </div>
        <form method="GET" action="index.php">
            <button value="' . $id . '" type="submit" name="id" class="btn-items">add to cart</button>
        </form>
    </div>';
    //get/post va stocker l'id dans une variable id car name = id dont la valeur se trouve dans value
    return $item_html;
}

function add_to_cart()
{
    //si id présent 
    if (isset($_GET['id'])) {
        //alors lance fonction get_by_id
        $item = get_by_id($_GET['id']);
        //ajouter l'item au shopping cart
        add_item_to_shopping_cart($item);
    }
}


function get_by_id($id)
{
    //appeler la fonction data_items (éléments de la data base)
    $all_items = data_items();
    //pour chaque item
    foreach ($all_items as $item) {
        //si l'id du json == à l'id demandée dans la value du bouton
        if ($item['id'] == $id) {
            //alors return $item
            return $item;
        }
    }
    return null;
}

function add_item_to_shopping_cart($item)
{
    if (isset($_SESSION["shoppingCart"])) {

        if (array_key_exists($item['id'], $_SESSION["shoppingCart"])) {

            incrementItemCount($item['id']);
        } else {

            addNewItemToCart($item);
        }
    } else {
        createCart();
        addNewItemToCart($item);
    }

    update_totalCount_cart();

    update_totalPrrice_cart();
}





function createCart()
{
    $_SESSION["shoppingCart"] = array(
        "TotalPriceCart" => 0,
        "TotalItemsCount" => 0
    );
}

//Créer le panier dans $_Session
function addNewItemToCart($item)
{
    $_SESSION["shoppingCart"][$item['id']] = array(
        "image_url" => $item['image_url'],
        "productName" => $item['product'],
        "itemPrice" => $item['price'],
        "count" => 1,
        "totalPriceItem" => $item['price']
    );
}



//afficher le nombres total d'items dans la div "cart"
function displayTotalCount()
{
    if (isset($_SESSION['shoppingCart'])) {
        echo $_SESSION['shoppingCart']["TotalItemsCount"];
    } else {
        echo 0;
    }
}





function test()
{
    session_destroy();
}
