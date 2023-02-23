<?php
require_once ("../Inclusion/header.php");
?>
<?php
if (isset($_GET['id'])) :
    $request = "SELECT * FROM articles WHERE id = :id";
    $response =  $pdo->prepare($request);
    // $data={
    //     'id'=> $_GET['id'];
    // };
    $response->execute(['id'=>$_GET['id']]);
    $articles = $response->fetch(PDO::FETCH_ASSOC);
    if(empty($article) ):
        header('location:gestionArticle.php');
        exit();
    endif;
else:
    header('location:gestionArticle.php');
    exit();
endif;
if (!empty($_POST)) {
    if (($_FILES['image']['type']  =="image/jpeg" ||$_FILES['image']['type']  =="image/png"||$_FILES['image']['type']  =="image/webp") && $_FILES['image']['size'] <"3000000"){
            $imageName = date_format(new Datetime(),'dmYHis').uniqid().$_FILES['image']['name'];
            //on supprime la précédente photo grâce à la méthode unlink qui attend l'argument le chemin complet d'accès au fichier à supprimer
            unlink('../assets/upload/'.$_POST['ancienneImage']);
            //on copie dans notre répertoire d'upload le fichier chargé et renommé
            copy($_FILES['image']['tmp_name'],'../assets/upload/'.$imageName);
    }else{
        $imageName = $_POST['ancienneImage'];
    }

    $data=[
        'nom'=>$_POST['nom'],
        'image'=>$imageName,
        'description'=>$_POST['description'],
        'prix'=>$_POST['prix'],
        'taille'=>$_POST['taille'],
        'id'=>$_GET['id']
    ];
    $request ="UPDATE articles SET nom=:nom, image=:image, description=:description, prix=:prix, taille=:taille WHERE id=:id";
    $response = $pdo->prepare($request);
    $response -> execute(traitement($data));

    $_SESSION['messages']['success'][]='Annonce modifiée avec succès';
    header('location:gestionArticle.php');
    exit();
        
    
}

;?>
<div class="container">
<h1 class="text-center">Modification</h1>

<form method="Post" enctype="multipart/form-data">
  <fieldset>
    
    <div class="form-group">
      <label for="nom" class="form-label mt-4">Nom de l'article</label>
      <input type="text" class="form-control" id="nom" placeholder="Nom de l'article" name="nom" value="<?=$articles['nom']?>">
    </div>
    <div class="form-group">
      <label for="prix" class="form-label mt-4">Prix</label>
      <input type="number" class="form-control" id="prix" placeholder="Prix" min="0" step="0.01" name="prix" value="<?=$articles['prix']?>">
    </div>
    <div class="form-group">
      <label for="description" class="form-label mt-4">Description</label>
      <textarea class="form-control" id="description" name="description"><?=$articles['description'];?></textarea>
    </div>
    <div class="form-group">
      <label for="image" class="form-label mt-4">Image</label>
      <input class="form-control" type="file" id="image" name="image">
    </div>
    <div class="form-group">
      <label for="taille" class="form-label mt-4">Taille</label>
      <select class="form-select" id="taille" name="taille">
        <option value="xs" <?=$articles['taille'] == 'xs'?'selected':"";?>>XS</option>
        <option value="s" <?=$articles['taille'] == 's'?'selected':"";?>>S</option>
        <option value="m" <?=$articles['taille'] == 'm'?'selected':"";?>>M</option>
        <option value="l" <?=$articles['taille'] == 'l'?'selected':"";?>>L</option>
        <option value="xl" <?=$articles['taille'] == 'xl'?'selected':"";?>>XL</option>
      </select>
    </div>
    <input type="text" name="ancienneImage" hidden value="<?=$articles['image']?>">
    <button type="submit" class="btn btn-primary mt-5">Modifier</button>
  </fieldset>
</form>



</div>
<?php

require_once ("../Inclusion/footer.php");
?>

