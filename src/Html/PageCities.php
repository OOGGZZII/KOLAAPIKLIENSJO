<?php

namespace App\Html;

class PageCities extends AbstractPage
{
    static function table(array $entities)
    {

        echo '<h1>Városok</h1>';
        self::searchBar();
        echo '<table id="cities-table">';
        self::tableHead();
        self::tableBody($entities);
        echo "</table>";
    }
        static function tableHead()
    {
        echo '
        <thead>
            <tr>
                <th class="id-col">#</th>
                <th>Megnevezés</th>
                <th style="float: right; display: flex">
                    Művelet&nbsp;
                    <button id="btn-add" title="Új">
                        <i class="fa fa-plus"></i>
                    </button>';
                    self::pdfBtn();
                    self::emailBtn();
        echo'
                </th>
            </tr>
            <tr id="editor" class="hidden"">';
            self::editor();
            echo '   
            </tr>
        </thead>
        ';
    }

    static function editor()
    {
        echo '
                <th>&nbsp;</th>
                <th>
                    <form name="city-editor" method="post" action="">
                        <input type="hidden" id="id" name="id">
                        <input type="search" id="name" name="name" placeholder="Város" required>
                        <button type="submit" id="btn-save-city" name="btn-save-city" title="Ment"><i class="fa fa-save"></i></button>
                        <button type="button" id="btn-cancel-city" title="Mégse"><i class="fa fa-cancel"></i></button>
                     </form>
                </th>

                <th class="flex">
                &nbsp;
                </th>'
           ;
    }


    static function tableBody(array $entities)
    {
        echo '<tbody>';
        $i = 0;
        foreach ($entities as $entity) {
            $onClick = sprintf(
                'btnEditCityOnClick(%d, "%s")', 
                $entity['id'], 
                $entity['name']
            );
            echo "
            <tr class='" . (++$i % 2 ? "odd" : "even") . "'>
                <td>{$entity['id']}</td>
                <td>{$entity['name']}</td>
                <td class='flex float-right'>
                    <button type='button' 
                        id='btn-edit-{$entity['id']}' 
                        onclick='$onClick' 
                        title='Módosít'>
                        <i class='fa fa-edit'></i>
                    </button>
                    <form method='post' action=''>
                        <button type='submit' 
                            id='btn-del-city-{$entity['id']}' 
                            name='btn-del-city' 
                            value='{$entity['id']}' 
                            title='Töröl'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                </td>
            </tr>";
        }
        echo '</tbody>';
    }

}