<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>
    </head>
    <body>
        <form action="/index.php?action=edit" method="post">
            <label for="joketext">유머 글을 입력해주세요.</label>
            <textarea id="joketext" name="joketext" row="3" cols="40"></textarea>
            <input type="submit" name="submmit" value="등록">
        </form>
    </body>
</html>