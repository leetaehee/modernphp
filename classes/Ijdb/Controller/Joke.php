<?php
    namespace Ijdb\Controller;
    use \Hanbit\Authentication;
    use \Hanbit\DatabaseTable;
    
    class Joke
    {
        private $authorsTable;
        private $jokesTable;
        private $categoriesTable;
        private $authentication;

        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorTable,
                                    DatabaseTable $categoriesTable, Authentication $authentication)
        {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorTable;
            $this->categoriesTable = $categoriesTable;
            $this->authentication = $authentication;
        }

        public function list()
        {
            if (isset($_GET['category'])) {
                $category = $this->categoriesTable->findById($_GET['category']);
                $jokes = $category->getJokes();
            } else {
                $jokes = $this->jokesTable->findAll();
            }

            $title = '유머 글 목록';

            $totalJokes = $this->jokesTable->total();

            $author = $this->authentication->getUser();

            return ['template'=> 'jokes.html.php',
                    'title'=> $title,
                    'variables'=> [
                        'totalJokes'=> $totalJokes,
                        'jokes'=> $jokes,
                        'user'=> $author, // 기존코드 : 'userId' => $author->id
                        'categories'=> $this->categoriesTable->findAll()
                    ]
                ];
        }

        public function home()
        {
            $title = '인터넷 유머 세상';

            return ['template'=> 'home.html.php', 'title'=> $title];
        }

        public function delete()
        {
            $author = $this->authentication->getUser();

            $joke = $this->jokesTable->findById($_POST['id']);

            if ($joke->authorid != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)) {
                return;
            }

            $this->jokesTable->delete($_POST['id']);

            header('location: /joke/list');
        }

        public function saveEdit()
        {
            $author = $this->authentication->getUser();

            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->find($_GET['id']);
                if ($joke->authorid != $author->id) {
                    return;
                }
            }

            $joke = $_POST['joke'];
            $joke['jokedate'] = new \DateTime();

            $jokeEntity = $author->addJoke($joke);

            $jokeEntity->clearCategories($joke);

            foreach ($_POST['category'] as $categoryId) {
                $jokeEntity->addCategory($categoryId);
            }

            header('location: /joke/list');
        }

        public function edit()
        {
            $isWrite = false;

            $author = $this->authentication->getUser();

            $categories = $this->categoriesTable->findAll();

            $userId = $author->id ?? null;

            if (isset($_GET['id'])){
                $joke = $this->jokesTable->findById($_GET['id']);

                if (empty($joke->id) || $author->id == $joke->authorid || $author->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)) {
                    $isWrite = true;
                }
            }

            $title = '유머 글 수정';

            return [
                'template'=> 'editjoke.html.php',
                'title'=> $title,
                'variables'=>[
                    'joke'=> $joke ?? null,
                    'user'=> $author,
                    'isWrite'=> $isWrite,
                    'categories'=> $categories
                ]
            ];
        }
    }