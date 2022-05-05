<!-- index des articles -->
<div class="row">
    <?php foreach($articles as $article): ?> 
        <article class="card m-5">
            <a href="<?= ROOT_PUBLIC . 'articles/read/' . $article->id_article ?>">
                <img class="card-img-top mt-3" src="<?= ROOT_PUBLIC . 'assets/img/articles/' . $article->image_article ?>" alt="Illustration pour <?= $article->titre_article ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $article->titre_article ?></h2>
                    <h6 class="card-subtitle text-muted mb-1">par <span class="fw-bold"><?= ucFirst($article->pseudo_user) ?></span> le <span class="fw-bold fst-italic"><?= substr($article->date_article, 0, -3) ?></span></h6>
                    <p class="card-text reset-text">
                        <?= substr(strip_tags(htmlspecialchars_decode($article->contenu_article)), 0, 240) ?> ...
                    </p>
                </div>
                </a>
        </article>
        
    <?php endforeach; ?>
</div>
