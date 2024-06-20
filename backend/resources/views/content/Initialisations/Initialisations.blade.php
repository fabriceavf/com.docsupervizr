@extends('layouts/contentLayoutMaster')

@section('title', 'Initialisations')

@section('content')
    <div class="container">
        <div id="initialisation">
            <h2 id="proc-dure-de-r-cup-ration-et-d-initialisation-d-un-projet-laravel">Procédure de Récupération et d&#39;Initialisation du projet</h2>
            <p>Cette procédure explique comment cloner et initialiser SUpervizr avec ou sans Docker sur des systèmes d&#39;exploitation Windows, Linux, et macOS.</p>
            <h3 id="pr-requis">Prérequis</h3>
            <p>Avant de commencer, vous avez deux options pour initialiser votre projet Laravel :</p>
            <ol>
                <li><strong>Initialisation sans Docker</strong></li>
                <li><strong>Initialisation avec Docker</strong></li>
            </ol>
            <p>Veuillez suivre les étapes appropriées en fonction de votre choix.</p>
            <h4 id="pr-requis-pour-l-initialisation-sans-docker">Prérequis pour l&#39;Initialisation sans Docker</h4>
            <ul>
                <li><strong>Git</strong> : Pour cloner le dépôt.</li>
                <li><strong>Node.js et npm</strong> : Pour gérer les dépendances JavaScript.</li>
                <li><strong>PHP</strong> : Version 8.2.0 ou supérieure.</li>
                <li><strong>Composer</strong> : Pour gérer les dépendances PHP.</li>
            </ul>
            <h4 id="pr-requis-pour-l-initialisation-avec-docker">Prérequis pour l&#39;Initialisation avec Docker</h4>
            <ul>
                <li><strong>Docker</strong> : Pour la conteneurisation.</li>
                <li><strong>Git</strong> : Pour cloner le dépôt.</li>
            </ul>
            <h3 id="-tapes-g-n-rales-pour-tous">Étapes Générales pour Tous</h3>
            <ol>
                <li><strong>Cloner le Dépôt</strong></li>
            </ol>
            <h5 id="windows">Windows</h5>
            <ol>
                <li>Ouvrez Git Bash.</li>
                <li>Clonez le dépôt :<pre><code class="lang-sh">git <span class="hljs-keyword">clone</span> <span class="hljs-title">https</span>://<span class="hljs-tag">&lt;votre-utilisateur&gt;</span>:<span class="hljs-tag">&lt;votre-mot-de-passe&gt;</span>@votre-depot-prive.git
</code></pre>
                    <ul>
                        <li><strong>Avec une clé SSH</strong> :<pre><code class="lang-sh">git <span class="hljs-keyword">clone</span> <span class="hljs-title">git</span>@votre-depot-prive:votre-utilisateur/votre-projet.git
</code></pre>
                        </li>
                    </ul>
                </li>
            </ol>
            <h5 id="linux-macos">Linux &amp; macOS</h5>
            <ol>
                <li>Ouvrez le terminal.</li>
                <li><p>Clonez le dépôt :</p>
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
            <h3 id="initialisation-sans-docker">Initialisation sans Docker</h3>
            <p>Si vous souhaitez initialiser et exécuter le projet Laravel sans utiliser Docker, suivez les étapes ci-dessous :</p>
            <h4 id="1-installer-les-d-pendances-composer">1. Installer les Dépendances Composer</h4>
            <ol>
                <li>Assurez-vous d&#39;être dans le répertoire <code>backend</code> du projet :<pre><code class="lang-sh"><span class="hljs-built_in">cd</span> backend
</code></pre>
                </li>
                <li>Exécutez la commande suivante pour installer les dépendances PHP :<pre><code class="lang-sh">composer <span class="hljs-keyword">install</span>
</code></pre>
                    <ul>
                        <li>Cette commande télécharge et installe toutes les bibliothèques PHP nécessaires pour faire fonctionner l&#39;application Laravel.</li>
                    </ul>
                </li>
            </ol>
            <h4 id="2-configurer-les-variables-d-environnement">2. Configurer les Variables d&#39;Environnement</h4>
            <ol>
                <li>Copiez le fichier <code>.env.example</code> en <code>.env</code> :<pre><code class="lang-sh"><span class="hljs-selector-tag">cp</span> <span class="hljs-selector-class">.env</span><span class="hljs-selector-class">.example</span> <span class="hljs-selector-class">.env</span>
