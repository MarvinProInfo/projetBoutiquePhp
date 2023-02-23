<?php
require_once ("../Inclusion/header.php");
?>

<div class="container">
    <table class="table table-dark">
        <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Image</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Taille</th>
            <th>Option</th>
        </thead>
        <tbody>
            <?php 
                        //On recupère tout les articles dans un objet PDOstatement
                        $response = $pdo->query("SELECT * FROM articles");
                        $articles = $response->fetchAll(PDO::FETCH_ASSOC);
                        foreach($articles as $article):
            ?>
            <tr>
                <td><?=$article['id']?></td>
                <td><?=$article['nom']?></td>
                <td style="height: 50px;"><img src="../assets/upload/<?=$article['image']?>" style="height: 50px;" alt="img produit"></td>
                <td><?=substr($article['description'],0,15)?>...</td>
                <td><?=$article['prix']?>€</td>
                <td><?=$article['taille']?></td>
                <td>
                    <input type="button" value="Voir">
                    <a href="<?=BASE."src/modifierArticle.php?id=".$article['id']?>"><input type="button" value="Modifier" class="bg-warning text-light"></a>
                    <a href="<?=BASE."src/supprimerArticle.php?id=".$article['id']?>"><input type="button" value="Supprimer" class="bg-danger text-light"></a>
                </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php
require_once ("../Inclusion/footer.php");
?>