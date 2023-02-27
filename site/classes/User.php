<?php



final class User extends AbstractClasses\Unit
{

    use Traits\IdTrait;

    const TABLE = 'Users';
    
    public static function check() : bool
    {
        
        error_reporting(0);
        
         //заходим в базу смотрим сколько у нас юзеров с таким паролем и логинов
         $pdo = \Connection::getConnection();
         $result = $pdo->query(" SELECT COUNT(*) as num FROM " . static::TABLE . " WHERE user_hash =  '" . $_POST['token'] . "'");
         $row = $result->fetch();
 
         //возвращаем ответ в зависимости от цифры 0 или 1
         if ($row['num'] > 0) {
             return true;
         }
         return false;
     }
    

    public static function logOut() 
    {
        $pdo = \Connection::getConnection();
        $pdo->query(" UPDATE " . static::TABLE . " SET user_hash = '' WHERE user_hash = '" . $_POST['token'] . "'");
    }

    // final - значит м етод нельзя переопределить в наследниках 
    final public static function logIn() : ?string
    {

        error_reporting(0);

        //получаем логин и смотрим есть ли юзер с таким логином или имейлом
        $login = $_POST['login'];

        $password = $_POST['password'];

        $pdo = \Connection::getConnection();

        $result = $pdo->query(" SELECT * FROM " . static::TABLE . " WHERE login = '$login' ");

        $row = $result->fetch();
        
        //если нет возвращаем null
        if (!isset($row['id'])) {
            return null;
        }

        //если есть то начинаем проверять пароль
        //если пароль неверный возвращаем null
        if (!hash_equals($row['password'], crypt($password, 'shop'))) {
            return null;
        }

        //если пароль верный то
        //генерируем токен 
        $token = crypt($row['id'] . $row['password'] . time(), 'shop');

        //записываем токен в бд
        $pdo->query(" UPDATE " . static::TABLE . " SET user_hash = '$token' WHERE id = " . $row['id'] );

        //возвращаем token
        return $token;
    }

    public static function exists()  : bool
    {

        error_reporting(0);
        
        $e_mail = $_POST['e-mail'];

        //заходим в базу смотрим сколько у нас юзеров с таким паролем и логинов
        $pdo = \Connection::getConnection();
        
        $result = $pdo->query(" SELECT COUNT(id) as num FROM " . static::TABLE . " WHERE e_mail = '$e_mail' ");

        $row = $result->fetch();

        //возвращаем ответ в зависимости от цифры 0 или 1
        if ($row['num'] > 0) {
            return true;
        }
        return false;
    }


    final public static function createUser() {

        error_reporting(0);

        $pdo = \Connection::getConnection();

        //запрос на создание пользователя
        $name = $_POST['name'];
        $e_mail = $_POST['e-mail'];
        $login = $_POST['login'];
        $pass = $_POST['password'];
        $password = crypt($pass, 'shop');

        $sql_ins = " INSERT INTO " . static::TABLE . " (`name`, `e_mail`, `login`, `password`) VALUES ('$name', '$e_mail', '$login', '$password') ";
        
        $pdo->query($sql_ins);
    

    }


    public static function deleteUser() {

    //заходим в базу смотрим сколько у нас юзеров с таким паролем и логинов
    $pdo = \Connection::getConnection();
    $result = $pdo->query(" DELETE FROM " . static::TABLE . " WHERE user_hash = '" . $_POST['token'] . "'");

    }
}