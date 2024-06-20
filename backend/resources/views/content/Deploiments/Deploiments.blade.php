@extends('layouts/contentLayoutMaster')

@section('title', 'Deploiments')

@section('content')
<div class="container">
    <div id="deploiments">
        <h3 id="processus-de-d-ploiement-d-un-projet-laravel-sur-un-serveur-d-di-ovh-en-utilisant-filezilla">Processus de Déploiement d&#39;un Projet Laravel sur un Serveur Dédié OVH en Utilisant FileZilla</h3>
        <p>Cette section explique comment déployer Supervizr sur un serveur dédié OVH en utilisant FileZilla. Le processus consiste à transférer les fichiers de votre machine locale vers le serveur distant, puis à configurer et exécuter le projet sur le serveur.</p>
        <h4 id="pr-requis">Prérequis</h4>
        <p>Avant de commencer, assurez-vous d&#39;avoir les éléments suivants :</p>
        <ul>
            <li><strong>FileZilla</strong> : Un client FTP pour transférer des fichiers vers le serveur.</li>
            <li><strong>Accès SSH</strong> : Identifiants pour accéder au serveur distant.</li>
            <li><strong>Serveur Distant</strong> : Configuré avec Docker et Docker Compose.</li>
            <li><strong>Git</strong> : Pour cloner le dépôt sur votre machine locale.</li>
            <li><strong>Node.js et npm</strong> : Pour gérer les dépendances JavaScript sur votre machine locale.</li>
        </ul>
        <h3 id="-tapes-de-d-ploiement">Étapes de Déploiement :</h3>
        <h4 id="1-cloner-le-d-p-t-en-local">1. Cloner le Dépôt en Local</h4>
        <ol>
            <li>Ouvrez un terminal.</li>
            <li><p>Clonez le dépôt depuis le dépôt distant :</p>
                <pre><code class="lang-sh">git <span class="hljs-keyword">clone</span> <span class="hljs-title">https</span>://<span class="hljs-tag">&lt;votre-utilisateur&gt;</span>:<span class="hljs-tag">&lt;votre-mot-de-passe&gt;</span>@votre-depot-prive.git
</code></pre>
                <ul>
                    <li><strong>Avec une clé SSH</strong> :<pre><code class="lang-sh">git <span class="hljs-keyword">clone</span> <span class="hljs-title">git</span>@votre-depot-prive:votre-utilisateur/votre-projet.git
</code></pre>
                    </li>
                </ul>
            </li>
            <li><p>Naviguez vers le répertoire cloné :</p>
                <pre><code class="lang-sh"><span class="hljs-built_in">cd</span> votre-depot-prive
</code></pre>
            </li>
        </ol>
        <h4 id="2-pr-parer-les-fichiers-en-local">2. Préparer les Fichiers en Local</h4>
        <ol>
            <li><p>Installez les dépendances Composer :</p>
                <pre><code class="lang-sh"><span class="hljs-symbol">cd</span> <span class="hljs-keyword">backend
</span><span class="hljs-symbol">composer</span> install
</code></pre>
            </li>
            <li><p>Installez les dépendances npm :</p>
                <pre><code class="lang-sh">npm <span class="hljs-keyword">install</span>
</code></pre>
            </li>
            <li><p>Construisez les assets front-end pour la production :</p>
                <pre><code class="lang-sh">npm <span class="hljs-keyword">run</span><span class="bash"> production</span>
</code></pre>
            </li>
            <li><p>Copiez le fichier <code>.env.example</code> en <code>.env</code> :</p>
                <pre><code class="lang-sh"><span class="hljs-selector-tag">cp</span> <span class="hljs-selector-class">.env</span><span class="hljs-selector-class">.example</span> <span class="hljs-selector-class">.env</span>
</code></pre>
                <ul>
                    <li>Modifiez le fichier <code>.env</code> pour correspondre à votre configuration de production (par exemple, les informations de base de données).</li>
                </ul>
            </li>
            <li><p>Générez la clé d&#39;application :</p>
                <pre><code class="lang-sh">php artisan key:<span class="hljs-keyword">generate</span>
