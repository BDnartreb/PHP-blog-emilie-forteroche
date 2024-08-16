<?php 
    /** 
     * Affichage de la partie statistique : liste des articles avec le nombre de vues
     */
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <div class="articleLine">
        <div class="title">Titre
            <i class="fa-solid fa-sort-up"></i>
            <i class="fa-solid fa-sort-down"></i>
        </div>
        <div class="content">Contenu</div>
        <div class="counter">Nombre de vues</div>
        <div class="counter">Nombre de commentaires</div>
        <div class="date">Date de création de l'article</div>
    </div> 
    <?php foreach ($articles as $article) { //intégrer pair impair en comptant le nombre de variables affichées?>
        <div class="articleLine">
            <div class="title"><?= $article->getTitle() ?></div>
            <div class="content"><?= $article->getContent(200) ?></div>
            <div class="counter"><?= $article->getViewCounter() ?></div>
            <div class="counter"><?= $article->getCommentCounter() ?></div>
            <div class="date"><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></div>
        </div>
    <?php } ?>
</div>

