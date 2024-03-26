<!doctype html>
<html lang="fr">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Premier site en PHP : site avec la BDD entreprise">
<meta name="author" content="Sahar ferchichi">
<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<title>CRUD - entreprise</title>
</head>

<body>
<header>
<div class="p-5 mb-4" style="background-color: #EEA545">
<section class="container py-5">
    <h1 class="fw-bold">CRUD</h1>
    <p class="col-md-8 fs-4">Dans cette page on vas réaliser un CRUD complet, on va utiliser la BDD entreprise</p>
    
</section>

</div>
</header>
<main class="container">
<?php

//////Fonction debugage//////

function debug($var) {
echo '<pre class="border border-dark bg-light text-primary w-50 p-3">';
var_dump($var);

echo '</pre>';

}
?>

<h2 class="text-danger my-5">1- Connexion à la BDD</h2> 
<!-- BDD -> Base de Donnée -->

<?php

///////// Conexxion à la BDD /////////

/**
 * On va utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'éxécuter des requêtes SQL.
 * Pour se connecter à la BDD avec PDO, il faut créer une instance de cet objet (PDO) qui représente une connexion à la BDD, pour cela il faut se  servir du constructeur  de la classe.
 * Ce constructeur demande certains paramètres
 */

//$pdo = new PDO("mysql:host=localhost;dbname=entreprise;charset=utf8", "root", "");
//on déclare des constantes d'environnement qui vont contenir les informations à la connexion à le BDO

//Déclarer une constante, toujours en MAJUSCULE

//Constante du serveur => localhost
define("DBHOST", "localhost");
//Constante de l'utilisateur de le BDO du serveur en local => root
define("DBUSER", "root");
//Constante pour le mot de passe de serveur en local => pas de mot de passe 
define("DBPASS","");
//Constante pour le nom de la BDD
define("DBNAME","db_entreprise");

// DSN (Date Source Name)
$dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8";

try{ // dans le try on vas instancier PDO , c'est creer un objet de la classe PDO

$pdo = new PDO($dsn, DBUSER, DBPASS);


//On définit le mode d'erreur de PDO sur Exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//$methods = get_class_methods('PDO');
//debug($methods);



echo "je suis connecté";


}
catch(PDOException $e){ // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objet de la  classe en question qui va stocker cette erreur

die($e->getMessage()); // die permet d'arreter le PHP et d'afficher une erreur en utilisant la méthode getMessage de l'objet $e


} // le cacth sera exécuter dès lors on auras un problème dans le try


?>

<h2 class="text-danger my-5"> 2- Requête d'insertion</2>
<?php


            /////Requête d'insertion/////

        // on va insérer un employé en BDD : la méthode exec(), exécute une requête sql et retourne le nombre de ligne affectéé, elle est utiliser pour faire des requêtes qui nous retournent pas de jeu de résultat : INSERT, UPDATE, DELETE
        

    //     $requete = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) 
    //                         VALUES('Assia', 'Béchichi', 'f', 'informatique', '2024-01-25', 3200)");

    // debug($requete);
    // echo "employé assia est bien inséré dans la BDD <br>";   

    // echo "Dernier ID généré en BDD : ". $pdo->lastInsertId();




?>

<h2 class="text-danger my-5"> 3- Requête de supression</h2>

<?php
            ////////////requête de supression///////////////
            // supprimer Assia de la BDD

            // $requete = $pdo->exec("DELETE FROM employes WHERE prenom = 'Assia'");
            // echo "Employé Assia est bien supprimé de la BBD entreprise"

?>

<h2 class="text-danger my-5"> 3-Requête affichage</h2>

