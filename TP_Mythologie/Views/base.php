<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?>Mythologia</title>

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- css perso -->
    <link rel="stylesheet" href="<?= ROOT_PUBLIC ?>assets/css/style.css">

    <!-- js bootstrap -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="d-flex align-items-center justify-content-between border-bottom">

        <a href="<?= ROOT_PUBLIC ?>"><p class="logo m-0 ms-3">Mythologia</p></a>

        <div class="me-3 d-flex">
            <?php if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user']['role'] === 'admin'): ?>
                    <div class="me-3">
                        <a href="<?= ROOT_PUBLIC ?>articles/add" class="btn btn-secondary">Rédiger un article</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="<?= ROOT_PUBLIC ?>users/logout" class="btn btn-danger">Deconnexion</a>
                <?php else: ?>
                    <a href="<?= ROOT_PUBLIC ?>users/login" class="btn btn-secondary">Connexion</a>
                    <a href="<?= ROOT_PUBLIC ?>users/register" class="btn btn-primary">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php if(!empty($_SESSION['msg'])): ?>
        <div class="d-flex justify-content-center mt-3">
            <div class="w-25 alert alert-<?= $_SESSION['msg'][0] ?>" role="alert">
                <p class="text-center mt-3"><?= $_SESSION['msg'][1]; ?></p>
                <?php unset($_SESSION['msg']); ?>
            </div>
        </div>

    <?php endif; ?>

    <div class="container d-flex flex-column d-flex-column align-items-center">
        <?= $content ?>
    </div>

</div>

</body>
</html>