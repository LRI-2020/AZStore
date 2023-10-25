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


function all_items()
{
    // $result = [];
    //mettre fonction dans une variable
    $items = data_items();
    foreach ($items as $item) {
        $current_item = item_html_template($item["image_url"], $item["product"], $item["price"]);
        // array_push($result, $current_item);
        echo $current_item;
    }
    // return $result;
}




function item_html_template($image_url, $product_name, $price)
{
    $item_html =
        '<div class="item">
    <img src="' . $image_url . '"alt="img" class="imgShoe">
    <h3 class="productName">' . $product_name . '</h3>
    <p class="price">' . $price . '</p>
    <form>
        <button id="1" class="button" type="submit">add to cart</button>
    </form>
    </div>';
    return $item_html;
}
