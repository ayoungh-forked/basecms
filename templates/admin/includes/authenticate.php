<?php

    use BaseCMS\core\Users as u;
    session_start();
    $username = $request->params['username'];
    $password = $request->params['password'];
    
    if (($username || $password) && !u::logged_in()) {
    
        $user = $db->get_one('users', array(
            'username' => $username,
        ));
        
        if ($user) {
        
            $brute_force = false;
            $user->password_attempts = 1 + intval($user->password_attempts);
            
            if ($user->password_attempts > 10 && time() - $user->last_attempt < 300) {
                $brute_force = true;
            } else if (u::password_check($password, $user->password_hash)) {
                $userdata = $user->_get_row();
                $user->password_attempts = 0;
                u::log_in($userdata);
            }
            $user->last_attempt = time();
            $db->save($user);
         
        }
        
    }
    
    if (!u::logged_in() && $brute_force) {
    
        ?>
        <p class="error">
            You have made more than ten log in attempts in the last five minutes. To prevent brute-force
            guessing of your password, authentication with this username has been temporarily disabled.
        </p>
        <?php
    
    } else if (!u::logged_in()) {
    
        if ($username || $password)
            $error = true;
        else
            $error = false;
    
        ?>
        <div id="login_frame" class="row">
            <form action="" method="POST" id="login" class="<?=($error ? 'error' : ''); ?> span4 offset3">
            
                <h1 id="#logo">BaseCMS</h1>
            
                <?php
                if ($error) {
                    ?>
                    <p class="error">
                        Incorrect username or password. Please try again.
                    </p>
                    <?php
                }
                ?>
                
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" />
                
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" />
                
                <button>Submit &rarr;</button>
            </form>
        </div>
        <?php
    
    }
    
    return;