<?php

            ///////////Requête d'affichage/////////

            //On vas utiliser la méthode query() : au contraire d'exec(), query() est utilisé pour faire des requêtes qui retournent un ou plusieurs resultats : SELECT. On peut aussi l'utiliser avec INSERT ? DELETE, UPDATE

            /**
             * valeur de retour : 
             *        succès : query() retoune un nouvel objet de la classde PDOStatement
             *        echec : False
             */

             ///////////Récuparation et affichage d'une seule données de la BDD //////////

             // On va selectionner les information de l'employé 

            $request = $pdo->query("SELECT * FROM employes WHERE prenom= 'Daniel'");


            debug($request);
            debug($request->rowCount());

            $employe = $request->fetch();
            debug($employe);

            echo "<p class='alert alert-secondary'>Je suis {$employe['prenom']} {$employe['nom']} du service {$employe['service']};</p>";
            
            

            //Exercice : 
            //afficher l'employé dont l'id est 417

            $request = $pdo->query("SELECT * FROM employes WHERE id_employes= 417");

            $employe = $request->fetch();
            debug($employe);

            echo "<p class='alert alert-secondary'>Je suis {$employe['prenom']} {$employe['nom']} du service {$employe['service']};</p>";


            ///////Récupération et affichage de plusieurs données de la BDD///////

            $request = $pdo->query('SELECT * FROM employes');

            //debug($request->rowCount());
            //$employes = $request->fetch();

            echo '<div class="row">';
                while($employes = $request->fetch()) {
                    echo '<div class="col-sm-12 col-md-3">';
                    echo "<div>id_employes : $employes[id_employes]</div>";
                    echo "<div>Nom et Prénom : $employes[nom] $employes[prenom]</div>";
                    echo "<div>service : $employes[service]</div>";
                    echo "<div>salaire : $employes[salaire]</div>";
                    echo"<hr>";
            echo'</div>';

                }

            echo '</div>';

            //Exercice :
            // Vous affichez la liste des différents services dans une liste, en mettant un service 

            $request = $pdo->query('SELECT DISTINCT service FROM employes');

            //$services = $request->fetch();
            //debug($services);
            // Pas necessaire de la déclarer à l'extérieur, on peut créer directement la variable dans la boucle while

            echo '<ul class="alert alert-warning">Les services';
            while($services = $request->fetch()) {
                echo "<li>$services[service]</li>";

            }
            echo '</ul>';


            // Je veux récupérer les différents salaires dans la tables employés 

            $request = $pdo->query('SELECT DISTINCT salaire FROM employes ORDER BY salaire DESC');
            // debug($request);
            // debug($request->rowCount());

            $salaires = $request->fetchAll(); // fetchAll() récupère tout les résultats dans la requête et les sort sous forme d'un tableau à 2 dimensions
            // j'ai creer la variable $salaires , pour récupérer la requête, et j'ai utliser la méthode fetchAll , qui va transformer mon résultat sous forme de tableau

            debug($salaires); // ici ont récupère un tableau multidimentionnel

            echo "<p>Liste des différents salaires dans la table employes</p>";

            echo '<ul>';

                foreach ($salaires as $key => $value) { // On utilsera plustôt  la syntaxe suivante ($salaire as $valeur)
                        echo "<li> $value[salaire]</li>";
                        //echo "<li> {$salaires[$key]['salaire']}</li>"; 2 eme méthode 
                }

            echo '</ul>';



            // Vous affichez les employés femme et qui gagnent un salaire supérieur ou égale à 2000 

            $request = $pdo->query("SELECT * FROM employes WHERE sexe ='f' AND salaire >= 2000");
            //On creer une variable $request pour stocker le resulat de ma requête,
            // avec l'objet $pdo qui creer la conexion, je  récupère  donc la conexion de la base de données
            //grâce à la flêche -> j'appel la méthode query qui va nous permettre de parcourir la table

            $salaireFemme = $request->fetchAll(); // FetchALL à utiliser dans la boucle foreach
            //debug($request->rowCount());
            //debug($salaireFemme);
            // Penser à mettre en commentaire les debugs 

            echo '<ul>';
                //while($salaireFemme = $request->fetch()) { // A utiliser avec fetch et non fetchAll
                    //echo "<li>Prenom: $salaireFemme[prenom]</li>";

                    //Utiliser debug fetch dans la  boucle while 

                //}

                foreach($salaireFemme as $valeur) {
                    echo "<li>Je suis $valeur[prenom] $valeur[nom] de sexe $valeur[sexe] et je gagne $valeur[salaire]</li>";
                }

            echo '</ul>';

?>

<h3 class="text-sucess mb-5">Les employés de notre entreprise embauchés à partir de 2010</h3>


<table class="table table-dark table-striped">
    <thead>
        <tr>
        <th>ID</th>
        <th>Prenom</th>
        <th>Nom</th>
        <th>Sexe</th>
        <th>Service</th>
        <th>Date d'embauche</th>
        <th>Salaire</th>

        </tr>
    </thead>
    
<?php

