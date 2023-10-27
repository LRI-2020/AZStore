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
        session_start();

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        echo <<<EOD
            <div class="allProducts">
        EOD;
        event();
        echo <<<EOD
            </div>
        EOD;

        

        function event() {
            $shoppingItems = array(); 
            $shoppingCart = $_SESSION['shoppingCart'];
            function delete($key, $value) { 
                $exist = array_key_exists($key, $_SESSION['shoppingCart']); 
                if ($exist !== false) {
                    unset($_SESSION['shoppingCart'][$key]);
                    if ($key == 'TotalItemsCount') {
                        unset($_SESSION['shoppingCart'][$key]);
                    }
                }
            } 
            echo <<<EOD
                <div class="form">
            EOD;
            foreach($shoppingCart as $key => $value){
                if(is_int($key)){
                  $shoppingItems[] = $value;
                  echo <<<EOD
                  <form method="POST">
                      <button value=$key type="submit" name=$key>Delete product</button>
                  </form>
                  EOD;
                  if (isset($_POST[$key])) {
                    header('Location: shopping-cart.php');
                    delete($key, $value);
                }
            } else {
                    echo <<<EOD
                    <div class=$key>
                    EOD;
                    echo $key;
                    echo $value, '<br />';
                    echo <<<EOD
                    </div>
                    EOD;

                }
            };
            echo <<<EOD
                </div>
            EOD;
            
            echo <<<EOD
                <div class="products">
            EOD;
            foreach($shoppingItems as $arrayKey => $items) {
                echo <<<EOD
                    <div class="product">
                EOD;

                foreach ($items as $keys => $item) {

                    if ($keys == "image_url") {
                        echo <<<EOD
                            <div class='image_url'>
                            <img src=$item>
                            </div>
                        EOD;
                    } else {
                        if ($keys == 'itemPrice') {
                            echo <<<EOD
                                <div>
                            EOD;
                            echo $item, ' $', '<br />';
                            echo <<<EOD
                                </div>
                            EOD;
                        } else if ($keys == 'totalPriceItem') {

                        } else {
                            echo $item, '<br />';
                        }
                        
                    }
                }
                echo <<<EOD
                    </div>
                EOD;

            }      
            echo <<<EOD
                </div>
            EOD;
        }
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