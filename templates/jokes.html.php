<div class="jokelist">
    <ul class="categories">
        <?php foreach($categories as $category): ?>
            <li><a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="jokes">
        <p><?=$totalJokes?>개 유머 글이 있습니다.</p>

        <?php foreach($jokes as $joke):?>
            <blockquote>
                <p>
                    <?=htmlspecialchars($joke->joketext,ENT_QUOTES,'utf-8')?>
                    (작성자:
                    <a href="mailto:<?=htmlspecialchars($joke->email,ENT_QUOTES,'utf-8');?>">
                        <?=htmlspecialchars($joke->getAuthor()->email,ENT_QUOTES,'utf-8');?>
                        <?=htmlspecialchars($joke->getAuthor()->name,ENT_QUOTES,'utf-8');?>
                    </a>
                    작성일: <?=$joke->jokedate?>)

                    <?php if(isset($userId) && !empty($userId)): ?>
                    <?php if($userId == $joke->authorid): ?>
                    <a href="/joke/edit?id=<?=$joke->id?>">수정</a>

                <form action="/joke/delete" method="POST">
                    <input type="hidden" name="id" value="<?=$joke->id?>">
                    <input type="submit" value="삭제">
                </form>
                <?php endif;?>
                <?php endif;?>
                </p>
            </blockquote>
        <?php endforeach;?>
    </div>
</div>