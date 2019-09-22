<?php
    /**
     * @param $pdo
     * @param $sql
     * @param array $parameters
     * @return mixed
     */
    function query($pdo, $sql, $parameters = [])
    {
        $query = $pdo->prepare($sql);

        $query->execute($parameters);

        return $query;
    }

    /**
     * @param $pdo
     * @return mixed
     */
    function totalJokes($pdo)
    {
        $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');

        $row = $query->fetch();

        return $row[0];
    }

    /**
     * @param $pdo
     * @param $id
     * @return mixed
     */
    function getJoke($pdo, $id)
    {
        $parameters = [
            'id' => $id
        ];

        $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id',$parameters);

        return $query->fetch();
    }

    /**
     * @param $fields
     * @return mixed
     */
    function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof DateTime) {
                $fields[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        return $fields;
    }

    /**
     * @param $pdo
     * @param $fields
     */
    function insertJoke($pdo, $fields)
    {
        $query = ' INSERT INTO `joke` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }

        $query = rtrim($query, ',');

        $query .= ') VALUES (';

        foreach ($fields as $key => $value) {
            $query .= ':' . $key .',';
        }

        $query = rtrim($query,',');

        $query .= ')';

        $fields = processDates($fields);

        query($pdo, $query, $fields);
    }

    /**
     * @param $pdo
     * @param $fields
     */
    function updateJoke($pdo, $fields)
    {
        $query = ' UPDATE `joke` SET ';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ' WHERE `id` = :primaryKey';

        $fields['primaryKey'] = $fields['id'];

        $fields = processDates($fields);

        query($pdo, $query, $fields);
    }

    /**
     * @param $pdo
     * @param $id
     */
    function deleteJoke($pdo, $id)
    {
        $query = 'DELETE FROM `joke` WHERE `id` = :id';

        $parameters = [
          'id'=> $id
        ];

        query($pdo, $query, $parameters);
    }

    /**
     * @param $pdo
     * @return mixed
     */
    function allJokes($pdo)
    {
        $query = 'SELECT `joke`.`id`,
                         `joke`.`joketext`,
                         `joke`.`jokedate`,
                         `author`.`name`,
                         `author`.`email`
                  FROM `joke`
                    INNER JOIN `author`
                      ON `joke`.`authorid` = `author`.`id`';

        $jokes = query($pdo, $query);

        return $jokes->fetchAll();
    }

    /**
     * @param $pdo
     * @param $table
     * @return mixed
     */
    function findAll($pdo, $table)
    {
        $result = query($pdo, 'SELECT * FROM `' . $table . '`');

        return $result->fetchAll();
    }

    /**
     * @param $pdo
     * @param $table
     * @param $primaryKey
     * @param $id
     */
    function delete($pdo, $table, $primaryKey, $id)
    {
        $parameter = [
          ':id'=>$id
        ];

        query($pdo, 'DELETE FROM `' .$table. '` WHERE `' .$primaryKey. '` = :id',$parameter);
    }

    /**
     * @param $pdo
     * @param $table
     * @param $fields
     */
    function insert($pdo, $table, $fields)
    {
        $query = 'INSERT INTO `' .$table. '` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key .'`,';
        }

        $query = rtrim($query,',');

        $query .= ') VALUES (';

        foreach ($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query,',');

        $query .= ')';

        $fields = processDates($fields);

        query($pdo, $query, $fields);
    }

    /**
     * @param $pdo
     * @param $table
     * @param $primaryKey
     * @param $fields
     */
    function update($pdo, $table, $primaryKey, $fields)
    {
        $query = 'UPDATE `' . $table . '` SET ';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ' WHERE `' . $primaryKey . '` = :primaryKey';

        $fields['primaryKey'] = $fields['id'];

        $fields = processDates($fields);

        query($pdo, $query, $fields);
    }

    /**
     * @param $pdo
     * @param $table
     * @param $primaryKey
     * @param $value
     * @return mixed
     */
    function findById($pdo, $table, $primaryKey, $value)
    {
        $query = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey . '` = :value';

        $parameters = [
          'value'=>$value
        ];

        $query = query($pdo, $query, $parameters);

        return $query->fetch();
    }

    /**
     * @param $pdo
     * @param $table
     * @return mixed
     */
    function total($pdo, $table)
    {
        $query = query($pdo, 'SELECT COUNT(*) FROM `'. $table .'`');

        $row = $query->fetch();

        return $row[0];
    }

    /**
     * @param $pdo
     * @param $table
     * @param $primaryKey
     * @param $record
     */
    function save($pdo, $table, $primaryKey, $record)
    {
        try {
          if ($record[$primaryKey] == '') {
              $record[$primaryKey] = null;
          }
          insert($pdo, $table, $record);
        } catch (PDOException $e) {
            update ($pdo, $table, $primaryKey, $record);
        }
    }