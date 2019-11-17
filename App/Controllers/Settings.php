<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\SettingsModel;
use \App\Flash;

class Settings extends Authenticated
{
    public function indexAction()
    {
        View::renderTemplate('/Settings/index.html');
    }

    public function editIncomeCategoryAction()
    {
         if (isset($_SESSION['user_id'])) {
             $settingsModel = new SettingsModel($_POST);
             $settingsModel->editIncomeCategory($_SESSION['user_id']);
             Flash::addMessage('Nazwa kategorii zmieniona pomyślnie');
             View::renderTemplate('/Settings/index.html');
         }
    }

    public function deleteIncomeCategoryAction()
     {
           if (isset($_SESSION['user_id'])) {
              $settingsModel = new SettingsModel($_POST);
              $settingsModel->deleteIncomeCategory($_SESSION['user_id']);
              $settingsModel->deleteExistingIncomes($_SESSION['user_id']);
              Flash::addMessage('Kategoria została usunięta');
              View::renderTemplate('/Settings/index.html');
           }
     }

     public function addIncomeCategoryAction()
    {
         if (isset($_SESSION['user_id'])) {
              $settingsModel = new SettingsModel($_POST);
              $settingsModel->addIncomeCategory($_SESSION['user_id']);
              Flash::addMessage('Kategoria została dodana');
              View::renderTemplate('/Settings/index.html');
         }
    }

    public function editExpenseCategoryAction()
   {
         if (isset($_SESSION['user_id'])) {
             $settingsModel = new SettingsModel($_POST);
             $settingsModel->editExpenseCategory($_SESSION['user_id']);
             Flash::addMessage('Nazwa kategorii zmieniona pomyślnie');
             View::renderTemplate('/Settings/index.html');
         }
   }

   public function deleteExpenseCategoryAction()
   {
        if (isset($_SESSION['user_id'])) {
           $settingsModel = new SettingsModel($_POST);
           $settingsModel->deleteExpenseCategory($_SESSION['user_id']);
           $settingsModel->deleteExistingExpenses($_SESSION['user_id']);
           Flash::addMessage('Kategoria została usunięta');
           View::renderTemplate('/Settings/index.html');
        }
   }

   public function addExpenseCategoryAction()
   {
      if (isset($_SESSION['user_id'])) {
           $settingsModel = new SettingsModel($_POST);
           $settingsModel->addExpenseCategory($_SESSION['user_id']);
           Flash::addMessage('Kategoria została dodana');
           View::renderTemplate('/Settings/index.html');
      }
   }

   public function editPaymentMethodsAction()
  {
        if (isset($_SESSION['user_id'])) {
            $settingsModel = new SettingsModel($_POST);
            $settingsModel->editPaymentMethod($_SESSION['user_id']);
            Flash::addMessage('Nazwa metody zmieniona pomyślnie');
            View::renderTemplate('/Settings/index.html');
        }
  }

  public function deletePaymentMethodAction()
  {
      if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          $settingsModel->deletePaymentMethod($_SESSION['user_id']);
          $settingsModel->deleteExistingPaymentMethod($_SESSION['user_id']);
          Flash::addMessage('Metoda płatności została usunięta');
          View::renderTemplate('/Settings/index.html');
      }
  }

  public function addPaymentMethodAction()
  {
     if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          $settingsModel->addPaymentMethod($_SESSION['user_id']);
          Flash::addMessage('Metoda płatności została dodana');
          View::renderTemplate('/Settings/index.html');
     }
  }

}
