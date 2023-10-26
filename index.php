<?php
// Start the session
session_start();

add_to_cart();
print_r($_SESSION['shoppingCart']);
// test();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./assets/scss/style.css">
    <title>AZStore</title>
</head>

<body>
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
        <button value="' . $id . '" type="submit" name="id">add to cart</button>
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
            $_SESSION["shoppingCart"][$item['id']]['count']++;
            $total_price_items = $_SESSION["shoppingCart"][$item['id']]['count'] * $_SESSION["shoppingCart"][$item['id']]['itemPrice'];
            $_SESSION["shoppingCart"][$item['id']]['totalPriceItem'] = $total_price_items;
        } else {
            $_SESSION["shoppingCart"][$item['id']] = array(
                "productName" => $item['product'],
                "itemPrice" => $item['price'],
                "count" => 1,
                "totalPriceItem" => $item['price'],
            );
            //mettre à jour le nombre d'items du panier
        }
    } else {
        $_SESSION["shoppingCart"] = array(
            $item['id'] => array(
                "productName" => $item['product'],
                "itemPrice" => $item['price'],
                "count" => 1,
                "totalPriceItem" => $item['price']
            ),
            //mettre à jour le nombre d'items du panier
            "TotalPriceCart" => 0,
            "TotalItemsCount" => 0,
        );
    }
    $my_article = array();
    //mettre à jour le nombre d'items du panier
    foreach ($_SESSION['shoppingCart'] as $key => $value) {

        if (is_int($key)) {
            $my_article[] = $value;
        }
    }
    $counts = array();
    foreach ($my_article as $article) {

        $counts[] = $article['count'];
    }
    echo '<pre>';
    print_r($counts);
    echo '</pre>';
    $sum = 0;
    foreach ($counts as $count) {
        $sum = $sum + $count;
    }
    echo ($sum);
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
