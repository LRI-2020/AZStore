<?php
// Start the session
session_start();
$_SESSION["shoppingCart"] = array(
    "TotalPriceCart" => 0,
    "TotalItemsCount" => 0,
);
add_to_cart();
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
        echo all_items(); ?>
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
    //récupérer id dans le json
    $id = $_GET['id'];
    //si id présent 
    if (isset($id)) {
        //alors lance fonction get_by_id
        $item = get_by_id($id);
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
    // $shopping_cart = $_SESSION["shoppingCart"];
    // $total_price_items = $item['product'] *;
    $_SESSION["shoppingCart"][$item['id']] = array(
        "productName" => $item['product'],
        "itemPrice" => $item['price'],
        "count" => 1,
        "totalPriceItem" => $item['price']
    );
    print_r($_SESSION['shoppingCart']);
}


// $item1 = get_by_id(1);
// $item2 = get_by_id(2);
// $item3 = get_by_id(3);
// $item4 = get_by_id(4);
