<?php 
    /** 
     * Affichage de la partie statistique : liste des articles avec le nombre de vues
     */
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <div class="articleLine">
        <div class="title">Titre
            <a href="index.php?action=stats&field=title&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=stats&field=title&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="content">Contenu</div>
        <div class="counter">Nombre de vues
            <a href="index.php?action=stats&field=view_counter&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=stats&field=view_counter&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="counter">Nombre de commentaires
            <a href="index.php?action=stats&field=commentCounter&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=stats&field=commentCounter&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="date">Date de création de l'article
            <a href="index.php?action=stats&field=date_creation&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=stats&field=date_creation&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
    </div>

    <?php
    foreach ($articles as $key=>$article) { 
        if ($key%2==0) {
            echo "<div class=\"articleLine evenLine\">";
        } else {
            echo "<div class=\"articleLine\">";
        } ?>
                <div class="title"><?= $article->getTitle() ?></div>
                <div class="content"><?= $article->getContent(200) ?></div>
                <div class="counter"><?= $article->getViewCounter() ?></div>
                <div class="counter"><?= $article->getCommentCounter() ?></div>
                <div class="date"><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></div>
            </div>
        <?php
    } ?>
</div>

