<?php
    namespace Ijdb\Entity;

    class Joke
    {
        public $id;
        public $authorid;
        public $jokedate;
        public $joketext;
        private $authorTable;
        private $author;
        private $jokeCategoriesTable;

        public function __construct(\Hanbit\DatabaseTable $authorTable,
                                    \Hanbit\DatabaseTable $jokeCategoriesTable)
        {
            $this->authorTable = $authorTable;
            $this->jokeCategoriesTable = $jokeCategoriesTable;
        }

        public function getAuthor()
        {
            if (empty($this->author)) {
                $this->author = $this->authorTable->findById($this->authorid);
            }

            return $this->author;
        }

        public function addCategory($categoryId)
        {
            $jokeCat = [
                'jokeId'=> $this->id,
                'categoryId'=> $categoryId
            ];

            $this->jokeCategoriesTable->save($jokeCat);
        }
    }