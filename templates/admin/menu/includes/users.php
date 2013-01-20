<?php

    use BaseCMS\core\Helpers as h;
    
    $records = $db->get('users');
    
?>
<div id="controls" class="btn-group">
    <a href="/admin/edit/?view=users&id=new" target="edit_pane" class="btn add">
        + <span class="description">Add</span>
    </a>
</div>
<div id="list_header">
    <span class="title">
        Name
    </span>
    <span class="description heading-right">
        Username
    </span>
</div>
<div id="item_list">
    <ol>
    <?php
        foreach($records as $record) {
        ?>
        <li>
            <span class="description">
                <?=$record->real_name?>
            </span>
            <span class="title list-right">
                <a href="/admin/edit/?view=users&id=<?=$record->id?>" target="edit_pane" class="edit_link">
                    <?=$record->username?>
                </a>
            </span>
        </li>
        <?php
        }
    ?>
    </ol>
</div>