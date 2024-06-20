@extends('layouts/contentLayoutMaster')

@section('title', 'Basesdedonnees')

@section('content')


    <div class="container">
        <div>
            <p>Cette section de la documentation expose et explique les procédés utilisés pour enrichir, organiser et segmenter notre base de données. Trois principales techniques sont utilisées : la class, les models et les façades DB</p>
            <h2 id="exemple-d-utilisation-lecture-cr-ation-mise-jour-et-suppression">Exemple d&#39;utilisation : Lecture, Création, Mise à jour et Suppression</h2>
            <h3 id="lecture-des-donn-es">Lecture des données</h3>
            <ol>
                <li><strong>Initialiser l&#39;objet <code>DatabaseDto</code></strong></li>
                <li><strong>Configurer les détails de la base de données</strong></li>
                <li><strong>Ajouter des conditions de recherche</strong></li>
                <li><strong>Lire les données</strong></li>
            </ol>
            <pre><code class="lang-php"><span class="hljs-comment">// Initialiser l'objet DatabaseDto</span>
$dto = DatabaseManager::getDto();

<span class="hljs-comment">// Configurer les détails de la base de données</span>
$dto = DatabaseManager::setDbHost($dto, <span class="hljs-string">'localhost'</span>);
$dto = DatabaseManager::setDbName($dto, <span class="hljs-string">'my_database'</span>);
$dto = DatabaseManager::setDbUser($dto, <span class="hljs-string">'root'</span>);
$dto = DatabaseManager::setDbPass($dto, <span class="hljs-string">'password'</span>);
$dto = DatabaseManager::setTable($dto, <span class="hljs-string">'users'</span>);

<span class="hljs-comment">// Ajouter des conditions de recherche</span>
$dto = DatabaseManager::addWhere($dto, <span class="hljs-string">'id'</span>, <span class="hljs-string">'='</span>, <span class="hljs-string">'1'</span>);
$dto = DatabaseManager::addLimit($dto, <span class="hljs-number">1</span>);
$dto = DatabaseManager::addOffset($dto, <span class="hljs-number">0</span>);

<span class="hljs-comment">// Lire les données</span>
$result = DatabaseManager::read($dto, [<span class="hljs-string">'id'</span>, <span class="hljs-string">'name'</span>, <span class="hljs-string">'email'</span>]);
print_r($result-&gt;result);
</code></pre>
            <h3 id="cr-ation-des-donn-es">Création des données</h3>
            <ol>
                <li><strong>Initialiser l&#39;objet <code>DatabaseDto</code></strong></li>
                <li><strong>Configurer les détails de la base de données</strong></li>
                <li><strong>Configurer la table cible</strong></li>
                <li><strong>Créer une nouvelle entrée</strong></li>
            </ol>
            <pre><code class="lang-php"><span class="hljs-comment">// Initialiser l'objet DatabaseDto</span>
$dto = DatabaseManager::getDto();

<span class="hljs-comment">// Configurer les détails de la base de données</span>
$dto = DatabaseManager::setDbHost($dto, <span class="hljs-string">'localhost'</span>);
$dto = DatabaseManager::setDbName($dto, <span class="hljs-string">'my_database'</span>);
$dto = DatabaseManager::setDbUser($dto, <span class="hljs-string">'root'</span>);
$dto = DatabaseManager::setDbPass($dto, <span class="hljs-string">'password'</span>);
$dto = DatabaseManager::setTable($dto, <span class="hljs-string">'users'</span>);

<span class="hljs-comment">// Créer une nouvelle entrée</span>
$payload = [
    <span class="hljs-string">'name'</span> =&gt; <span class="hljs-string">'John Doe'</span>,
    <span class="hljs-string">'email'</span> =&gt; <span class="hljs-string">'john@example.com'</span>
];
$dto = DatabaseManager::create($dto, $payload);
print_r($dto-&gt;result);
</code></pre>
            <h3 id="mise-jour-des-donn-es">Mise à jour des données</h3>
            <ol>
                <li><strong>Initialiser l&#39;objet <code>DatabaseDto</code></strong></li>
                <li><strong>Configurer les détails de la base de données</strong></li>
                <li><strong>Ajouter des conditions de mise à jour</strong></li>
                <li><strong>Mettre à jour les données</strong></li>
            </ol>
            <pre><code class="lang-php"><span class="hljs-comment">// Initialiser l'objet DatabaseDto</span>
$dto = DatabaseManager::getDto();

<span class="hljs-comment">// Configurer les détails de la base de données</span>
$dto = DatabaseManager::setDbHost($dto, <span class="hljs-string">'localhost'</span>);
$dto = DatabaseManager::setDbName($dto, <span class="hljs-string">'my_database'</span>);
$dto = DatabaseManager::setDbUser($dto, <span class="hljs-string">'root'</span>);
$dto = DatabaseManager::setDbPass($dto, <span class="hljs-string">'password'</span>);
$dto = DatabaseManager::setTable($dto, <span class="hljs-string">'users'</span>);

<span class="hljs-comment">// Ajouter des conditions de mise à jour</span>
$dto = DatabaseManager::addWhere($dto, <span class="hljs-string">'id'</span>, <span class="hljs-string">'='</span>, <span class="hljs-string">'1'</span>);

<span class="hljs-comment">// Mettre à jour les données</span>
$payload = [
    <span class="hljs-string">'name'</span> =&gt; <span class="hljs-string">'Jane Doe'</span>
];
$dto = DatabaseManager::update($dto, $payload);
print_r($dto-&gt;result);
</code></pre>
            <h3 id="suppression-des-donn-es">Suppression des données</h3>
            <ol>
                <li><strong>Initialiser l&#39;objet <code>DatabaseDto</code></strong></li>
                <li><strong>Configurer les détails de la base de données</strong></li>
                <li><strong>Ajouter des conditions de suppression</strong></li>
                <li><strong>Supprimer les données</strong></li>
            </ol>
            <pre><code class="lang-php"><span class="hljs-comment">// Initialiser l'objet DatabaseDto</span>
$dto = DatabaseManager::getDto();

<span class="hljs-comment">// Configurer les détails de la base de données</span>
$dto = DatabaseManager::setDbHost($dto, <span class="hljs-string">'localhost'</span>);
$dto = DatabaseManager::setDbName($dto, <span class="hljs-string">'my_database'</span>);
$dto = DatabaseManager::setDbUser($dto, <span class="hljs-string">'root'</span>);
$dto = DatabaseManager::setDbPass($dto, <span class="hljs-string">'password'</span>);
$dto = DatabaseManager::setTable($dto, <span class="hljs-string">'users'</span>);

<span class="hljs-comment">// Ajouter des conditions de suppression</span>
$dto = DatabaseManager::addWhere($dto, <span class="hljs-string">'id'</span>, <span class="hljs-string">'='</span>, <span class="hljs-string">'1'</span>);

<span class="hljs-comment">// Supprimer les données</span>
$dto = DatabaseManager::delete($dto);
print_r($dto-&gt;result);
</code></pre>
            <p>Cette documentation inclut maintenant des exemples complets pour les cas d&#39;utilisation de la lecture, la création, la mise à jour et la suppression des données à l&#39;aide de la classe <code>DatabaseManager</code>.</p>

        </div>
    </div>
    @vite("resources/views/content/Basesdedonnees/main.js")
@endsection
