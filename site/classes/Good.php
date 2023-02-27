<?php

class Good extends \AbstractClasses\Unit
{
    
    public $id;
    const TABLE = 'goods';

    function __construct(int $id)
    {
        $this->id = $id;
    }

    protected function getField(string $field) : mixed
    {        
        return $this->getLine()[$field];
    }

    protected function updateField(string $field) : bool
    {        

        return $this::updateLine()[$field];
    }

        //метод для получения всех полей из таблицы
        protected function getLine() : array
        {
            //если есть кэш, то выдаем данные оттуда
            //if ($this->data){
               //return $this->data;
            //}
            $pdo = \Connection::getConnection();
    
        //отправить запрос в БД
            $rezult = $pdo->query("SELECT * FROM " . static::TABLE . " WHERE id = " . $this->id);
    
            $user = $rezult->fetch();
    
            //сохраняем в кэш
            //$this->data = $user ;
    
            return $user;
    
        } 
    
        
    

}

