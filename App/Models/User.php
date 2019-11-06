<?php

namespace App\Models;

use PDO;
use \App\Flash;

class User extends \Core\Model
{
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (username, password_hash, email)
                    VALUES (:name, :password_hash, :email)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            if ($stmt->execute()){
               $id = $this->findUserIdByEmail($this->email);
               $this->copyNewUserData($id);
               return true;
            }
        }

        return false;
    }

    public function validate()
    {
        // Name
        if ($this->name == '') {
            $this->errors[] = 'Nazwa jest wymagana';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Niepoprawny email';
        }
        if (static::emailExists($this->email)) {
            $this->errors[] = 'Adres email już istnieje';
        }

        // Password
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Hasło powinno mieć co najmniej 6 znaków';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło powinno mieć co najmniej jedną literę';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło powinno mieć co najmniej jedną cyfrę';
        }

        if ($this->password != $this->password_confirmation) {
            $this->errors[] = 'Hasła muszą być zgodne';
        }
    }

    public static function emailExists($email)
    {
        return static::findByEmail($email) !== false;
    }

    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function findUserIdByEmail($email)
    {
        $sql = 'SELECT id FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];

        return $id;
    }

    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }

            Flash::addMessage('Niepoprawne hasło');
        }
        else {
           Flash::addMessage('Nie ma konta na podany adres email');
        }

        return false;
    }

    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }


   private function copyDefaultExpensesCategory($user_id)
   {
      $sql = 'SELECT * FROM expenses_category_default';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         $name = $row['name'];
         $category_name_query='INSERT INTO expenses_category_assigned_to_users (user_id, name)
                               VALUES (:id, :name)';
         $stmt2 = $db->prepare($category_name_query);
         $stmt2->bindValue(':id', $user_id, PDO::PARAM_INT);
         $stmt2->bindValue(':name', $name, PDO::PARAM_STR);

         $stmt2->execute();
      }
   }

   private function copyDefaultIncomesCategory($user_id)
   {
      $sql = 'SELECT * FROM incomes_category_default';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         $name = $row['name'];
         $category_name_query='INSERT INTO incomes_category_assigned_to_users (user_id, name)
                               VALUES (:id, :name)';
         $stmt2 = $db->prepare($category_name_query);
         $stmt2->bindValue(':id', $user_id, PDO::PARAM_INT);
         $stmt2->bindValue(':name', $name, PDO::PARAM_STR);

         $stmt2->execute();
      }
   }

   private function copyDefaultPaymentMethods($user_id)
   {
      $sql = 'SELECT * FROM payment_methods_default';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->execute();

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         $name = $row['name'];
         $method_name_query='INSERT INTO payment_methods_assigned_to_users (user_id, name)
                               VALUES (:id, :name)';
         $stmt2 = $db->prepare($method_name_query);
         $stmt2->bindValue(':id', $user_id, PDO::PARAM_INT);
         $stmt2->bindValue(':name', $name, PDO::PARAM_STR);

         $stmt2->execute();
      }
   }

   private function copyNewUserData($user_id)
   {
      $this->copyDefaultExpensesCategory($user_id);

      $this->copyDefaultIncomesCategory($user_id);

      $this->copyDefaultPaymentMethods($user_id);
   }
}
