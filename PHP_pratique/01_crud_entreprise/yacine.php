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

        /////////////// Fonction de débugage //////////////

        function debug($var) {
            echo '<pre class="border border-dark bg-light text-primary w-50 p-3">';
                var_dump($var);
            echo '</pre>';

    
        }
        ?>

        <h2 class="text-danger my-5">1- Connexion à la BDD</h2>

        <?php

        /////////////////// Connexion à la BDD ////////////////
        /**  
         * On vas utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'éxécuter des requêtes SQL.
         * Pour se connecter à la BDD avec PDO, il faut créer une instance de cet Objet (PDO) qui représente une connexion à la BDD, pour cela il faut se servir du constructeur de la clase.
         * Ce constructeur demande certains paramètres
         */

        // $pdo = new PDO("mysql:host=localhost;dbname=entreprise;charset=utf8", "root", "");
        // On déclare des constantes d'environnement qui vont contenir les informations à la connexion à la BDD

        // Constante du serveur => localhost
            define("DBHOST", "localhost");
        // Constante de l'utilisateur de la BDD du serveur en local => root
            define("DBUSER", "root");
        // Constante pour le mot de passe de serveur en local => pas de mot de passe
            define("DBPASS", "");
        // Constante pour le nom de la BDD
            define("DBNAME", "entreprise");
        
        // DSN (Data Source Name)
        $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8";

        try{ // dans le try on vas instancier PDO, c'est créer un objet de la class PDO 
            
        $pdo = new PDO($dsn, DBUSER, DBPASS);
        
        // On définit le mode d'erreur de PDO su Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // $methods = get_class_methods('PDO');

    // debug($methods);

        echo "Je suis connecté";
    
        }

        catch(PDOException $e){ // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objet de la classe en question qui vas stocker cette erreur

            die($e->getMessage()); // die permet d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getMessage de l'objet $e

        } // le catch sera exécuter dès lors on auras un problème dans le try

        ?>

        <h2 class="text-danger my-5">2- Requête d'insertion</h2>

        <?php

                ///////////////  Requête d'insertion ///////////////

                // On va insérer un employé en BDD : la méthode exec() exécute une requête SQL et retourne le nombre de ligne affectée, elle est utilisée pour faire des requêtes qui ne retournent pas de jeu de résultat : INSERT, UPDATE, DELETE

                // $request = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUE ('Assia', 'Béchichi', 'f', 'informatique', '2024-01-25', 3200)");

               // debug($request); // Affiche 1

                //echo "Employé Assia est bien insérer dans la BDD <br>";

                //echo "Dernier id généré en BDD : ". $pdo->lastInsertId();

        ?>
        <h2 class="text-danger my-5">3- Requête de suppression</h2>
        <?php

            ///////////////  Requête de suppression ///////////////////

            // Supprimer Assia de la BDD

            // $request = $pdo->exec("DELETE FROM employes WHERE prenom = 'Assia'");

            // echo "Employé Assia est bien supprimé de la BDD entreprise";

        ?>
        <h2 class="text-danger my-5">4- Requête d'affichage</h2>

        <?php

            ////////////// Requête d'affichage //////////////

            // On vas utiliser la méthode query() : au contraire d' exec(), query() est utilisé pour faire des requêtes qui retournent un ou plusieurs résultats : SELECT. On peut aussi l'utiliser avec INSERT, DELETE, UPDATE

            /**
             * Valeur de retour :
             *      succès : query() retourne un nouvel objet de la calsse PDOStatement
             *      echec : False
             */

            //////// Récupération et affichage d'une seule donnée de la BDD /////////////

            // On va selectionner les informations de l'employé "Daniel"

            $request = $pdo->query("SELECT * FROM employes WHERE prenom = 'Daniel'");
            debug($request);

            debug($request->rowCount());

            $employe = $request->fetch();

            debug($employe);

            echo "<p class='alert alert-secondary'>Je suis $employe[prenom] $employe[nom] du service $employe[service]</p>";


            //Exercice :
            //afficher l'employé dont l'id_employé est  417 .
            $request = $pdo->query("SELECT * FROM employes WHERE id_employes = 417");
            debug($request);

            // debug($request->rowCount());

            $employe = $request->fetch();

            debug($employe);

            echo "<p class='alert alert-secondary'>Je suis $employe[prenom] $employe[nom], j'ai l'identifiant $employe[id_employes] et viens du service $employe[service]</p>";

            ////////////// Récupération et affichage de plusieurs données de la BDD  //////////////

            $request = $pdo->query("SELECT * FROM employes");
            // debug($request->rowCount());
            // $employes = $request->fetch();
            
            echo '<div class="row">';

                while($employes = $request->fetch()) {
                    echo '<div class="col-sm-12 col-md-3">';
                        echo "<div>id_employes : $employes[id_employes]</div>";
                        echo "<div>Nom et Prénom : $employes[nom] $employes[prenom]</div>";
                        echo "<div>Le service : $employes[service]</div>";
                        echo "<div>le salaire : $employes[salaire]€</div>";
                        echo "<hr>";
                    echo '</div>';

                }

            echo '</div>';

            // Excercice :
            // Vous affichez la liste des différents services dans une liste, en mettant un service par <li>

            $request = $pdo->query("SELECT DISTINCT service FROM employes");
            
            echo "<ul>Les services";

                while ( $services = $request->fetch() ) {

                    echo "<li>$services[service]</li>";

                }

            echo "</ul>";

            // Je veux récupérer les différents salaires dans la table employes
            $request = $pdo->query("SELECT DISTINCT salaire FROM employes ORDER BY salaire DESC");

            // debug($request->rowCount());

             $salaires = $request->fetchAll(); // fetchAll() récupère tout les résultats dans la requête et les sort sous forme d'un tableau à 2 dimensions

             debug($salaires);

             echo "<p>Liste des différents salaires dans la table employes</p>";

             echo "<ul>";

                foreach ( $salaires as $valeur ) {

                    echo "<li> $valeur[salaire]</li>";
                    // echo "<li> {$salaires[$cle]['salaire']}</li>";


                }

             echo "</ul>";


             // Vous affichez les employés femmes et qui gagnent un salaire supèrieur ou égal à 2000€

             $request = $pdo->query("SELECT * FROM employes WHERE sexe = 'f' AND salaire >= 2000");
            // debug($request->rowCount());
             $salaireFemme = $request->fetchAll();
            //  debug($salaireFemme);

            echo "<ul>";
                
                    foreach ( $salaireFemme as $cle =>$valeur) {

                        echo "<li>Je suis $valeur[prenom] $valeur[nom] de sexe $valeur[sexe] et je gagne $valeur[salaire]</li>";
                        // echo "<li>Je suis {$salaireFemme[$cle]['prenom']} {$salaireFemme[$cle]['nom']} de sexe {$salaireFemme[$cle]['sexe']} et je gagne {$salaireFemme[$cle]['salaire']}</li>";


                    }



            echo "</ul>";

        ?>

        <h3 class="text-success mb-5">Les employés de notre entreprise embauchés à partir de 2010</h3>

        <?php

        ////// Afficher les résultats de la requête dans une table HTML ///////

        ?>
        <h5>Mèthode 1  : en PHP et avec une boucle while </h5>

        <?php   
                
        $request = $pdo->query("SELECT * FROM employes WHERE date_embauche >= '2010-01-01'");

        echo "<table class='table table-secondary table-bordered'>";
            echo"<tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Sexe</th>
                    <th>Service</th>
                    <th>Date d'embauche</th>
                    <th>Salaire</th>
                </tr>";


                while($employe = $request->fetch()){ 
                    echo"<tr>";
                        echo "<td>{$employe['id_employes']}</td>";
                        echo "<td>{$employe['prenom']}</td>";
                        echo "<td>{$employe['nom']}</td>";
                        echo "<td>";
                        echo ($employe['sexe']== 'f') ? 'Femme' : 'Homme';
                        echo"</td>";
                        echo "<td>{$employe['service']}</td>";
                        echo "<td>";
                        echo  date('d/m/y',strtotime($employe['date_embauche'])) ;
                        echo "</td>";
                        echo "<td>{$employe['salaire']}</td>";
                    echo"</tr>";
                }

        echo "</table>";

    ?>

    <h2 class="text-danger my-5">5- Requête de modification</h2>

    <?php

    ///////////////  Requête de modification ///////////////////

    // On va augmenter le salaire de Julien de 100€

    // $request = $pdo->exec("UPDATE employes SET salaire = salaire + 100 WHERE prenom = 'Julien'");

    // debug($request);

    echo "<p class='alert alert-secondary'>Le salaire de l'employé Julien a bien été augmenter de 100€</p>";
    
    // On peut faire la même chose avec un query(). On va diminuer le saliare de l'employé qui a l'identifiant 350

    // $request = $pdo->query("UPDATE employes SET salaire = salaire - 200 WHERE id_employes = 350");

    // debug($request->rowCount());

    echo "<p class='alert alert-secondary'>Le salaire de l'employé qui a l'identifiant 350 a bien été diminué de 200€</p>";

    ?>
    
    <h2 class="text-danger my-5">6- Requêtes préparés </h2>

    <p>Les requêtes préparés sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interprétation/ exécution de la requête (gain de performance). Les requêtes préparés sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL( ce que nous verrons dans un chapitre ultérieur) </p>
    <ul> Une requête préparé se réalise en trois étapes :
        <li>1- On prépare la requête</li>
        <li>2- On lie le marqueur à la requête</li>
        <li>3- On éxecute la requête</li>
    </ul>

    <h3 class="mt-5">Requête préparés avec bindParam()</h3>

    <?php
    // 1- On prépare la requête :
    $request = $pdo->prepare("SELECT * FROM employes WHERE prenom = :prenom");
    // prepare() est méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur ":prenom" qui est vide et attend une valeur

    // debug($request->rowCount());
    
    // 2- On lie le marqueur à la variable $prenom :
    $prenom = 'Damien';

    $request->bindParam(':prenom', $prenom);

    // bindParam() permet de lier le marqueur à la variable $prenom, cette méthode ne reçoit qu'une variable. On ne peut pas y mettre une valeur fixe comme 'Damien' par exemple
    //$request->bindParam(':nom', 'Damien'); // => ce n'est pas possible

    // Si vous voulez lier le marqueur à une valeur fixe, alors il faut utiliser la méthode bindValue()
    // exemple :
    // $request->bindValue(':nom', 'Damien');

    // 3- On exécute la requête
    $request->execute();
    // execute() permet d'exécuter toute la requête préparée avec prepare()

    $employe = $request->fetch();
    debug($employe);


    // Autre façon pour déclarer des marqueurs dans une requête préparé avec bindParam()


