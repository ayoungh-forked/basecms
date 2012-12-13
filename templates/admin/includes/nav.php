<?php

    use BaseCMS\core\Users as u;
    
    $user = u::current_user();
    $name = $user['real_name'];
    if (!$name) $name = $user['username'];
    
    $section = $url_kwargs['section'];
    if (!$section) $section = 'pages';
    
    $result = $db->get('record_types');
    $section_list = array();
    $section_list[] = 'pages';
    foreach ($result as $row) {
        $section_list[] = $row->name;
    }
    if ($user['admin'] || $user['developer'])
        $section_list[] = 'users';
?>
<header>
    <ul>
        <li>
            <a href="/admin/logout/">Log out</a>
        </li>
        <li>
            <a href="/admin/me/">User settings</a>
        </li>
        <li>
            <a href="/">View site</a>
        </li>
    </ul>
    <span class="welcome">
        Logged in as <?=$name?>
    </span>
</header>
<nav>
    <ul>
        <?php
            foreach($section_list as $s) {
            ?>
                <li class="<?=($section == $s ? 'active' : '')?>">
                    <a href="/admin/<?=$s?>/" rel="<?=$s?>">
                        <?=ucwords($s)?>
                    </a>
                </li>
            <?php
            }
        ?>
        <li class="<?=($section == 'settings' ? 'active' : '')?>">
            <a href="/admin/settings/" rel="">
                Settings
            </a>
        </li>
    </ul>
</nav>