<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpenseModel;
use \App\Flash;

class Expense extends Authenticated
{
   public static function getUserExpenseCategories()
  {
       if (isset($_SESSION['user_id'])) {
           return ExpenseModel::getExpenseCategories($_SESSION['user_id']);
       }
  }

  public static function getUserPaymentMethods()
{
      if (isset($_SESSION['user_id'])) {
          return ExpenseModel::getPaymentMethods($_SESSION['user_id']);
      }
}

    public function newAction()
    {

         View::renderTemplate('/Expense/new.html');
    }

    public function createAction()
    {
         $expense = new ExpenseModel($_POST);

         if ($expense->saveExpense()) {

            Flash::addMessage('Dodano wydatek');
            $this->redirect('/expense/new');

         } else {

             View::renderTemplate('/Expense/new.html');
         }
    }
}
