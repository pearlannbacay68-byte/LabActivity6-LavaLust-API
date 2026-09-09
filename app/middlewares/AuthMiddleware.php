<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        lava_instance()->call->library('session');
        $session = lava_instance()->session;

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
            return;
        }

        return $next();
    }
}
