<?php

namespace App\Models;

use PDO;

class ExpenseModel extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    private static function prepareCategoryArray($object)
   {
      $array_category = [];

      $row_number = $object->rowCount();

      $i = 1;
      while($i <= $row_number)
      {
           $single_row = $object->fetch(PDO::FETCH_ASSOC);

           $id = $single_row['id'];
           $name = $single_row['name'];
           $monthly_limit = $single_row['monthly_limit'];

           array_push($array_category, [$id, $name, $monthly_limit]);

           $i++;
        }
        return $array_category;
   }

   private static function prepareMethodArray($object)
  {
     $array_method = [];

     $row_number = $object->rowCount();

     $i = 1;
     while($i <= $row_number)
     {
          $single_row = $object->fetch(PDO::FETCH_ASSOC);

          $id = $single_row['id'];
          $name = $single_row['name'];

          array_push($array_method, [$id, $name]);

          $i++;
      }
      return $array_method;
  }

    public static function getExpenseCategories($id)
    {
        $sql = 'SELECT id, name, monthly_limit FROM expenses_category_assigned_to_users WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return ExpenseModel::prepareCategoryArray($stmt);
    }


    public static function getPaymentMethods($id)
    {
        $sql = 'SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return ExpenseModel::prepareMethodArray($stmt);
    }

    public function saveExpense()
    {
        $id = $_SESSION['user_id'];

        $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
                VALUES (:user_id, :category_id, :payment_method, :amount, :expense_date, :comment)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $this->category, PDO::PARAM_INT);
        $stmt->bindValue(':payment_method', $this->method, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $this->amount);
        $stmt->bindValue(':expense_date', $this->date);
        $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

        return $stmt->execute();
    }

    private static function checkMonthlyLimit($category)
    {
        $sql = 'SELECT monthly_limit FROM expenses_category_assigned_to_users WHERE id = :category_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':category_id', $category);

        $stmt->execute();

        $single_row = $stmt->fetch(PDO::FETCH_ASSOC);

        $monthly_limit = $single_row['monthly_limit'];

        return $monthly_limit;
    }

    private static function checkDates($DBdate){

        $date_period=strtotime(date("Y-m"));
        $single_date=strtotime(date("Y-m", strtotime($DBdate)));
  
        if($date_period == $single_date){
            return true;
        }
        else {
            return false;
        }
    }

    private static function calculateMonthlyUsedAmountOnCategory($object)
    {
        $row_number = $object->rowCount();
        $monthly_used_amount = 0;
 
        $i = 1;
        while($i <= $row_number)
        {
            $single_row = $object->fetch(PDO::FETCH_ASSOC);
            $date_of_expense = $single_row['date_of_expense'];
            if (ExpenseModel::checkDates($date_of_expense))
            {
               $amount = $single_row['amount'];
               $monthly_used_amount = $monthly_used_amount + $amount;
            }
            $i++;
         }
         return $monthly_used_amount;
    }

    public static function showMonthlyLimit($amount, $category)
    {
        $total_amount = 0;
        $monthly_limit = ExpenseModel::checkMonthlyLimit($category);
        
        if ($monthly_limit != NULL){

            $sql = 'SELECT amount, date_of_expense FROM expenses WHERE expense_category_assigned_to_user_id = :category_id';
    
            $db = static::getDB();
            $stmt = $db->prepare($sql);
    
            $stmt->bindValue(':category_id', $category);
    
            $stmt->execute();
    
            $monthly_used_amount = ExpenseModel::calculateMonthlyUsedAmountOnCategory($stmt);
            $total_amount = $monthly_used_amount + $amount;

            if ($total_amount <= $monthly_limit){
                echo "<div class='success'>Limit miesięczny: ".$monthly_limit." PLN <br/>";
                echo "Kwota wydana: ".$monthly_used_amount." PLN <br/>";
                echo "Kwota po dodaniu: ".$total_amount." PLN </div>";
            }
            else {
                echo "<div class='failure'>UWAGA! LIMIT PRZEKROCZONY <br/>";
                echo "Limit miesięczny: ".$monthly_limit." PLN <br/>";
                echo "Kwota wydana: ".$monthly_used_amount." PLN <br/>";
                echo "Kwota po dodaniu: ".$total_amount." PLN </div>";
            }
        }
    }
}
