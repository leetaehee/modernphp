<?php
    namespace Hanbit;

    class DatabaseTable
    {
        private $pdo;
        private $table;
        private $primaryKey;
        private $className;
        private $constructorArgs;

        public function __construct(\PDO $pdo, string $table, string $primaryKey,
                                    string $className = '\stdClass', array $constructorArgs = [])
        {
            $this->pdo = $pdo;
            $this->table = $table;
            $this->primaryKey = $primaryKey;
            $this->className = $className;
            $this->constructorArgs = $constructorArgs;
        }

        /**
         *  쿼리 실행
         */
        private function query($sql, $parameter = [])
        {
            $query = $this->pdo->prepare($sql);

            $query->execute($parameter);
            return $query;
        }

        /**
         * 테이블의 전체 로우 개수 구하기
         */
        public function total($field = null, $value = null)
        {
            $sql = 'SELECT COUNT(*) FROM `' .$this->table.'`';
            $parameters = [];

            if (!empty($field)) {
                $sql .= ' WHERE `'.$field.'` =:value';

                $parameters = ['value'=> $value];
            }

            $query = $this->query($sql, $parameters);

            $row = $query->fetch();

            return $row[0];
        }

        /**
         * ID로 테이블 데이터 가져오기
         */
        public function findById($value)
        {
            $query = 'SELECT * FROM `'. $this->table .'` WHERE `' . $this->primaryKey . '` =:value';

            $parameter = [
                'value'=> $value
            ];

            $query = $this->query($query, $parameter);

            return $query->fetchObject($this->className, $this->constructorArgs);
        }

        /**
         * 컬럼을 받아서 해당 컬럼으로 데이터 조회
         */
        public function find($column, $value, $orderby = null, $limit = null, $offset = null)
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

            $parameters = [
              'value'=> $value
            ];

            if ($orderby != null) {
                $query .= ' ORDER BY ' . $orderby;
            }

            if ($limit != null) {
                $query .= ' LIMIT ' . $limit;
            }

            if ($offset != null) {
                $query .= ' OFFSET ' . $offset;
            }

            $query = $this->query($query, $parameters);

            return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
        }

        /**
         * 테이블 데이터 삽입
         */
        private function insert($fields)
        {
            $query = 'INSERT INTO `'. $this->table .'` (';

            foreach ($fields as $key => $value) {
                $query .= '`' . $key . '`,';
            }

            $query = rtrim($query,',');

            $query .= ') VALUES (';

            foreach ($fields as $key => $value) {
                $query .= ':' . $key . ',';
            }

            $query = rtrim($query, ',');

            $query .= ')';

            $fields = $this->processDates($fields);

            $this->query($query, $fields);

            return $this->pdo->lastInsertId();
        }

        /**
         * 테이블 데이터 수정
         */
        private function update($fields)
        {
            $query = 'UPDATE `'. $this->table .'` SET ';

            foreach ($fields as $key => $value) {
                $query .= '`' . $key . '` = :' . $key . ',';
            }

            $query = rtrim($query, ',');

            $query .= ' WHERE `' . $this->primaryKey .'` = :primaryKey';

            $fields['primaryKey'] = $fields[$this->primaryKey];

            $fields = $this->processDates($fields);

            $this->query($query, $fields);
        }

        /**
         * 테이블 데이터 삭제
         */
        public function delete($id)
        {
            $parameters = [':id' => $id];

            $this->query('DELETE FROM `' . $this->table  . '` WHERE `'. $this->primaryKey .'` = :id',$parameters);
        }

        /**
         * 테이블의 모든 데이터 가져오기
         */
        public function findAll($orderby = null, $limit = null, $offset = null)
        {
            $query = 'SELECT * FROM ' . $this->table;

            if ($orderby != null) {
                $query .= ' ORDER BY ' . $orderby;
            }

            if ($limit != null) {
                $query .= ' LIMIT ' . $limit;
            }

            if ($offset != null) {
                $query .= ' OFFSET ' . $offset;
            }

            $result = $this->query($query);

            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
        }

        /**
         * 날짜 형식 처리
         */
        private function processDates($fields)
        {
            foreach ($fields as $key => $value) {
                if ($value instanceof \DateTime) {
                    $fields[$key] = $value->format('Y-m-d H:i:s');
                }
            }
            return $fields;
        }

        /**
         * 데이터 삽입 또는 수정을 선택적으로 처리하는 메서드
         */
        public function save($record)
        {
            $entity = new $this->className(...$this->constructorArgs);

            try {
                if ($record[$this->primaryKey] == ''){
                    $record[$this->primaryKey] = null;
                }

                $insertId = $this->insert($record);

                $entity->{$this->primaryKey} = $insertId;

            } catch (\PDOException $e) {
                $this->update($record);
            }

            foreach ($record as $key => $value) {
                if (!empty($value)) {
                    $entity->key = $value;
                }
            }

            return $entity;
        }

        /**
         * 조건에 해당하는 row만 삭제
         */
        public function deleteWhere($column, $value)
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

            $parameters = [
                ':value'=> $value
            ];

            $query =  $this->query($query, $parameters);
        }
    }