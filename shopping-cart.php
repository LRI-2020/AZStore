<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/scss/layouts/__layouts-dir.scss">
    <link rel="stylesheet" type="text/css" href="./assets/scss/components/__buttons.scss">
    <title>Document</title>
</head>
    <body>
        <?php

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

 

           /*  echo '<pre>';
            print_r($shoppingCart);
            echo '<pre>'; */

            /* echo $shoppingCart['TotalPriceCart'];
            echo $shoppingCart['TotalItemsCount']; */
            echo <<<EOD
                <div class="allProducts">
            EOD;

        function event() {
            session_start();
            $shoppingCart = $_SESSION['shoppingCart'];            

            foreach ($shoppingCart as $key=>$items) {
                echo <<<EOD
                <div class="productDiv">
                EOD;

                foreach ($items as $keyItem=>$item) {
                    if ($keyItem == "image_url") {
                        echo <<<EOD
                            <div class=$keyItem>
                            <img src=$item>
                            </div>
                        EOD;

                    } else if ($keyItem == 'price'){
                        echo <<<EOD
                            <div class=$keyItem>
                            EOD;
                        echo $item, ' €';
                        echo <<<EOD
                            </div>
                        EOD;

                    } else {
                        echo <<<EOD
                            <div class=$keyItem>
                        EOD;
                        echo $item;
                        echo <<<EOD
                            </div>
                        EOD;
                    }
                }
                if (isset($_POST[$key]) == 1){
                    delete($key);
                    header('Location: shopping-cart.php');
                }
            echo <<<EOD
                <form method="POST">
                    <button value=$key type="submit" name=$key>Delete product</button>
                </form>
                </div>
            EOD;
            
            
        }
 
        
       
        }
        function delete($key) { 
            $keys = array_key_exists($key, $_SESSION['shoppingCart']); 
            if ($keys !== false) {
                unset($_SESSION['shoppingCart'][$key]);
            }
        }
  
        event();
        echo <<<EOD
        </div>
        EOD;
        ?>

        <div class = 'buttonsDiv'>
        <form action="index.php" method="POST">
            <input type="submit" value="Index" name="index">
        </form>
        <form action="checkout.php" method="POST">
            <input type="submit" value="Checkout" name="checkout">
        </form>
        </div>
        
    </body>
</html>