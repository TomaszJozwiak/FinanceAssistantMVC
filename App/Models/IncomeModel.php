<?php

namespace App\Models;

use PDO;

class IncomeModel extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public static function getIncomeCategories($id)
    {
        $sql = 'SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function saveIncome()
   {
      $id = $_SESSION['user_id'];

      $sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
              VALUES (:user_id, :category_id, :amount, :income_date, :comment)';

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':category_id', $this->category, PDO::PARAM_INT);
      $stmt->bindValue(':amount', $this->amount);
      $stmt->bindValue(':income_date', $this->date);
      $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

      return $stmt->execute();
   }
}