//////////////////Afficher les résultats de la requête dans une table HTML//////////
$request = $pdo->query("SELECT * FROM employes WHERE date_embauche > '2010-01-01'");    
//debug($request);


        
        while($employes= $request->fetch()) { // il boucle sur la première ligne, jusqu'a la fin du tableau
            echo'<tr>';
                echo "<td>$employes[id_employes]</td>";
                echo "<td>$employes[prenom]</td>";
                echo "<td>$employes[nom]</td>";
                echo"<td>";
                echo($employes['sexe']== 'f')? 'Femme' : 'Homme'; // Condition ternaire sur 1 ligne, le ? si c'est true et : si c'est false 
                echo"</td>";
                //On peut également faire une condition : 
                //if ( $employes['sexe'] == 'f') {
                    // echo "<td>Femme</td>;
                //}else{
                    //echo "<td>Homme</td>";
                //}
                    // 
                echo "<td>$employes[service]</td>";
                echo "<td>";
                echo date('d/m/Y',strtotime($employes['date_embauche'])); // les fonctions pour le changement de format, pour l'année avec 4 chiffres, c'est Y en majuscule
                echo "</td>";
                echo "<td>$employes[salaire]</td>";
            echo'</tr>';  
            }
                

?>
</table>

<h2 class="text-danger my-5">5- requete de modification</h2>

<?php

                                 ///////////////Requête de modification //////////

    // On va augmenter le salaire de Julien de 100€

    //exec() fonction ou méthod de l'orienté objet
   // $request = $pdo->exec("UPDATE employes SET salaire = salaire + 100 WHERE prenom='Julien'");
    //debug($request);
    //Ne pas oublier de commenter le  code afin d'éviter que le salaire de Julien n'augmente à chaque fois

    echo"<p class='alert alert-secondary'>Le salaire de l'employé Julien a bien été augmenter de 100€</p>";

    // On peur fiare la même chose  avec un query(), On va diminuer le salaire de l'employé qui à l'ID 350

   // $request = $pdo->query('UPDATE employes SET salaire = salaire - 200 WHERE id_employes = 350');
    //debug($request);

    //Ne pas oublier de commenter le  code afin d'éviter que le salaire de Jean-Pierre ne diminue pas  à chaque fois

    echo"<p class='alert alert-secondary'>Le salaire de l'employé Jean-Pierre a bien été diminuer de 200€</p>";


?>

<h3 class="mt-5">Requête préparés avec bindParam()</h3>

<?php
//On prépare la requête :

$request = $pdo->prepare("SELECT * FROM employes WHERE prenom = :prenom");
//prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur ":prenom" qui est vide et attend une valeur

//debug($request->rowCount());

// 2- On lie le marqueur à la variable $prenom

$prenom = 'Damien';

$request->bindParam(':prenom', $prenom);
//bindParam() permet de lier le marqueur à la variable $prenom, cette méthode ne reçoit qu'une variable , on ne peut pas y mettre une valeur fixe comme 'Damien' par exemple

//Si vous voulez lier le marqueur à une valeur fixe, alors il faut utiliser la méthode bindValue()
//exempple : 
//$request->bindValue(':nom', 'Damien');

// 3- On exécute la requête 
$request->execute();
//execute() permet d'éxécuter toute la requête  préparéé avec prépare()
$employes =$request->fetch();
debug($employes);

//Autre façon pour déclarer des marqueurs dans une  requête préparée sans le bindParam()
$request = $pdo->prepare("SELECT * FROM employes WHERE prenom = :prenom AND nom = :nom");

$request->execute(
                    array(
                        ':prenom' => 'Julien',
                        ':nom' => 'Cottet'
                    )
);

$employe = $request->fetch();
debug($employes);

// Autre façon 
$request = $pdo->prepare("SELECT * FROM employes WHERE sexe = ? AND service = ?");

//On créer les variables 

$sexe = 'f';
$service = 'commercial';

$request->execute(
                array($sexe,$service)
);

while ($employes =$request->fetch()) {
        echo"<p class='alert alert-success'>L'employé $employes[prenom] de sexe $employes[sexe], travaille dans le service $employes[service]</p>";
}

?>

<h3 class="mt-5">Insertion en utilisant les requêtes préparées et les marqueurs</h3>

<?php

$request = $pdo->prepare("INSERT INTO employes (prenom, nom, sexe, service,  date_embauche, salaire)
                        VALUES (:prenom, :nom, :sexe, :service, :date_embauche, :salaire)");

$request->execute(
                    array(
                            ':prenom' => 'Julius',
                            ':nom' => 'Tolo',
                            ':sexe' => 'm',
                            ':service' => 'commercial',
                            ':date_embauche' => '2023-12-16',
                            ':salaire' => 2450
                    ));

                    

?>









</main>
<footer style=" background-color : #EEA545;">
<div class="container">




<hr>
<div class="row text-center">
    <div class="col-12">
        <p> &copy; Entreprise - <?= date('Y') ?></p>
    </div>
</div>
</div>
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>
</body>

</html>  