<?php

namespace App\Models;

use PDO;

class BalanceModel extends \Core\Model

{
   private static $balance = 0;
   private static $array_category = [];
   private static $array_category_amount = [];
   private static $category_counter = 0;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

     public static function getDateFrom(){
        if (isset($_POST['date_from']))
          {
             $date_from = $_POST['date_from'];
             return $date_from;
          }
     }

     public static function getDateTo(){
       if (isset($_POST['date_to']))
          {
             $date_to = $_POST['date_to'];
             return $date_to;
          }
     }

    public static function getDatePeriod(){

      $chosen_date="current_month";

      if (isset($_POST['date_from']) & isset($_POST['date_to']))
         {
            $_SESSION['calendar_menu']="date_period";
         }

      if (isset($_SESSION['calendar_menu'])){
         $chosen_date = $_SESSION['calendar_menu'];
      }

      return $chosen_date;
    }

    private static function checkDates($DBdate){
      $chosen_date = BalanceModel::getDatePeriod();

      if ($chosen_date == "date_period")
   		{
   			$single_date = strtotime(date("Y-m-d", strtotime($DBdate)));
            $date_from  = strtotime(date("Y-m-d", strtotime(BalanceModel::getDateFrom())));
            $date_to = strtotime(date("Y-m-d", strtotime(BalanceModel::getDateTo())));

   			if($date_from <= $single_date && $date_to >= $single_date)
   			{
   			   return true;
   			}
            return false;
   		}
	   else
      	{
      		if ($chosen_date == "current_year")
      			{
      				$date_period=strtotime(date("Y"));
      				$single_date=strtotime(date("Y", strtotime($DBdate)));
      			}
      		else if ($chosen_date == "previous_month")
      			{
      				$date_period=strtotime(date("Y-m")." -1 month");
      				$single_date=strtotime(date("Y-m", strtotime($DBdate)));
      			}
      		else if ($chosen_date == "current_month")
      			{
      				$date_period=strtotime(date("Y-m"));
      				$single_date=strtotime(date("Y-m", strtotime($DBdate)));
      			}

      		if($date_period == $single_date)
            {
      			return true;
            }
            else {
               return false;
            }
         }
      }

      private static function categoryExpensesCalculator($category, $amount)
      {
            $category_exist = false;

            $k = 0;

            while ($k <= BalanceModel::$category_counter && isset (BalanceModel::$array_category[$k]))
            {
               if (BalanceModel::$array_category[$k] == $category)
               {
                  $category_exist = true;
                  BalanceModel::$array_category_amount[$k] = BalanceModel::$array_category_amount[$k] + $amount;

                  if ($category_exist = true)
                  {
                     break;
                  }
               }
               $k++;
            }
            if ($category_exist == false)
            {
               array_push(BalanceModel::$array_category, $category);
               array_push(BalanceModel::$array_category_amount, $amount);
               BalanceModel::$category_counter++;
            }
      }


    private static function prepareIncomeArray($object)
   {
       $array_category = [];

       $row_number = $object->rowCount();

       $i = 1;
       while($i <= $row_number)
       {
           $single_row = $object->fetch(PDO::FETCH_ASSOC);
           $date_of_income=$single_row['date_of_income'];
           if (BalanceModel::checkDates($date_of_income))
           {
              $amount=$single_row['amount'];
              $category_id=$single_row['income_category_assigned_to_user_id'];
              $category = BalanceModel::getIncomeCategoryNameFromId($category_id);
              $comment=$single_row['income_comment'];

              array_push($array_category, [$amount, $category, $date_of_income, $comment]);

              BalanceModel::$balance = BalanceModel::$balance + $amount;
           }
           $i++;
        }
        return $array_category;
   }

   private static function getIncomeCategoryNameFromId($id)
   {
      $sql = 'SELECT name FROM incomes_category_assigned_to_users WHERE id=:id';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);

      $stmt->execute();
      $single_row = $stmt->fetch(PDO::FETCH_ASSOC);
      $name = $single_row['name'];
      return $name;
   }

    public static function getIncome($id)
    {
        $sql = 'SELECT * FROM incomes WHERE user_id = :id ORDER BY date_of_income ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return BalanceModel::prepareIncomeArray($stmt);
    }


    private static function getExpenseCategoryNameFromId($id)
      {
         $sql = 'SELECT name FROM expenses_category_assigned_to_users WHERE id=:id';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);

         $stmt->execute();
         $single_row = $stmt->fetch(PDO::FETCH_ASSOC);
         $name = $single_row['name'];
         return $name;
      }

   private static function getExpensePaymentMethodNameFromId($id)
    {
        $sql = 'SELECT name FROM payment_methods_assigned_to_users WHERE id=:id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $single_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $single_row['name'];
        return $name;
    }


    private static function prepareExpenseArray($object)
   {
       $array_category = [];

       $row_number = $object->rowCount();

       $i = 1;
       while($i <= $row_number)
       {
           $single_row = $object->fetch(PDO::FETCH_ASSOC);
           $date_of_expense = $single_row['date_of_expense'];
           if (BalanceModel::checkDates($date_of_expense))
           {
              $amount=$single_row['amount'];

              $category_id = $single_row['expense_category_assigned_to_user_id'];
              $category = BalanceModel::getExpenseCategoryNameFromId($category_id);

              $payment_method_id = $single_row['payment_method_assigned_to_user_id'];
              $method = BalanceModel::getExpensePaymentMethodNameFromId($payment_method_id);

              $comment=$single_row['expense_comment'];

              array_push($array_category, [$amount, $category, $method, $date_of_expense, $comment]);

              BalanceModel::$balance = BalanceModel::$balance - $amount;
              BalanceModel::categoryExpensesCalculator($category, $amount);
           }
           $i++;
        }
        return $array_category;
   }


   public static function getExpense($id)
     {
         $sql = 'SELECT * FROM expenses WHERE user_id = :id ORDER BY date_of_expense ASC';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);

         $stmt->execute();

         return BalanceModel::prepareExpenseArray($stmt);
      }

   public static function getBalance()
    {
      return BalanceModel::$balance;
    }

    public static function getCategoryCounter()
     {
       return BalanceModel::$category_counter;
     }

    public static function getDataToChart()
    {
        $data_points = array();
		  $k = 0;

	     while ($k < BalanceModel::$category_counter)
   		{
   			$point = array("label" => BalanceModel::$array_category[$k] , "y" => BalanceModel::$array_category_amount[$k]);
   			array_push($data_points, $point);
   			$k++;
   		}
        $data_points = json_encode($data_points, JSON_NUMERIC_CHECK);

        return $data_points;
    }
}
