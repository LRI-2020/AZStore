<?php
// Start the session
session_start();
add_to_cart();
//print_r($_SESSION['shoppingCart']);
//test();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./assets/scss/style.css">
    <title>AZStore</title>
</head>

<body>
    <header>
        <h1>Luxury shoes</h1>
        <div class="cart">
            <img src="./assets/img/shopping-cart.svg" alt="shopping-cart" class="shopping-cart">
            <div class="bubble"><?php displayTotalCount() ?></div>
        </div>
    </header>


    <div class="slogan">
        <h2 class="right-one">shoe the right one.</h2>
        <button class="slogan-btn">See our store</button>
        <img src="./assets/img/shoe_one.png" alt="big shoe" class="big-shoe">
        <p class="nike">nike</p>
    </div>
    <div class="container itemsContainer">

        <?php
        //on appele la fonction dans l'html
        all_items(); ?>
    </div>
</body>

</html>
<?php


function data_items()
{
    //aller rechercher les items dans le fichier json
    $productsJson = file_get_contents('database.json');
    //les transformer en tableau php
    $products = json_decode($productsJson, true);
    //retourner le tableau php
    return $products;
}

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
    <h3 class="productName">' . $product_name . '</h3>
    <p class="price">' . $price . '</p>
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

    //calculer le nombre d'items dans le panier
    $totalCountCart = totalCountCart();

    //Stocker le nouveau nombre d'items du panier dans la proriété "ToTalItemsCount" du panier
    $_SESSION["shoppingCart"]["TotalItemsCount"] = $totalCountCart;

    //calculer le prix total du panier
    $totalPriceCart = totalPrice();
    //stocker le nouveau pris dau panier dans la propriété "TotalPiceCart" du panier
    $_SESSION["shoppingCart"]["TotalPriceCart"] = $totalPriceCart;
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

//Incrémenter le count d'un article déjà existant dans le panier
function incrementItemCount($ItemId)
{
    $_SESSION["shoppingCart"][$ItemId]['count']++;
    $total_price_items = $_SESSION["shoppingCart"][$ItemId]['count'] * $_SESSION["shoppingCart"][$ItemId]['itemPrice'];
    $_SESSION["shoppingCart"][$ItemId]['totalPriceItem'] = $total_price_items;
}

//calculer le nombre total d'articles dans le panier
function totalCountCart()
{
    //
    $counts = array();
    //récupérer chaque count de chaque article
    foreach ($_SESSION['shoppingCart'] as $key => $value) {

        if (is_int($key)) { //ne garder que les $value qui ont une clé de type integer => alors ma value est un article
            $counts[] = $value['count']; //on stock le count de cet article dans le tableau counts
        }
    }

    $sum = 0;
    foreach ($counts as $count) { // pour chaque count, on l'ajoute à la variable sum
        $sum = $sum + $count;
    }
    return $sum; // on renvoie la sum des counts donc le nombre total d'articles dans le panier

    //    $my_article = array();
    //    //mettre à jour le nombre d'items du panier
    //    foreach ($_SESSION['shoppingCart'] as $key => $value) {
    //
    //        if (is_int($key)) {
    //            $my_article[] = $value;
    //        }
    //    }
    //    $counts = array();
    //    foreach ($my_article as $article) {
    //
    //        $counts[] = $article['count'];
    //    }
    // Calculer la somme de tous les counts
    //    $sum = 0;
    //    foreach ($counts as $count) {
    //        $sum = $sum + $count;
    //    }
    //    return $sum;

}

function test()
{
    session_destroy();
}



// $item1 = get_by_id(1);
// add_item_to_shopping_cart($item1);
// add_item_to_shopping_cart($item1);
// $item2 = get_by_id(2);
// $item3 = get_by_id(3);
// $item4 = get_by_id(4);


function totalPrice()
{
    $prices = array();
    foreach ($_SESSION['shoppingCart'] as $key => $value) {
        if (is_int($key)) { //ne garder que les $value qui ont une clé de type integer => alors ma value est un article
            $prices[] = $value['totalPriceItem'];
        }
    }
    $total = 0;
    foreach ($prices as $total_price_items) {
        $total = $total + $total_price_items;
    }
    return $total;
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
