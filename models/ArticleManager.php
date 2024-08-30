<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les articles et les trie selon le champ demandé dans l'ordre demandé.
     * @param : champ à trier, ordre de tri
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles($field="id", $sortOrder="ASC") : array
    {
        //Pour sécuriser, vérifier que $field correspond à un élément d'une white_liste, liste de valeurs autorisées
        $field = $this->white_list($field, ["id", "title", "view_counter", "commentCounter", "date_creation"], "Invalid field name");
        $sortOrder = $this->white_list($sortOrder, ["ASC","DESC"], "Invalid ORDER BY direction");
        
        $sql = "SELECT a.*, COUNT(DISTINCT c.id) as commentCounter FROM article a 
        LEFT JOIN comment c ON a.id = c.id_article GROUP BY c.id_article ORDER BY $field $sortOrder";
           
        $result = $this->db->query($sql);
        $articles = [];

        while ($articleArray = $result->fetch()) {
            $article = new Article($articleArray);
            $commentCounter=$articleArray["commentCounter"];
            $article->setCommentCounter($commentCounter);
            
            $articles[] = $article;
        }
        
        return $articles;
    }

     /**
     * Vérifie que la valeur passée en paramètre correspond à une liste préétablie.
     * Pour éviter les failles de sécurité d'une commande passée via l'URL
     * @param : valeur passée en paramètre, tableau des valeurs autorisée, message d'erreur
     * @return array : valeur par défaut (première de la liste) ou valeur demandée validée.
     */

    function white_list(&$value, $allowed, $message) {
        if ($value === null) {
            return $allowed[0];
        }
        $key = array_search($value, $allowed, true);
        if ($key === false) { 
            throw new InvalidArgumentException($message); 
        } else {
            return $value;
        }
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
            var_dump($article);
            return new Article($article);
        }
        return null;
    }

        /**
         * Increase number of article views
         * @param Article object
         * @return void
         */
        
        public function increaseViewCounter(Article $article) : void
        {
            $sql = "UPDATE article SET view_counter = view_counter+1 WHERE id = :id";
            $this->db->query($sql, [
                'id' => $article->getId()
            ]);
        }

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
        $sql = "INSERT INTO article (id_user, title, content, date_creation, date_update) VALUES (:id_user, :title, :content, NOW(), NOW())";
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