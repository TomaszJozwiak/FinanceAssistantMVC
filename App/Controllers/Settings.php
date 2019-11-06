<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Settings extends Authenticated
{
    public function indexAction()
    {
        View::renderTemplate('/Settings/index.html');
    }
}
