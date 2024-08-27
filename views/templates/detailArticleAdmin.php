<?php
    /**
     * Ce template affiche un article et ses commentaires.
     * Il affiche également un formulaire pour ajouter un commentaire.
     */
?>

<article class="mainArticle">
    <h2> <?= Utils::format($article->getTitle()) ?> </h2>
    <span class="quotation">«</span>
    <p><?= Utils::format($article->getContent(400)) ?></p>

    <div class="footer">
        <span class="info"> Publié le <?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></span>
        <?php if ($article->getDateUpdate() != null) { ?>
            <span class="info"> Modifié le <?= Utils::convertDateToFrenchFormat($article->getDateUpdate()) ?></span>
        <?php } ?>
    </div>
</article>


<div class="comments">
    <h2 class="commentsTitle">Vos Commentaires</h2>
    <?php
    if (empty($comments)) { ?>
        <p class="info">Aucun commentaire pour cet article.</p>
    <?php 
    } else {?>
        <ul>
        <?php foreach ($comments as $comment) {?>
            <li>
                <div class="smiley">☻
                    <a href="index.php?action=deleteComment&id=<?= $comment->getId() ?>" <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce commentaire ?") ?> ><i class="fa-regular fa-trash-can"></i></a>
                </div>
                <div class="detailComment">
                    <h3 class="info">Le <?= Utils::convertDateToFrenchFormat($comment->getDateCreation()) ?><?=Utils::format($comment->getPseudo())?>a écrit :</h3>
                    <p class="content"><?= Utils::format($comment->getContent())?></p>
                </div>
            </li>
        <?php } ?>          
        </ul>
        <?php }    
    ?> 
</div>



