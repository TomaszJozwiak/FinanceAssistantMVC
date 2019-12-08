<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\SettingsModel;
use \App\Auth;
use \App\Flash;

class Settings extends Authenticated
{
    public function indexAction()
    {
        View::renderTemplate('/Settings/index.html');
    }

    public function editIncomeCategory()
    {
         if (isset($_SESSION['user_id'])) {
             $settingsModel = new SettingsModel($_POST);
             if ($settingsModel->editIncomeCategory($_SESSION['user_id'])){
                Flash::addMessage('Nazwa kategorii zmieniona pomyślnie');
             }
             else {
                Flash::addError('Istnieje już taka kategoria');
             }
             View::renderTemplate('/Settings/index.html');
         }
    }

    public function deleteIncomeCategory()
     {
           if (isset($_SESSION['user_id'])) {
              $settingsModel = new SettingsModel($_POST);
              $settingsModel->deleteIncomeCategory($_SESSION['user_id']);
              $settingsModel->deleteExistingIncomes($_SESSION['user_id']);
              Flash::addMessage('Kategoria została usunięta');
              View::renderTemplate('/Settings/index.html');
           }
     }

     public function addIncomeCategory()
    {
         if (isset($_SESSION['user_id'])) {
              $settingsModel = new SettingsModel($_POST);
              if ($settingsModel->addIncomeCategory($_SESSION['user_id'])){
                 Flash::addMessage('Kategoria została dodana');
              }
              else {
                 Flash::addError('Istnieje już taka kategoria');
              }
              View::renderTemplate('/Settings/index.html');
         }
    }

    public function editExpenseCategory()
   {
         if (isset($_SESSION['user_id'])) {
             $settingsModel = new SettingsModel($_POST);
             if ($settingsModel->editExpenseCategory($_SESSION['user_id'])){
                Flash::addMessage('Nazwa kategorii zmieniona pomyślnie');
             }
             else {
                Flash::addError('Istnieje już taka kategoria');
             }
             View::renderTemplate('/Settings/index.html');
         }
   }

   public function deleteExpenseCategory()
   {
        if (isset($_SESSION['user_id'])) {
           $settingsModel = new SettingsModel($_POST);
           $settingsModel->deleteExpenseCategory($_SESSION['user_id']);
           $settingsModel->deleteExistingExpenses($_SESSION['user_id']);
           Flash::addMessage('Kategoria została usunięta');
           View::renderTemplate('/Settings/index.html');
        }
   }

   public function addExpenseCategory()
   {
      if (isset($_SESSION['user_id'])) {
           $settingsModel = new SettingsModel($_POST);
           if ($settingsModel->addExpenseCategory($_SESSION['user_id'])){
             Flash::addMessage('Kategoria została dodana');
           }
           else {
             Flash::addError('Istnieje już taka kategoria');
           }
           View::renderTemplate('/Settings/index.html');
      }
   }

   public function editPaymentMethods()
  {
        if (isset($_SESSION['user_id'])) {
            $settingsModel = new SettingsModel($_POST);
            if ($settingsModel->editPaymentMethod($_SESSION['user_id'])){
             Flash::addMessage('Nazwa metody zmieniona pomyślnie');
           }
           else {
             Flash::addError('Istnieje już taka metoda');
           }
            View::renderTemplate('/Settings/index.html');
        }
  }

  public function deletePaymentMethod()
  {
      if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          $settingsModel->deletePaymentMethod($_SESSION['user_id']);
          $settingsModel->deleteExistingPaymentMethod($_SESSION['user_id']);
          Flash::addMessage('Metoda płatności została usunięta');
          View::renderTemplate('/Settings/index.html');
      }
  }

  public function addPaymentMethod()
  {
     if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          if ($settingsModel->addPaymentMethod($_SESSION['user_id'])){
           Flash::addMessage('Metoda płatności została dodana');
         }
         else {
           Flash::addError('Istnieje już taka metoda');
         }
          View::renderTemplate('/Settings/index.html');
     }
  }

  public function changeUsername()
  {
     if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          $settingsModel->changeUsername($_SESSION['user_id']);
          Flash::addMessage('Nazwa użytkownika została zmieniona');
          View::renderTemplate('/Settings/index.html');
     }
  }

  public function editPasswordAction()
  {
     if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);

          if ($settingsModel->editPassword($_SESSION['user_id'])){
          Flash::addMessage('Hasło zostało zmienione');
         }
         View::renderTemplate('/Settings/index.html');
     }
  }

  public function deleteUserAction()
  {
     if (isset($_SESSION['user_id'])) {
          $settingsModel = new SettingsModel($_POST);
          $settingsModel->deleteUser($_SESSION['user_id']);
          Auth::logout();
          Flash::addMessage('Konto zostało usunięte');
          View::renderTemplate('Home/index.html');
     }
  }
}
