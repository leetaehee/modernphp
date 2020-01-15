<?php
    namespace Ijdb\Entity;

    class Author
    {
        public $id;
        public $name;
        public $email;
        public $password;
        private $jokeTable;

        public function __construct(\Hanbit\DatabaseTable $jokeTable)
        {
            $this->jokeTable = $jokeTable;
        }

        public function getJokes()
        {
            return $this->jokeTable->find('authorid', $this->id);
        }

        public function addJoke($joke)
        {
            $joke['authorid'] = $this->id;

            return $this->jokeTable->save($joke);
        }
    }