</code></pre>
            </li>
        </ol>
        <h4 id="3-transf-rer-les-fichiers-vers-le-serveur-avec-filezilla">3. Transférer les Fichiers vers le Serveur avec FileZilla</h4>
        <ol>
            <li>Ouvrez FileZilla.</li>
            <li>Connectez-vous à votre serveur distant en utilisant vos identifiants FTP/SFTP.</li>
            <li>Naviguez vers le répertoire cible sur le serveur où vous souhaitez déployer l&#39;application.</li>
            <li>Transférez tous les fichiers et dossiers de votre répertoire local vers le répertoire du serveur.</li>
        </ol>
        <h4 id="4-configurer-et-d-marrer-les-conteneurs-docker-sur-le-serveur">4. Configurer et Démarrer les Conteneurs Docker sur le Serveur</h4>
        <ol>
            <li>Connectez-vous à votre serveur distant via SSH (vous pouvez utiliser un terminal comme PuTTY pour Windows, ou un terminal natif sur Linux/macOS).</li>
            <li><p>Naviguez vers le répertoire de votre projet sur le serveur :</p>
                <pre><code class="lang-sh"><span class="hljs-keyword">cd</span> /chemin/<span class="hljs-keyword">vers</span>/votre-projet
</code></pre>
            </li>
            <li><p>Assurez-vous que Docker est installé sur le serveur. Vous pouvez vérifier cela avec la commande :</p>
                <pre><code class="lang-sh">docker <span class="hljs-comment">--version</span>
</code></pre>
            </li>
            <li><p>Assurez-vous que Docker Compose est installé sur le serveur. Vous pouvez vérifier cela avec la commande :</p>
                <pre><code class="lang-sh">docker-compose <span class="hljs-comment">--version</span>
</code></pre>
            </li>
            <li><p>Démarrez les conteneurs Docker définis dans le fichier <code>docker-compose.yml</code> :</p>
                <pre><code class="lang-sh">docker-compose <span class="hljs-_">-f</span> docker-compose.yml up <span class="hljs-_">-d</span>
</code></pre>
                <ul>
                    <li>Cette commande va construire les images Docker si elles ne sont pas déjà présentes et démarrer les conteneurs en arrière-plan.</li>
                    <li><strong>Ports Utilisés</strong> :<ul>
                            <li><code>application</code> : 8001 (HTTP), 5173 (port de développement)</li>
                            <li><code>phpmyadmin</code> : 8006</li>
                            <li><code>mariadb</code> : 3306</li>
                            <li><code>redis</code> : 6379 (port par défaut de Redis)</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ol>
        <h4 id="5-ex-cuter-les-migrations-et-les-seeders">5. Exécuter les Migrations et les Seeders</h4>
        <ol>
            <li>Une fois les conteneurs en cours d&#39;exécution, exécutez les migrations de la base de données pour configurer les schémas de tables. Exécutez la commande suivante dans le conteneur Laravel :<pre><code class="lang-sh">docker-compose <span class="hljs-keyword">exec</span> supervizr_application php artisan migrate --<span class="hljs-keyword">seed</span>
</code></pre>
                <ul>
                    <li>Cette commande exécute les migrations et les seeders pour initialiser la base de données.</li>
                </ul>
            </li>
        </ol>
        <h4 id="6-v-rifier-le-d-ploiement">6. Vérifier le Déploiement</h4>
        <ol>
            <li><p>Ouvrez votre navigateur et accédez à l&#39;adresse appropriée pour vérifier que l&#39;application fonctionne correctement :</p>
                <ul>
                    <li>Application : <code>http://&lt;votre-ip-de-serveur&gt;:8001</code></li>
                    <li>PhpMyAdmin : <code>http://&lt;votre-ip-de-serveur&gt;:8006</code></li>
                </ul>
            </li>
            <li><p>Vérifiez que toutes les pages et fonctionnalités de l&#39;application sont accessibles et fonctionnent comme prévu.</p>
            </li>
        </ol>

    </div>
</div>
@vite("resources/views/content/Deploiments/main.js")
@endsection
