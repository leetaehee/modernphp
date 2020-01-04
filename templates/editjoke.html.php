<?php if ($isWrite): ?>
    <form action="/joke/edit" method="post">
        <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
        <label for="joketext">유머 글을 입력해주세요.</label>
        <textarea id="joketext" name="joke[joketext]" row="3" cols="40"><?=$joke['joketext'] ?? ''?></textarea>
        <input type="submit" name="submmit" value="등록">
    </form>
<?php else: ?>
    <p>자신이 작성한 글만 수정할 수 있습니다.</p>
<?php endif; ?>
