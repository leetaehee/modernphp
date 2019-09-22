<?php

    function query($pdo, $sql, $parameters = [])
    {
        $query = $pdo->prepare($sql);

        $query->execute($parameters);

        return $query;
    }

    function totalJokes($pdo)
    {
        $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');

        $row = $query->fetch();

        return $row[0];
    }

    function getJoke($pdo, $id)
    {
        $parameters = [
            'id' => $id
        ];

        $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id',$parameters);

        return $query->fetch();
    }

    function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof DateTime) {
                $fields[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        return $fields;
    }

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
    
    function deleteJoke($pdo, $id)
    {
        $query = 'DELETE FROM `joke` WHERE `id` = :id';

        $parameters = [
          'id'=> $id
        ];

        query($pdo, $query, $parameters);
    }

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
