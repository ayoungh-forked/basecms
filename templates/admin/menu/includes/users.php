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
        User name
    </span>
    <span class="description heading-right">
        Real name
    </span>
</div>
<div id="item_list">
    <ol>
    <?php
        foreach($records as $record) {
            $roles = array();
            if ($record->admin) $roles[] = 'Administrator';
            if ($record->developer) $roles[] = 'Developer';
            $roles = implode(', ', $roles);
        ?>
        <li>
            <span class="title">
                <a href="/admin/edit/?view=users&id=<?=$record->id?>" target="edit_pane" class="edit_link">
                    <?=$record->username?>
                </a>
            </span>
            <span class="description list-right">
                <?=$record->real_name?>
                <?=($roles ? "($roles)" : '')?>
            </span>
        </li>
        <?php
        }
    ?>
    </ol>
</div>