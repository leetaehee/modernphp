<?php
    namespace Ijdb\Entity;

    class Author
    {
        const EDIT_JOKES = 1;
        const DELETE_JOKES = 2;
        const LIST_CATEGORIES = 4;
        const EDIT_CATEGORIES = 8;
        const REMOVE_CATEGORIES = 16;
        const EDIT_USER_ACCESS = 32;

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

        public function hasPermission($permission)
        {
            return $this->permissions & $permission;
            
        }
    }