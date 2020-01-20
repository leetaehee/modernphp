<?php if ($isWrite): ?>
    <form action="/joke/edit" method="post">
        <input type="hidden" name="joke[id]" value="<?=$joke->id ?? ''?>">
        <label for="joketext">유머 글을 입력해주세요.</label>
        <textarea id="joketext" name="joke[joketext]" row="3" cols="40"><?=$joke->joketext ?? ''?></textarea>

        <p>유머 카테고리 선택:</p>
        <?php foreach($categories as $category): ?>
            <?php if($joke && $joke->hasCategory($category->id)): ?>
                <input type="checkbox" checked name="category[]" value="<?=$category->id?>" />
            <?php else: ?>
                <input type="checkbox" name="category[]" value="<?=$category->id?>" />
            <?php endif; ?>
            <label><?=$category->name?></label>
        <?php endforeach; ?>

        <input type="submit" name="submit" value="등록">
    </form>
<?php else: ?>
    <p>로그인한 계정으로만 글을 쓸 수 있습니다.</p>
    <p>다른 사람 계정으로는 수정 할 수 없습니다.</p>
<?php endif; ?>
