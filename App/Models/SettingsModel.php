<?php

namespace App\Models;

use PDO;
use \App\Flash;
use \App\Models\IncomeModel;
use \App\Models\ExpenseModel;

class SettingsModel extends \Core\Model

{
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    private function checkIfExist($name1, $data_array)
    {
      $string1 = strtolower($name1);

      foreach ($data_array as list($id, $name)) {
          $string2 = strtolower($name);
          if ($string1 == $string2){
            return true;
          }
       }
      return false;
    }

    public function editIncomeCategory($id)
    {
        if ($this->checkIfExist($this->inputNewIncomeCategory, IncomeModel::getIncomeCategories($id))){
           return false;
        }

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
          if ($this->checkIfExist($this->inputNewIncomeCategory, IncomeModel::getIncomeCategories($id))){
             return false;
          }

          $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) VALUES (:id, :name)';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':name', $this->inputNewIncomeCategory, PDO::PARAM_STR);

          $stmt->execute();
       }

     public function editExpenseCategory($id)
     {
        if ($this->checkIfExist($this->inputNewExpenseCategory, ExpenseModel::getExpenseCategories($id))){
           return false;
        }

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
          if ($this->checkIfExist($this->inputNewExpenseCategory, ExpenseModel::getExpenseCategories($id))){
             return false;
          }

          $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) VALUES (:id, :name)';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':name', $this->inputNewExpenseCategory, PDO::PARAM_STR);

          $stmt->execute();
       }

       public function editLimit($id)
       {
          $sql = 'UPDATE expenses_category_assigned_to_users SET monthly_limit = :monthlyLimit WHERE user_id = :id AND name = :pastName';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':pastName', $this->expenseCategoryName, PDO::PARAM_STR);
          $stmt->bindValue(':monthlyLimit', $this->monthlyLimit);

          $stmt->execute();
       }

       public function deleteLimit($id)
       {
          $sql = 'UPDATE expenses_category_assigned_to_users SET monthly_limit = NULL WHERE user_id = :id AND name = :pastName';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':pastName', $this->expenseCategoryName, PDO::PARAM_STR);

          $stmt->execute();
       }

       public function editPaymentMethod($id)
       {
          if ($this->checkIfExist($this->inputNewPaymentMethod, ExpenseModel::getPaymentMethods($id))){
             return false;
          }

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
         if ($this->checkIfExist($this->inputNewPaymentMethod, ExpenseModel::getPaymentMethods($id))){
           return false;
         }

          $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) VALUES (:id, :name)';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $stmt->bindValue(':name', $this->inputNewPaymentMethod, PDO::PARAM_STR);

          $stmt->execute();
       }

     public function changeUsername($id)
     {
        $sql = 'UPDATE users SET username = :username WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $this->newUsername, PDO::PARAM_STR);

        $stmt->execute();
     }

     private function findPasswordIdById($id)
     {
         $sql = 'SELECT password_hash FROM users WHERE id = :id';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);
         $stmt->execute();

         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         $userPassword = $row['password_hash'];

         return $userPassword;
     }

     private function authenticateOldPassword($id, $password)
    {
         $userPassword = $this->findPasswordIdById($id);

         if (!password_verify($password, $userPassword)) {
         $this->errors[] = 'Obecne hasło niepoprawne';
         Flash::addError('Obecne hasło niepoprawne');
         }
    }

    private function validatePassword()
   {
        if (strlen($this->newPassword) < 6) {
            $this->errors[] = 'Hasło powinno mieć co najmniej 6 znaków';
            Flash::addError('Hasło powinno mieć co najmniej 6 znaków');
        }

        if (preg_match('/.*[a-z]+.*/i', $this->newPassword) == 0) {
            $this->errors[] = 'Hasło powinno mieć co najmniej jedną literę';
            Flash::addError('Hasło powinno mieć co najmniej jedną literę');
        }

        if (preg_match('/.*\d+.*/i', $this->newPassword) == 0) {
            $this->errors[] = 'Hasło powinno mieć co najmniej jedną cyfrę';
            Flash::addError('Hasło powinno mieć co najmniej jedną cyfrę');
        }

        if ($this->newPassword != $this->newPasswordConfirmation) {
            $this->errors[] = 'Hasła muszą być zgodne';
            Flash::addError('Hasła muszą być zgodne');
        }
   }

   public function editPassword($id)
   {
       $this->validatePassword();
       $this->authenticateOldPassword($id, $this->oldPassowrd);

       if (empty($this->errors)) {

           $password_hash = password_hash($this->newPassword, PASSWORD_DEFAULT);

           $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :id';

           $db = static::getDB();
           $stmt = $db->prepare($sql);

           $stmt->bindValue(':id', $id, PDO::PARAM_INT);
           $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

           return $stmt->execute();
        }
     }

     private function deleteUserData($id)
     {
        $sql = 'DELETE FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
     }

     private function deleteUserIncomes($id)
     {
         $sql = 'DELETE FROM incomes WHERE user_id = :id';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);

         $stmt->execute();
     }

     private function deleteUserIncomeCategories($id)
     {
          $sql = 'DELETE FROM incomes_category_assigned_to_users WHERE user_id = :id';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);

          $stmt->execute();
      }

     private function deleteUserExpenses($id)
     {
         $sql = 'DELETE FROM expenses WHERE user_id = :id';

         $db = static::getDB();
         $stmt = $db->prepare($sql);
         $stmt->bindValue(':id', $id, PDO::PARAM_INT);

         $stmt->execute();
      }

      private function deleteUserExpenseCategories($id)
      {
          $sql = 'DELETE FROM expenses_category_assigned_to_users WHERE user_id = :id';

          $db = static::getDB();
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);

          $stmt->execute();
       }

      private function deleteUserPaymentMethods($id)
      {
            $sql = 'DELETE FROM payment_methods_assigned_to_users WHERE user_id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
       }

     public function deleteUser($id)
     {
        $this->deleteUserIncomes($id);
        $this->deleteUserIncomeCategories($id);
        $this->deleteUserExpenses($id);
        $this->deleteUserExpenseCategories($id);
        $this->deleteUserPaymentMethods($id);
        $this->deleteUserData($id);
     }
  }
