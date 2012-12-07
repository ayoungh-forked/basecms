<div id="controls">
    <ul>
        <li class="add">
            <a href="#" class="icon">
                + <span class="description">Add</span>
            </a>       
        </li>
        <li class="remove">
            <a href="#" class="icon">
               - <span class="description">Remove</span>
            </a>
        </li>
        <li class="lock">
            <a href="#" class="icon">
               x <span class="description">Lock selected</span>
            </a>
        </li>
        <li class="unlock">
            <a href="#" class="icon">
               w <span class="description">Unlock selected</span>
            </a>
        </li>
        <li class="expand_all">
            <a href="#" class="icon">
               &#93; <span class="description">Expand all</span>
            </a>
        </li>
        <li class="collapse_all">
            <a href="#" class="icon">
               &#91; <span class="description">Collapse all</span>
            </a>
        </li>
    </ul>
</div>
<?php
    $pages = $db->get('pages', null, array('sort_order', 'creation_date'));
    
    $pages_by_parent = array();
    $pages_by_id = array();
    foreach ($pages as $k => $page) {
        $id = $page->id;
        $parent_id = $page->parent_id;
        $pages_by_id[$id] = $page;
        if ($parent_id) {
            if (empty($pages_by_parent[$parent_id])) 
                $pages_by_parent[$parent_id] = array();
            $pages_by_parent[$parent_id][] = $id;
        } else {
            if (empty($pages_by_parent[0])) 
                $pages_by_parent[0] = array();
            $pages_by_parent[0][] = $id;
        }
    }
    
    function render_page_list($page_id, $pages_by_id, $pages_by_parent) {
        $page = $pages_by_id[$page_id];
        $classes = array();
        
        if ($page->live) $classes[] = 'live';
        if ($page->redirect) $classes[] = 'redirect';
        if ($page->developer_lock || $page->admin_lock) $classes[] = 'lock';
        
        ?>
        
        <li data-id="<?=$page->id;?>" class="<?=implode(" ", $classes)?>">
            <div class="page_info handle">
                <a class="collapse_control">&#91;</a>
                <a class="expand_control">&#93;</a>
                <a href="/admin/edit/?view=pages&id=<?=$page->id?>" target="edit_pane" class="edit_link">
                    <span class="title">
                        <?=$page->title;?>
                    </span>
                </a>
                <span class="date">
                    <?=date('d M, Y G:m', strtotime($page->modification_date))?>
                </span>
            </div>
            <?php
                if (!empty($pages_by_parent[$page_id])) {
                    ?>
                    <ol>
                    <?php
                        foreach ($pages_by_parent[$page_id] as $child_id) {
                            render_page_list($child_id, $pages_by_id, $pages_by_parent);
                        }
                    ?>
                    </ol>
                    <?php
                }
            ?>
        </li>
        
        <?php
    }
    
    ?>
    <div id="list_header">
        <span class="title">
            Page title
        </span>
        <span class="date">
            Last modified
        </span>
    </div>
    <div id="item_list">
        <ol class="nested_sortable collapsable_list">
        <?php
            foreach($pages_by_parent[0] as $page_id) {
                render_page_list($page_id, $pages_by_id, $pages_by_parent);
            }
        ?>
        </ol>
    </div>
    
    <?php
