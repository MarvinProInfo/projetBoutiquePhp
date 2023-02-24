<?php

require_once ("../Inclusion/header.php");

?>

<?php

// debug($_POST);
//On verifie que le formulaire à  été envoyer
if (!empty($_POST)){
  //On vérifie que chaque input a été remplie
  if (!empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['description']) && !empty($_POST['taille']) && !empty($_FILES['image']['name'])) {
    //On verifie que notre fichier est de type jpeg ou png ou webp et que sa taill ne soit pas égale à 3mo
    if (($_FILES['image']['type']  =="image/jpeg" ||$_FILES['image']['type']  =="image/png"||$_FILES['image']['type']  =="image/webp") && $_FILES['image']['size'] <"3000000") {
      // debug($_FILES);
      //Condition  d'existance du dossier upload
      if(!file_exists('../assets/upload')){
        //methode de php pour créer un dossier avec droit de lecture et d'ecriture
        mkdir('../assets/upload',777);
      }
      //date_format attend deux arguments: une date et un format(dmYHis)
      $imgName = date_format(new DateTime(),'dmYHis').uniqid().$_FILES['image']['name'];
      copy($_FILES['image']['tmp_name'],"../assets/upload/".$imgName);

      //Tableau  des valeur  à envoyer
      $data = [
        'nom' => $_POST['nom'],
        'image' => $imgName,
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'taille' => $_POST['taille']
      ];

      //ici, on crée une variable qui contient notre requête
      $request = "INSERT INTO articles ( nom, image, description, prix, taille) VALUES (:nom, :image, :description, :prix, :taille)";
      $request2 = "INSERT INTO articles ( nom, image, description, prix, taille) VALUES (:nom, :image, :description, :prix, :taille)";

      $request2 = "INSERT INTO articles ( nom, image, description, prix, taille) VALUES (:nom, :image, :description, :prix, :taille)";
        //on prepare la requete a executer dans la bdd
        $response =$pdo->prepare($request);

        //* ici on execute la requête en remplaçant les marqueurs (:nom, :image etc....) par les valeurs de notre tableau data
        $response->execute(traitement($data));
        $_SESSION['messages']['success'][] = 'Votre article a bien été ajouté';
        header('location:../views/article.php');
        exit();
    }
  }
}

?>

<div class="container">
    <h1 class="text-center">Ajouter un article</h1>

      <form method="Post" enctype="multipart/form-data">
        <fieldset>
    
          <div class="form-group">
            <label for="nom" class="form-label mt-4">Nom de l'article</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom de l'article" name="nom">
          </div>
          <div class="form-group">
            <label for="prix" class="form-label mt-4">Prix</label>
            <input type="number" class="form-control" id="prix" placeholder="Prix" min="0" step="0.01" name="prix">
          </div>
          <div class="form-group">
            <label for="description" class="form-label mt-4">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="image" class="form-label mt-4">Image</label>
            <input class="form-control" type="file" id="image" name="image">
          </div>
          <div class="form-group">
            <label for="taille" class="form-label mt-4">Taille</label>
            <select class="form-select" id="taille" name="taille">
            <option value="xs">XS</option>
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="xl">XL</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary mt-5">Ajouter</button>

        </fieldset>
      </form>
</div>


<?php

require_once ("../Inclusion/footer.php");

?>