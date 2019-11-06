<?php

namespace App\Controllers;

use \Core\View;

class Homepage extends Authenticated
{
    public function indexAction()
    {
        View::renderTemplate('/Homepage/index.html');
    }
}
