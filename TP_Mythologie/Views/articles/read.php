<!-- js requetes ajax perso -->
<script defer src="<?= ROOT_PUBLIC ?>assets/js/ajax.js"></script>

<!-- Modal suppression article -->
<div class="modal fade" id="delete-article-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title ms-2 fw-bold" aria-labelledby="modal title">
                    Supprimer
                </h4>
                <button class="btn-close align-self-start m-1" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" aria-describedby="content">
                <p class="mt-1">Voulez-vous supprimer cet article ?</p>
                <div class="displayBox fw-bold ms-2 mt-4 mb-2">
                    <p><?= $article->titre_article ?></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <form action="" method="post">
                    <button class="btn btn-danger" type="submit" name="delete_article" value="<?= $article->id_article ?>">Supprimer</button>
                </form>  
            </div>
        </div>
    </div>
</div>

<!-- Affichage de l'article -->
<div class="d-flex flex-column align-items-center">
    <article class="mt-5">
        <div class="d-flex justify-content-between align-items-center bg-light">
            <h2><?= $article->titre_article ?></h2>
            <?php if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user']['role'] === 'admin'): ?>
                    <button class="btn btn-danger h-75" data-bs-toggle="modal" data-bs-target="#delete-article-modal">Supprimer</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <h5 class="text-muted mb-2">par <span class="fw-bold"><?= ucFirst($article->pseudo_user) ?></span> le <span class="fw-bold fst-italic"><?= substr($article->date_article, 0, -3) ?></span></h5>
        <div class="">
            <img class="image-article float-start me-3 mb-3 mt-1" src="<?= ROOT_PUBLIC . 'assets/img/articles/' . $article->image_article ?>" alt="Illustration pour <?= $article->titre_article ?>">
            <p class=""><?= htmlspecialchars_decode($article->contenu_article) ?></p>
        </div>
    </article>
    <h2 class="mt-5 align-self-start">Commentaires :</h2>

    <!-- affichage des commentaires -->
    <div class="mt-2 w-100" id="comments-div">

    </div>


    <!-- form post commentaire -->
    <?php if(isset($_SESSION['user'])): ?>
        <div class="w-75 mt-5">
            <form class="form-control d-flex flex-column" id="comment-form" action="" method="post">
                <label for="content">Commentez :</label>
                <textarea name="content" id="content" placeholder="Votre commentaire ..." cols="20" rows="5"></textarea>
                <input id="id-user" name="id-user" type="hidden" value="<?= $_SESSION['user']['id'] ?>">
                <input id="id-article" name="id-article" type="hidden" value="<?= $article->id_article ?>">
                <button class="btn btn-primary" type="submit">Poster</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- bouton suppression commentaire only admin -->
    <div id="admin-btn" class="d-none">
        <?php if(isset($_SESSION['user'])): ?>
            <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <button class="btn btn-danger">Supprimer</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
