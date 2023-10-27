<?php

//récupère la base de données json
function data_items()
{
    //aller rechercher les items dans le fichier json
    $productsJson = file_get_contents('database.json');
    //les transformer en tableau php
    $products = json_decode($productsJson, true);
    //retourner le tableau php
    return $products;
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

}


//met à jour le compte total du shopping cart
function update_totalCount_cart()
{
    //calculer le nombre d'items dans le panier
    $totalCountCart = totalCountCart();

    //Stocker le nouveau nombre d'items du panier dans la proriété "ToTalItemsCount" du panier
    $_SESSION["shoppingCart"]["TotalItemsCount"] = $totalCountCart;
}





//met à jour le prix total du shopping cart
function update_totalPrrice_cart()
{
    //calculer le prix total du panier
    $totalPriceCart = totalPrice();
    //stocker le nouveau pris dau panier dans la propriété "TotalPiceCart" du panier
    $_SESSION["shoppingCart"]["TotalPriceCart"] = $totalPriceCart;
}



//calcule le prix total du cart
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
