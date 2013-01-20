<?php

    use BaseCMS\core\Helpers as h;

    $view = $request->params['view'];
    $records = $db->get('records', array('type_name' => $view), array('display_date', 'creation_date'));
    
?>
<div id="controls">
    <ul>
        <li class="add">
            <a href="/admin/edit/?view=<?=$view?>&id=new" target="edit_pane" class="icon">
                + <span class="description">Add</span>
            </a>       
        </li>
    </ul>
</div>
<div id="list_header">
    <span class="title">
        Title
    </span>
    <span class="date heading-right">
        Last modified
    </span>
</div>
<div id="item_list">
    <ol>
    <?php
        foreach($records as $record) {
        ?>
        <li>
            <span class="title">
                <a href="/admin/edit/?view=<?=$view?>&id=<?=$record->id?>" target="edit_pane" class="edit_link">
                    <?=$record->title?>
                </a>
            </span>
            <span class="date list-right">
                <?=$record->modification_date?>
            </span>
        </li>
        <?php
        }
    ?>
    </ol>
</div>