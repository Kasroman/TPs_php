<!-- ajout d'article -->

<script defer src='https://cdn.tiny.cloud/1/no-api-key/tinymce/4/tinymce.min.js'></script>
<script defer src="<?= ROOT_PUBLIC ?>assets/js/tinyMce.js"></script>

<div class="mt-5 w-75">
    <form class="form-control d-flex flex-column" action="" method="post" enctype="multipart/form-data">
        <label for="title">Titre de l'article :</label>
        <input type="text" name="title" id="title">
        <label for="content">Contenu :</label>
        <textarea name="content" id="content" placeholder="Votre article ..." cols="50" rows="20"></textarea>
        <label for="userfile">Ajoutez une image :</label>
        <input type="file" name="userfile" id="userfile">
        <button class="btn btn-primary" type="submit">Poster</button>
    </form>
</div>