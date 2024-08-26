<?php 
    /** 
     * Affichage de la partie statistique : liste des articles avec le nombre de vues
     * <a href="index.php?action=titleSortUp"><i class="fa-solid fa-sort-up"></i></a>
     * <a href="index.php?action=deleteComment&id='. $comment->getId() . '">
     */
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <div class="articleLine">
        <div class="title">Titre
            <a href="index.php?action=Sort&field=title&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=Sort&field=title&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="content">Contenu</div>
        <div class="counter">Nombre de vues
            <a href="index.php?action=Sort&field=view_counter&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=Sort&field=view_counter&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="counter">Nombre de commentaires
            <a href="index.php?action=Sort&field=commentCounter&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=Sort&field=commentCounter&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
        <div class="date">Date de création de l'article
            <a href="index.php?action=Sort&field=date_creation&sortOrder=ASC"><i class="fa-solid fa-sort-up"></i></a>
            <a href="index.php?action=Sort&field=date_creation&sortOrder=DESC"><i class="fa-solid fa-sort-down"></i></a>
        </div>
    </div>

    <?php $line = 0;
    foreach ($articles as $article) { 
        if ($line%2==0) {
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
        <?php $line++;
    } ?>
</div>

