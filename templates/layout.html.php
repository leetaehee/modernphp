<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/jokes.css">
        <title><?=$title?></title>
    </head>
    <body>
        <header>
            <h1>인터넷 유머 세상</h1>
        </header>
        <nav>
            <ul>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="/joke/list">유머 글 목록</a>
                </li>
                <li>
                    <a href="/joke/edit">유머 글 등록</a>
                </li>
                <?php if ($loggedIn): ?>
                    <li>
                        <a href="/logout/success">로그아웃</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/login">로그인</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <main>
            <?=$output?>
        </main>
        <footer>
            &copy; IJDB 2019
        </footer>
    </body>
</html>