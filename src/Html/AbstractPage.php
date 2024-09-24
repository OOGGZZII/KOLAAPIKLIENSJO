<?php

namespace App\Html;

use App\Interfaces\PageInterface;

abstract class AbstractPage implements PageInterface
{

    static function head()
    {
        echo '
        <!doctype html>
        <html lang="hu-hu">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, 
               initial-scale=1">

            <title>Posta</title>
        
            <!-- Scripts -->
            <script src="js/jquery-3.7.1.js" type="text/javascript"></script>
            <script src="js/app.js" type="text/javascript"></script>
            <script src="js/bootstrap.js" type="text/javascript"></script>
            <!-- Fonts -->
        
            <!-- Styles -->
            <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css">
            <link href="css/app.css" rel="stylesheet" type="text/css">
            <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
            <!-- Icons -->
            <link rel="icon" type="image/x-icon" href="favicon.ico">
        </head>';
    }

    static function installBtn()
    {
        echo '
        <form method="post">
            <button type="submit" name="btn-install" title="Adatbázis telepítése">Telepítés</button>
        </form>
        <p>A program első indítása esetén az adatbázis telepítése.</p>
        ';
    }

    static function pdfBtn()
    {
        echo '
        <form method="post">
            <button type="submit" name="btn-pdf" title="PDF"><i class="fa fa-file-pdf"></i></button>
        </form>
        ';
    }

    static function emailBtn()
    {
        echo '
        <form method="post">
            <button type="submit" name="btn-email" title="Email"><i class="fa fa-envelope"></i></button>
        </form>
        ';
    }
    static function nav()
    {
        echo '
        <nav>
            <form name="nav" method="post" action="index.php">
                <button type="submit" name="btn-home"><i class="fa fa-home" title="Kezdőlap"></i></button>
                <button type="submit" name="btn-counties">Megyék</button>
                <button type="submit" name="btn-cities">Városok</button>
            </form>   
        </nav>';

    }

    static function footer()
    {
        echo '
        <footer>

        </footer>
        </html>';
    }

//    static function exportBtn($action)
//    {
//        // TODO: Implement exportBtn() method.
//    }
//
//    static function importBtn()
//    {
//        // TODO: Implement importBtn() method.
//    }
//
//    static function truncateBtn()
//    {
//        // TODO: Implement truncateBtn() method.
//    }
    abstract static function tableHead();

    abstract static function tableBody(array $entities);

    abstract static function table(array $entities);

    abstract static function editor();

    static function searchBar()
    {
        echo '
        <form method="post" action="">
            <input type="search" name="needle" placeholder="Keres">
                <button type="submit" id="btn-search" name="btn-search" title="Keres">
                    <i class="fa fa-search"></i>
                </button>
        </form>
        <br>';
    }
}