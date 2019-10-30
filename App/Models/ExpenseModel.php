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

    public static function getExpenseCategories($id)
    {
        $sql = 'SELECT id, name FROM expenses_category_assigned_to_users WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }


    public static function getPaymentMethods($id)
    {
        $sql = 'SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
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
}
