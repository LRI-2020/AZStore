<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/scss/layouts/__layouts-dir.scss">
    <title>Document</title>
</head>
    <body>
        <?php
            session_start();

            $shoppingCart =   $_SESSION['shoppingCart'] = array(
                "id" => array(
                    "product"=> "Nike Air Max 270",
                    "price"=> 140,
                    "image_url"=> "./assets/img/shoe_two.jpg"
                ),
                "id2" => array(
                    "product"=> "Nike Air Max 270",
                    "price"=> 140,
                    "image_url"=> "./assets/img/shoe_two.jpg"
                ),
                "id3" => array(
                    "product"=> "Nike Air Max 270",
                    "price"=> 140,
                    "image_url"=> "./assets/img/shoe_two.jpg"
                ),
                  
            );

            echo '<pre>';
            print_r($shoppingCart);
            echo '<pre>';

            /* echo $shoppingCart['TotalPriceCart'], '<br />';
            echo $shoppingCart['TotalItemsCount'], '<br />'; */

            for ($i = 0; $i < (count($shoppingCart) - 2); $i++) {
                echo <<<EOD
                    <div class="product">
                EOD;
                $deleteBtn = isset($_GET['delete']);
                foreach ($shoppingCart as $key=>$items) {

                    echo $key;
                    
                    $itemPrice = $shoppingCart[$i]['itemPrice'];

                    if ($infos == $itemPrice) {

                        echo <<<EOD

                            <div class="money">$itemPrice €</div><br />

                        EOD;
                    } else {

                        echo <<<EOD

                            <div>$infos</div><br />

                        EOD;
                    }   
                    $deleteBtn = $_GET['delete'];  
                               
                }
                echo <<<EOD
                    <form method="GET">
                        <input type='button' value='Delete product' name='delete' class=$i>
                    </form>
                    </div>
                EOD;
                echo $deleteBtn;
                if ($deleteBtn) {
                    echo $deleteBtn;
                    if ($itemPrice == $itemPrice) {
                        
                    }
                }  
                
            }
            
            
        ?>

        <form action="checkout.php" method="POST">
            <input type="submit" value="Checkout" name="checkout">
        </form>
        
    </body>
</html>