<?php

// Формат запроса

// $table_name->insert()
//     ->values(['name'=>'username','email'=>'email'])
//     ->execute();

// $table_name->select()
//     ->where(['name' => 'tester'])
//     ->get();

namespace System;

use PDO;
class ORM extends DB
{
    private $sql_query;	// Сам запрос
    private $values_for_exec; // Массив значений для экранирования
    private $type;
    private $model;
    private $response = [];

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

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
        $vals = array(); // Массив значений, которые будут "подготовленными"
        if (!empty($fields)) {
            foreach($fields as $v){ // Превращаем строку в массив подготовленных значений
                $vals[] = "$v"; // Формируем строку, добавляя операцию
            }
            $str = implode(', ',$vals);
            $this->sql_query = "SELECT $str FROM `$this->model` "; // Начинаем формировать строку запроса
        }
        else {
            $this->sql_query = "SELECT * FROM `$this->model` "; // Начинаем формировать строку запроса
        }
        return $this; // Здесь $this вернёт объект
    }

    public function join($tableName, $field1, $field2) {
        $this->sql_query .= " JOIN $tableName ON $field1 = $field2";
        return $this;
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
    public function update(){
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

    public function group_by($field){
        $this->sql_query .= " GROUP BY " . $field;
        return $this;
    }

    public function order_by($val, $type){ // Создаем метод для выборки данных, отсортированных определенным образом
        $this->sql_query .= "ORDER BY `$val` $type"; // Модифицируем строку запроса
        return $this;
    }

    public function limit($from, $to = NULL){ // Создаем метод для выборки определенного количества записей
        if($to == NULL){
            $res_str = $from;
        }else{
            $res_str = $from . "," . $to;
        }
        $this->sql_query .= " LIMIT " . $res_str; // Модифицируем строку запроса
        return $this;
    }

    // Возвращает ID последней вставленной строки
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

    // Получить массив записей
    public function all(){
        $q = $this->pdo->prepare($this->sql_query);
        $status = $q->execute($this->values_for_exec);
        $this->set_default(); // Сбрасываем все значения

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            return $info;
        }
        return $q->fetchall(PDO::FETCH_ASSOC);
    }

    // Получить одну запись
    public function get(){
        $q = $this->pdo->prepare($this->sql_query);
        $status = $q->execute($this->values_for_exec);
        $this->set_default(); // Сбрасываем все значения

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            return $info;
        }
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    // Выполнить запрос не требующий ответа
    public function execute(){
        $q = $this->pdo->prepare($this->sql_query);
        $status = $q->execute($this->values_for_exec);
        $this->set_default(); // Сбрасываем все значения

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            return $info;
        }
        return $status;
    }

    // Получить ответ в виде объекта модели
    public function getObject(){
        $q = $this->pdo->prepare($this->sql_query);
        $status = $q->execute($this->values_for_exec);
        $this->set_default(); // Сбрасываем все значения

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            return $info;
        }
        array_push($this->response, $q->fetchall(PDO::FETCH_ASSOC));
        return $this;
    }
}