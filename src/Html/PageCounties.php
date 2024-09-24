<?php

namespace App\Html;

class PageCounties extends AbstractPage
{
    static function list($entities)
    {
        self::table($entities);
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
                    <form name="county-editor" method="post" action="">
                        <input type="hidden" id="id" name="id">
                        <input type="search" id="name" name="name" placeholder="Megye" required>
                        <button type="submit" id="btn-save-county" name="btn-save-county" title="Ment"><i class="fa fa-save"></i></button>
                        <button type="button" id="btn-cancel-county" title="Mégse"><i class="fa fa-cancel"></i></button>
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
                'btnEditCountyOnClick(%d, "%s")', 
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
                            id='btn-del-county-{$entity['id']}' 
                            name='btn-del-county' 
                            value='{$entity['id']}' 
                            title='Töröl'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                    <form method='post' action=''>
                        <button type='submit' 
                            id='btn-view-cities-{$entity['id']}' 
                            name='btn-view-cities' 
                            value='{$entity['id']}' 
                            title='Városok'>
                            <i class='fa fa-hotdog'></i>
                        </button>
                    </form>
                </td>
            </tr>";
        }
        echo '</tbody>';
    }

    static function table(array $entities)
    {

        echo '<h1>Megyék</h1>';
        self::searchBar();
        echo '<table id="counties-table">';
        self::tableHead();
        self::tableBody($entities);
        echo "</table>";
    }
}