$request = $pdo->prepare("SELECT * FROM employes WHERE prenom = ? AND nom = ?");

$prenom = 'Damien';
$nom = 'Durand';

$request->bindParam(1, $prenom);
$request->bindParam(2, $nom);


$request->execute();

$employe = $request->fetch();
debug($employe);



?>

<h3 class="mt-5">Requête préparés sans bindParam()</h3>
<?php

    // Autre façon pour déclarer des marqueurs  dans une requête préparée sans bindParam()
    $request = $pdo->prepare("SELECT * FROM employes WHERE prenom = :prenom AND nom = :nom");

    $request->execute(
                        array(
                            ':prenom' => 'Julien',
                            ':nom' => 'Cottet'
                        )
    );

    $employe = $request->fetch();
    debug($employe);

    // Autre façon

    $request = $pdo->prepare("SELECT * FROM employes WHERE sexe = ? AND service = ?");

    $sexe = 'f';
    $service = 'commercial';

    $request->execute(
                    array($sexe, $service)
    );
    
    while ($employe = $request->fetch()) {

        echo "<p class='alert alert-success'>L'employé $employe[prenom] de sexe $employe[sexe], travaille dans le service  $employe[service]</p>";

    }
    

    ?> 

    <h3 class="mt-5">Insertion en utilisant les requêtes prépérées et les marqueurs</h3>

    <?php

    // $request = $pdo->prepare("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire)
    //                         VALUES (:prenom, :nom, :sexe, :service, :date_embauche, :salaire)");

    // $request->execute(
    //                     array(

    //                     ':prenom' => 'Julius',
    //                     ':nom' => 'TOLO',
    //                     ':sexe' => 'm',
    //                     ':service' => 'commercial',
    //                     ':date_embauche' => '2023-12-16',
    //                     ':salaire' => 2450
    //                 ));


    // Modification du salaire de l'employé Juluis

    $request = $pdo->prepare("UPDATE employes SET salaire = :salaire WHERE prenom = :prenom");

    $request->execute(
                        array(
                            ':prenom' => 'Julius',
                            ':salaire' => 2100
                        )
    );


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