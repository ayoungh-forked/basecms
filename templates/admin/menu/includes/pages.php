<?php

    use BaseCMS\core\Helpers as h;

?>
<div id="controls" class="btn-group">
    <button class="btn expand_all">&#93; <span class="description">Expand all</span></button>
    <button class="btn collapse_all">&#91; <span class="description">Collapse all</span></button>
    <a class="btn add" href="/admin/edit/?view=pages&id=new" target="edit_pane">+ <span class="description">Add</span></a>
</div>
<?php

    if ($request->params['order']) {
        $pages = $db->get('pages', null, array('sort_order', 'creation_date'));
        $pages_by_id = array();
        foreach($pages as $page) {
            $pages_by_id[$page->id] = $page;
        }
        
        $order = $request->params['order'];
        if (!is_array($order)) {
            h::abort(400, 'Unknown parameters');
        }
        
        $sort_order = 0;
        foreach ($order as $child_id => $parent_id) {
            $page = $pages_by_id[$child_id];
            $page->parent_id = $parent_id;
            $page->sort_order = $sort_order;
            $db->save($page);
            $sort_order++;
        }
    } else {
        $pages = $db->get('pages', null, array('sort_order', 'creation_date'));
    }
    
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
        
        <li id="order_<?=$page->id;?>" class="<?=implode(" ", $classes)?>">
            <div class="page_info handle">
                <a class="collapse_control">&#91;</a>
                <a class="expand_control">&#93;</a>
                <span class="date list-right">
                    <?=date('d M, Y G:m', strtotime($page->modification_date))?>
                </span>
                <a href="/admin/edit/?view=pages&id=<?=$page->id?>" target="edit_pane" class="edit_link">
                    <span class="title">
                        <?=$page->title;?>
                    </span>
                </a>
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
        <span class="date heading-right">
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
