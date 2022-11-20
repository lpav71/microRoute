<?php

// Формат запроса

// $table_name->Insert()
//     ->values(['name'=>'username','email'=>'email'])
//     ->execute();

// $table_name->Select()
//     ->where(['name' => 'tester'])
//     ->execute();

namespace System;

use PDO;
class ORM extends DB
{
    private $sql_query;	// Сам запрос
    private $values_for_exec; // Массив значений для экранирования
    private $type;
    private $model;

    public function __construct()
    {
        $this->model = explode('\\', get_called_class())[1];  // Получаем вызвавшую модель
        $this->set_default();   // Сбрасываем все значения
        $this->Connect();       //Коннект к БД
        return $this;           //Возвращаем модель
    }

    private function set_default(){
        $this->sql_query = ""; // Сбрасываем строку запроса
        $this->values_for_exec = array(); // Сбрасываем массив значений для экранирования
        $this->type = ""; // Сбрасываем type после запроса
    }

    public function select(array $fields = []){ // Реализовываем метод для получения данных из БД
        $this->sql_query = "SELECT * FROM `$this->model` "; // Начинаем формировать строку запроса
        return $this; // Здесь $this вернёт объект
    }

    public function where(array $where, $op = '='){ // Метод для обработки условия выборки
        $vals = array(); // Массив значений, которые будут "подготовленными"
        foreach($where as $k => $v){ // Превращаем строку в массив подготовленных значений
            $vals[] = "`$k` $op :$k"; // Формируем строку, добавляя операцию
            $this->values_for_exec[":".$k] = $v; // Заполняем массив полученными значениями
        }
        $str = implode(' AND ',$vals);
        $this->sql_query .= " WHERE " . $str; // Модифицируем наш запрос
        return $this;
    }

    public function insert(){
        $this->sql_query = "INSERT INTO `$this->model` ";
        $this->type = 'insert'; // Добавляем тип запроса
        return $this;
    }
    public function update($table){
        $this->sql_query = "UPDATE `$this->model` ";
        $this->type = 'update'; // Добавляем тип запроса
        return $this;
    }
    public function values($arr_val){
        $cols = array();
        $masks = array();
        $val_for_update = array(); // Отдельный массив для формирования строки обновления записей

        foreach($arr_val as $k => $v){
            $value_key = explode(' ', $k);
            $value_key = $value_key[0];
            $cols[] = "`$value_key`";
            $masks[] = ':'.$value_key;

            $val_for_update[] = "`$value_key`=:$value_key";
            $this->values_for_exec[":$value_key"] = $v;
        }
        if($this->type == "insert"){ // Разделяем формирование строк запроса
            $cols_all = implode(',',$cols);
            $masks_all = implode(',',$masks);
            $this->sql_query .= "($cols_all) VALUES ($masks_all)";
        }else if($this->type == 'update'){
            $this->sql_query .= "SET ";
            $this->sql_query .= implode(',',$val_for_update);
        }
        return $this;
    }

    public function delete(){ // Метод для удаления записей из таблицы
        $this->sql_query = "DELETE FROM `$this->model`"; // Формируем запрос
        $this->type = 'delete';
        return $this;
    }

    public function order_by($val, $type){ // Создаем метод для выборки данных, отсортированных определенным образом
        $this->sql_query .= "ORDER BY `$val` $type"; // Модифицируем строку запроса
        return $this;
    }

    public function limit($from, $to = NULL){ // Создаем метод для выборки определенного количества записей
        $res_str = "";
        if($to == NULL){
            $res_str = $from;
        }else{
            $res_str = $from . "," . $to;
        }
        $this->sql_query .= " LIMIT " . $res_str; // Модифицируем строку запроса
        return $this;
    }

    public function execute(){
        $q = $this->pdo->prepare($this->sql_query);
        $q->execute($this->values_for_exec);
        $this->set_default(); // Сбрасываем все значения

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            return $info;
        }
        return $q->fetchall();
    }
}