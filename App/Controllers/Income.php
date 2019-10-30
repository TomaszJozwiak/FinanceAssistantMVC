<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\IncomeModel;
use \App\Flash;

class Income extends Authenticated
{
   public static function getUserIncomeCategories()
  {
       if (isset($_SESSION['user_id'])) {
           return IncomeModel::getIncomeCategories($_SESSION['user_id']);
       }
  }

    public function newAction()
    {

         View::renderTemplate('/Income/new.html');
    }

    public function createAction()
    {
         $income = new IncomeModel($_POST);

         if ($income->saveIncome()) {

            Flash::addMessage('Dodano przychód');
            $this->redirect('/income/new');

         } else {

             View::renderTemplate('/Income/new.html');
         }
    }
}
