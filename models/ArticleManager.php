<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles() : array
    {
        //$sql = "SELECT * FROM article";
        $sql = "SELECT a.*, COUNT(DISTINCT c.id) as commentCounter FROM article a LEFT JOIN comment c ON a.id = c.id_article GROUP BY c.id_article"; 
        //$sql = "SELECT * FROM article a LEFT JOIN comment c ON c.id a.article_id";
       //$sql = "SELECT DISTINCT(a.*), COUNT(c.id) FROM article a LEFT JOIN comment c ON a.id = c.id_article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($articleArray = $result->fetch()) {
            $article = new Article($articleArray);
            $article->setCommentCounter(2);// remplacer 2 par ($artileArray[nom colonne]); cf nom colonne dans var_dump ou ajouter nom dans requete select
          //  $article->setCommentCounter(["commentCounter"]);
            
            $articles[] = $article;
            var_dump($articleArray);
        }
        
        return $articles;
    }
    
    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id) : ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

        /**
         * Increase number of article views
         * @return void
         */
        
        public function increaseViewCounter(Article $article) : void
        {
            $sql = "UPDATE article SET view_counter = view_counter+1 WHERE id = :id";
  //          $sql = "UPDATE article SET view_counter = :view_counter WHERE id = :id";
            $this->db->query($sql, [
 // inutle               'view_counter' => $article->getViewCounter(),
                'id' => $article->getId()
            ]);
        }

    /**
     * NE FONCTIONNE PAS !!!!!
     * Récupère les statistiques.
     * @return array : un tableau d'objets Stats[].
     */
    /*public function getStats() : array
    {
        $sqlArticle = "SELECT id, title, content, date_creation, view_counter FROM article";
        $sqlComment = "SELECT id_article, COUNT(id_article) FROM comment GROUP BY id_article";

        $resultArticle = $this->db->query($sqlArticle);
        $resultComment = $this->db->query($sqlComment);
        $stats = [];

        while ($row = $resultArticle->fetch()) {
            while ($rowComment = $resultComment->fetch()){
                if ($row['id'] == $rowComment['id_article'])
                    $stat = [
                        'commentNumber' => $rowComment["COUNT(id_article)"]
                    ];            
                $stat = [
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'date_creation' => $row['date_creation'],
                    'view_counter' => $row['view_counter'],
                    ];
            }
            $stats[] = $stats;
        }
        return $stats;
    }*/

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void 
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article) : void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article) : void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}