</code></pre>
                </li>
                <li>Ouvrez le fichier <code>.env</code> dans un éditeur de texte et modifiez les variables de configuration selon vos besoins (par exemple, les informations de la base de données).<ul>
                        <li>Le fichier <code>.env</code> contient les configurations spécifiques à votre environnement, telles que les informations de connexion à la base de données, les clés API, etc.</li>
                    </ul>
                </li>
            </ol>
            <h4 id="3-g-n-rer-la-cl-de-l-application">3. Générer la Clé de l&#39;Application</h4>
            <ol>
                <li>Exécutez la commande suivante pour générer une clé d&#39;application unique :<pre><code class="lang-sh">php artisan key:<span class="hljs-keyword">generate</span>
</code></pre>
                    <ul>
                        <li>Cette clé est utilisée pour sécuriser les données chiffrées dans l&#39;application.</li>
                    </ul>
                </li>
            </ol>
            <h4 id="4-installer-les-d-pendances-npm">4. Installer les Dépendances npm</h4>
            <ol>
                <li>Exécutez la commande suivante pour installer les dépendances JavaScript :<pre><code class="lang-sh">npm <span class="hljs-keyword">install</span>
</code></pre>
                    <ul>
                        <li>Cette commande télécharge et installe toutes les bibliothèques JavaScript nécessaires pour faire fonctionner les parties frontend de l&#39;application.</li>
                    </ul>
                </li>
            </ol>
            <h4 id="5-ex-cuter-le-serveur-de-d-veloppement">5. Exécuter le Serveur de Développement</h4>
            <ol>
                <li>Pour démarrer le serveur de développement Laravel, exécutez :<pre><code class="lang-sh"><span class="hljs-attribute">php artisan serve</span>
</code></pre>
                    <ul>
                        <li>Cette commande démarre un serveur web intégré qui héberge votre application.</li>
                    </ul>
                </li>
                <li>Ouvrez votre navigateur et naviguez vers <code>http://localhost:8000</code> pour voir votre application en cours d&#39;exécution.</li>
            </ol>
            <h3 id="initialisation-avec-docker">Initialisation avec Docker</h3>
            <p>Si vous préférez initialiser et exécuter le projet Laravel en utilisant Docker, suivez les étapes ci-dessous :</p>
            <h4 id="1-configurer-les-variables-d-environnement">1. Configurer les Variables d&#39;Environnement</h4>
            <ol>
                <li>Copiez le fichier <code>.env.example</code> en <code>.env</code> :<pre><code class="lang-sh"><span class="hljs-selector-tag">cp</span> <span class="hljs-selector-class">.env</span><span class="hljs-selector-class">.example</span> <span class="hljs-selector-class">.env</span>
</code></pre>
                </li>
                <li>Ouvrez le fichier <code>.env</code> dans un éditeur de texte et modifiez les variables de configuration selon vos besoins (par exemple, les informations de la base de données).<ul>
                        <li>Le fichier <code>.env</code> contient les configurations spécifiques à votre environnement, telles que les informations de connexion à la base de données, les clés API, etc.</li>
                    </ul>
                </li>
            </ol>
            <h4 id="2-d-marrer-les-conteneurs-docker">2. Démarrer les Conteneurs Docker</h4>
            <ol>
                <li>Assurez-vous que Docker est en cours d&#39;exécution sur votre machine.</li>
                <li>Dans le répertoire du projet, exécutez la commande suivante pour démarrer les conteneurs :<pre><code class="lang-sh">docker-compose <span class="hljs-_">-f</span> docker-compose.yml up <span class="hljs-_">-d</span>
</code></pre>
                    <ul>
                        <li>Cette commande construit et démarre les conteneurs définis dans le fichier <code>docker-compose.yml</code>. Les conteneurs incluent le serveur web, la base de données, et d&#39;autres services nécessaires pour faire fonctionner l&#39;application.</li>
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
            <h4 id="3-v-rifier-le-fonctionnement-de-l-application">3. Vérifier le Fonctionnement de l&#39;Application</h4>
            <ol>
                <li>Une fois les conteneurs démarrés, ouvrez votre navigateur et accédez à l&#39;adresse appropriée :<ul>
                        <li>Application : <code>http://localhost:8001</code></li>
                        <li>PhpMyAdmin : <code>http://localhost:8006</code></li>
                        <li>Si votre configuration utilise des ports spécifiques, utilisez l&#39;adresse et le port appropriés.</li>
                    </ul>
                </li>
                <li>Vérifiez que l&#39;application fonctionne correctement.</li>
            </ol>

            <p>En suivant ces étapes, vous pourrez cloner et initialiser un projet Laravel depuis un dépôt distant privé sur Windows, Linux, et macOS, avec ou sans Docker. Ces instructions sont conçues pour être claires même pour ceux qui ne sont pas des experts en développement.</p>

        </div>
    </div>
    @vite("resources/views/content/Initialisations/main.js")
@endsection
