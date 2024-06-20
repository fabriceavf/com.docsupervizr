@extends('layouts/contentLayoutMaster')

@section('title', 'Contributions')

@section('content')
<div class="container">
    <div id="guideContribution">
        <h2 id="guide-de-contribution">Guide de Contribution</h2>
        <p>Pour contribuer efficacement au projet, veuillez respecter les points ci dessous:            </p>
        <ol>
            <li><strong>Clarté et Organisation</strong> : En suivant un processus structuré, vos contributions seront mieux organisées, plus faciles à comprendre et à intégrer.</li>
            <li><strong>Collaboration Efficace</strong> : Une communication claire et des pratiques de codage cohérentes facilitent la collaboration avec d&#39;autres développeurs.</li>
            <li><strong>Qualité du Code</strong> : L&#39;application des bonnes pratiques de développement et des tests rigoureux garantit un code de haute qualité et minimise les bugs.</li>
            <li><strong>Apprentissage et Croissance</strong> : En contribuant à un projet open source, vous acquérez de nouvelles compétences et vous élargissez votre expérience de développement.</li>
        </ol>
        <p>Voici les étapes et les directives pour contribuer efficacement :</p>
        <h4 id="1-fork-du-r-pertoire">1. Fork du Répertoire</h4>
        <ol>
            <li>Accédez au dépôt GitHub du projet.</li>
            <li>Cliquez sur le bouton &quot;Fork&quot; en haut à droite de la page pour créer une copie du dépôt sur votre compte GitHub.</li>
        </ol>
        <h4 id="2-cloner-le-d-p-t-fork-">2. Cloner le Dépôt Forké</h4>
        <p>Clonez le dépôt forké sur votre machine locale en utilisant Git :</p>
        <pre><code class="lang-sh">git clone http<span class="hljs-variable">s:</span>//github.<span class="hljs-keyword">com</span>/<span class="hljs-symbol">&lt;votre-utilisateur&gt;</span>/<span class="hljs-symbol">&lt;votre-depot-forke&gt;</span>.git
<span class="hljs-keyword">cd</span> <span class="hljs-symbol">&lt;votre-depot-forke&gt;</span>
</code></pre>
        <h4 id="3-cr-er-une-branche">3. Créer une Branche</h4>
        <p>Créez une nouvelle branche pour vos modifications. Utilisez un nom de branche descriptif pour indiquer ce sur quoi vous travaillez :</p>
        <pre><code class="lang-sh">git checkout -<span class="hljs-selector-tag">b</span> nom-de-votre-branche
</code></pre>
        <h4 id="4-effectuer-les-modifications">4. Effectuer les Modifications</h4>
        <p>Effectuez les modifications souhaitées dans le code. Assurez-vous de suivre les normes de codage et les bonnes pratiques du projet.</p>
        <h4 id="5-tester-les-modifications">5. Tester les Modifications</h4>
        <p>Avant de soumettre vos modifications, testez-les pour vous assurer qu&#39;elles fonctionnent correctement et qu&#39;elles n&#39;introduisent pas de bugs. Utilisez les tests unitaires et fonctionnels existants et ajoutez-en de nouveaux si nécessaire.</p>
        <h4 id="6-committer-les-modifications">6. Committer les Modifications</h4>
        <p>Committez vos modifications avec un message de commit clair et concis. Expliquez ce que vous avez changé et pourquoi.</p>
        <pre><code class="lang-sh">git <span class="hljs-keyword">add</span><span class="bash"> .
</span>git commit -m <span class="hljs-string">"Description claire de vos modifications"</span>
</code></pre>
        <h4 id="7-pousser-les-modifications">7. Pousser les Modifications</h4>
        <p>Poussez vos modifications vers votre dépôt forké sur GitHub :</p>
        <pre><code class="lang-sh">git <span class="hljs-built_in">push</span> <span class="hljs-built_in">origin</span> nom-de-votre-branche
</code></pre>
        <h4 id="8-cr-er-une-pull-request">8. Créer une Pull Request</h4>
        <ol>
            <li>Accédez à votre dépôt forké sur GitHub.</li>
            <li>Cliquez sur le bouton &quot;New Pull Request&quot;.</li>
            <li>Sélectionnez la branche que vous avez créée et comparez-la avec la branche principale du dépôt original.</li>
            <li>Cliquez sur &quot;Create Pull Request&quot; et fournissez une description détaillée de vos modifications et de leur objectif.</li>
        </ol>
        <h4 id="9-r-vision-de-la-pull-request">9. Révision de la Pull Request</h4>
        <p>Votre pull request sera révisée par les mainteneurs du projet. Vous pourriez recevoir des commentaires ou des demandes de modifications supplémentaires. Répondez aux commentaires et apportez les modifications nécessaires.</p>
        <h4 id="10-fusion-de-la-pull-request">10. Fusion de la Pull Request</h4>
        <p>Une fois que votre pull request est approuvée, elle sera fusionnée dans la branche principale du projet. Félicitations, vous avez contribué au projet !</p>
        <h3 id="bonnes-pratiques">Bonnes Pratiques</h3>
        <ul>
            <li><strong>Normes de Codage</strong> : Suivez les normes de codage définies dans le projet.</li>
            <li><strong>Commits Atomiques</strong> : Faites des commits atomiques qui contiennent des changements logiquement liés.</li>
            <li><strong>Documentation</strong> : Mettez à jour la documentation si vos modifications affectent les fonctionnalités ou l&#39;utilisation du projet.</li>
            <li><strong>Tests</strong> : Ajoutez des tests pour vos modifications pour assurer la qualité et la stabilité du code.</li>
        </ul>
        <p>Merci de contribuer à notre projet Laravel ! Votre aide est précieuse et nous apprécions vos efforts pour améliorer ce projet. Si vous avez des questions, n&#39;hésitez pas à nous contacter via les issues GitHub ou les canaux de communication du projet.</p>

    </div>
</div>
@vite("resources/views/content/Contributions/main.js")
@endsection
