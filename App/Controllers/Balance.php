<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceModel;
use \App\Flash;

class Balance extends Authenticated
{
   public static function getIncomes()
  {
       if (isset($_SESSION['user_id'])) {
           return BalanceModel::getIncome($_SESSION['user_id']);
       }
  }

  public static function getExpenses()
   {
         if (isset($_SESSION['user_id'])) {
             return BalanceModel::getExpense($_SESSION['user_id']);
         }
   }

   public static function getDateFrom()
   {
      if (isset($_SESSION['user_id'])) {
         return BalanceModel::getDateFrom();
      }
   }

   public static function getDateTo()
   {
      if (isset($_SESSION['user_id'])) {
         return BalanceModel::getDateTo();
      }
   }

    public static function getDatePeriod()
    {
       if (isset($_SESSION['user_id'])) {
         return BalanceModel::getDatePeriod();
       }
    }

    public function currentMonthAction()
    {
      $_SESSION['calendar_menu'] = 'current_month';
      View::renderTemplate('/Balance/index.html');
    }

    public function previousMonthAction()
    {
      $_SESSION['calendar_menu'] = 'previous_month';
      View::renderTemplate('/Balance/index.html');
    }

    public function currentYearAction()
    {
      $_SESSION['calendar_menu'] = 'current_year';
      View::renderTemplate('/Balance/index.html');
    }

    public static function getBalance()
    {
         return BalanceModel::getBalance();
    }

    public static function getCategoryCounter()
    {
         return BalanceModel::getCategoryCounter();
    }

    public static function getDataToChart()
    {
         return BalanceModel::getDataToChart();
    }

    public function indexAction()
    {
         View::renderTemplate('/Balance/index.html');
    }
}
