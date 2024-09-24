<?php

namespace App\Interfaces;

interface PageInterface
{
    static function head();

    static function nav();

    static function footer();

//    static function exportBtn($action);

//    static function importBtn();
//
//    static function truncateBtn();

    static function tableHead();

    static function tableBody(array $entities);

    static function table(array $entities);

//    static function showAbcButtons(array $abc);

    static function searchBar();

//    static function csvImportBtn();

//    static function showExportImportButtons($isEmptyDb, $action, $makers = [], $selectedId = 0);
}