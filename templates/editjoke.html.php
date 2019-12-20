<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
</head>
<body>
<form action="/index.php?action=edit" method="post">
    <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
    <label for="joketext">유머 글을 입력해주세요.</label>
    <textarea id="joketext" name="joke[joketext]" row="3" cols="40"><?=$joke['joketext'] ?? ''?></textarea>
    <input type="submit" name="submmit" value="등록">
</form>
</body>
</html>