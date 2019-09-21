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
     * @param $pdo
     * @param $joketext
     * @param $authorId
     */
    function insertJoke($pdo, $joketext, $authorId)
    {
        $query = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorId`) VALUES (:joketext, CURDATE(), :authorId)';


        $parameters = [
            ':joketext'=> $joketext,
            ':authorId'=> $authorId
        ];

        query($pdo, $query, $parameters);
    }

    /**
     * @param $pdo
     * @param $jokeId
     * @param $joketext
     * @param $authorId
     */
    function updateJoke($pdo, $jokeId, $joketext, $authorId)
    {
        $query = 'UPDATE `joke` SET `authorId` = :authorId, `joketext` = :joketext WHERE `id` = :id';

        $parameters = [
            ':joketext'=> $joketext,
            ':authorId'=> $authorId,
            ':id'=> $jokeId
        ];

        query($pdo, $query, $parameters);
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
        $query = 'SELECT `joke`.`id`, `joketext`, `name`, `email`
                  FROM `joke`
                    INNER JOIN `author`
                      ON `joke`.`authorid` = `author`.`id`';

        $jokes = query($pdo, $query);

        return $jokes->fetchAll();
    }
