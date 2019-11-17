<?php

namespace App\Models;

use PDO;

class SettingsModel extends \Core\Model

{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function editIncomeCategory($id)
    {
        $sql = 'UPDATE incomes_category_assigned_to_users SET name = :name WHERE user_id = :id AND name = :pastName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->inputNewIncomeCategory, PDO::PARAM_STR);
        $stmt->bindValue(':pastName', $this->incomeCategoryName, PDO::PARAM_STR);

        $stmt->execute();
     }

     public function deleteIncomeCategory($id)
     {
         $sql = 'DELETE FROM incomes_category_assigned_to_users WHERE user_id = :id AND id = :incomeId';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);
         $stmt->bindValue(':incomeId', $this->incomeCategoryId, PDO::PARAM_STR);

         $stmt->execute();
      }

      public function deleteExistingIncomes($id)
      {
          $sql = 'DELETE FROM incomes WHERE user_id = :id AND income_category_assigned_to_user_id = :incomeId';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':incomeId', $this->incomeCategoryId, PDO::PARAM_STR);

          $stmt->execute();
       }

      public function addIncomeCategory($id)
      {
          $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) VALUES (:id, :name)';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':name', $this->inputNewIncomeCategory, PDO::PARAM_STR);

          $stmt->execute();
       }

       public function editExpenseCategory($id)
       {
           $sql = 'UPDATE expenses_category_assigned_to_users SET name = :name WHERE user_id = :id AND name = :pastName';

           $db = static::getDB();
           $stmt = $db->prepare($sql);
           $stmt->bindValue(':id', $id, PDO::PARAM_INT);
           $stmt->bindValue(':name', $this->inputNewExpenseCategory, PDO::PARAM_STR);
           $stmt->bindValue(':pastName', $this->expenseCategoryName, PDO::PARAM_STR);

           $stmt->execute();
        }

        public function deleteExpenseCategory($id)
        {
            $sql = 'DELETE FROM expenses_category_assigned_to_users WHERE user_id = :id AND id = :expenseId';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':expenseId', $this->expenseCategoryId, PDO::PARAM_STR);

            $stmt->execute();
         }

         public function deleteExistingExpenses($id)
         {
             $sql = 'DELETE FROM expenses WHERE user_id = :id AND expense_category_assigned_to_user_id = :expenseId';

             $db = static::getDB();
             $stmt = $db->prepare($sql);
             $stmt->bindValue(':id', $id, PDO::PARAM_INT);
             $stmt->bindValue(':expenseId', $this->expenseCategoryId, PDO::PARAM_STR);

             $stmt->execute();
          }

         public function addExpenseCategory($id)
         {
             $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) VALUES (:id, :name)';

             $db = static::getDB();
             $stmt = $db->prepare($sql);
             $stmt->bindValue(':id', $id, PDO::PARAM_INT);
             $stmt->bindValue(':name', $this->inputNewExpenseCategory, PDO::PARAM_STR);

             $stmt->execute();
          }

          public function editPaymentMethod($id)
          {
             $sql = 'UPDATE payment_methods_assigned_to_users SET name = :name WHERE user_id = :id AND name = :pastName';

             $db = static::getDB();
             $stmt = $db->prepare($sql);
             $stmt->bindValue(':id', $id, PDO::PARAM_INT);
             $stmt->bindValue(':name', $this->inputNewPaymentMethod, PDO::PARAM_STR);
             $stmt->bindValue(':pastName', $this->paymentMethodName, PDO::PARAM_STR);

             $stmt->execute();
           }

           public function deletePaymentMethod($id)
           {
               $sql = 'DELETE FROM payment_methods_assigned_to_users WHERE user_id = :id AND id = :paymentMethodId';

               $db = static::getDB();
               $stmt = $db->prepare($sql);
               $stmt->bindValue(':id', $id, PDO::PARAM_INT);
               $stmt->bindValue(':paymentMethodId', $this->paymentMethodId, PDO::PARAM_STR);

               $stmt->execute();
           }

           public function deleteExistingPaymentMethod($id)
           {
                $sql = 'DELETE FROM expenses WHERE user_id = :id AND payment_method_assigned_to_user_id = :paymentMethodId';

                $db = static::getDB();
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':paymentMethodId', $this->paymentMethodId, PDO::PARAM_STR);

                $stmt->execute();
             }

           public function addPaymentMethod($id)
           {
                $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) VALUES (:id, :name)';

                $db = static::getDB();
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':name', $this->inputNewPaymentMethod, PDO::PARAM_STR);

                $stmt->execute();
             }
  }
