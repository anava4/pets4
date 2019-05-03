<?php

session_start();

//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');


//Create an instance of the Base class
$f3 = Base::instance();

$f3->set('colors', array('pink','green','blue'));

//Turn on Fat-Free error reporting
$f3->set('DEBUG',3);

require_once('model/validation-functions.php');

//Define a default route
$f3->route('GET /', function()
{
    //Display a view
//    $view = new Template();
//    echo $view->render('views/home2.html');
    echo "<h1> My Pets </h1>";
    echo "<a href='order'>Order a Pet</a>";
});

$f3->route('GET /@animal', function($f3,$params)
{

    $item = $params['animal'];
    $animals = array('Dog','Chicken','Cat','Cow','Pig');

    if(!in_array($item, $animals)){
        echo "We don't have $item";
    }

    switch($item){
        case 'Dog':
            echo "Woof!";
            break;
        case 'Chicken':
            echo"Cluck!";
            break;
        case 'Cat':
            echo"Meow!";
            break;
        case 'Cow':
            echo"Moo!!";
            break;
        case 'Pig':
            echo "Oink!";
            break;
        default:
            $f3->error(404);
    }


});

//Define a order route
$f3->route('GET|POST /order', function($f3){
        $_SESSION = array();

        /*if(isset($_POST['animal'])){
            $animal = $_POST['animal'];
            if(validString($animal)){
                $_SESSION['animal'] = $animal;
                $f3->reroute('/order2');
            }else{
                $f3->set("errors['animal']", "Please enter an animal.");
            }
        }

        if(isset($_POST['qty'])){
            $qty = $_POST['qty'];
            if(validQty($qty)){
                $_SESSION['qty'] = $qty;
                $f3->reroute('/order2');
            }else{
                $f3->set("errors['qty']", "Please enter a number greater than 0.");
            }
        }*/

        if(!empty($_POST)) {
            $animal = $_POST['animal'];
            $qty = $_POST['qty'];

            $f3->set('animal', $animal);
            $f3->set('qty', $qty);


            if (isset($_POST['animal']) && isset($_POST['qty'])) {
                $animal = $_POST['animal'];
                $qty = $_POST['qty'];
                if (validString($animal) && validQty($qty)) {
                    $_SESSION['animal'] = $qty;
                    $_SESSION['qty'] = $qty;
                    $f3->reroute('/order2');
                } else {
                    $f3->set("errors['animal']", "Please enter an animal.");
                    $f3->set("errors['qty']", "Please enter a number greater than 0.");
                }

            }
        }

    //Display an order view
    $view = new Template();
    echo $view->render('views/form1.html');
}
);

//Define a order2 route
$f3->route('GET|POST /order2',
    function($f3){


        if(isset($_POST['color'])){
            $color = $_POST['color'];
            if(validString($color)){
                $_SESSION['color'] = $color;
                $f3->reroute('/results');
            }else{
                $f3->set("errors['colors']", "Please enter a color.");
            }
        }
    //Display order received view
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a results route
$f3->route('GET|POST /results', function()
{

    //Display order received view
    $view = new Template();
    echo $view->render('views/results.html');
});



//Run fat free
$f3->run();
