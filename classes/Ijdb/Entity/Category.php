<?php
    namespace Ijdb\Entity;

    use Hanbit\DatabaseTable;

    class Category
    {
        public $id;
        public $name;
        private $jokeTable;
        private $jokeCategoriesTable;

        public function __construct(DatabaseTable $jokeTable, DatabaseTable $jokeCategoriesTable)
        {
            $this->jokeTable = $jokeTable;
            $this->jokeCategoriesTable = $jokeCategoriesTable;
        }

        public function getJokes()
        {
            $jokeCategories = $this->jokeCategoriesTable->find('categoryId', $this->id);

            $jokes = [];

            foreach ($jokeCategories as $jokeCategory) {
                $joke = $this->jokeTable->findById($jokeCategory->jokeId);


                if ($joke) {
                    $jokes[] = $joke;
                }
            }

            return $jokes;
        }
    }