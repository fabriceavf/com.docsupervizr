const puppeteer = require ('puppeteer');
let qs = require('querystring');

function delay(time) {
    return new Promise(function(resolve) {
        setTimeout(resolve, time)
    });
}

async function getData(page){
    const rawData = await page.evaluate(() => {
        let data = [];
        let table = document.getElementById('pointages');

        for (var i = 1; i < table.rows.length; i++) {
            let objCells = table.rows.item(i).cells;

            let values = [];
            for (var j = 0; j < objCells.length; j++) {
                let text = objCells.item(j).innerHTML;
                values.push(text);
            }
            let d = { i, values };
            data.push(d);
        }

        return data;
    });
    return rawData;
}
async function filtreSoumettre(page){

}
async function filtreChangeValue(page,cle,value){
    let data={'cle':cle, 'value':value}
    await  page.evaluate((data)=>{
        let element=document.querySelector(`input[name='${data.cle}']`)

        element.setAttribute('value',data.value)
    },data)
}
(async () => {
    // Launch the browser
    const browser = await puppeteer.launch({
        // headless:false,
        // args: [`--window-size=2040,1024`]
        args: ['--no-sandbox'],
    });
    // Create a page
    const page = await browser.newPage();

    await page.setRequestInterception(true);

    let query={}
    await page.setViewport({width: 2040, height: 1024});

    page.on('request', interceptedRequest => {
        if (interceptedRequest.isInterceptResolutionHandled()) return;
        if (interceptedRequest.url().includes('https://gabontech.teleric.net/filtres')){

            query=qs.parse(interceptedRequest.postData())
            query['colonnes[pointage][qrcode.matricule]']=0
            query['colonnes[pointage][type_span]']=0
            query['colonnes[pointage][telephone]']=0
            query['colonnes[pointage][code]']=0
            query['colonnes[pointage][evenements.site.nom]']=0
            query['colonnes[pointage][evenements.agent.nom]']=0
            query['colonnes[pointage][evenements.agent.prenom]']=0
            query['colonnes[pointage][evenements.label.libelle]']=0
            query['colonnes[pointage][id]']=0
            query['colonnes[pointage][jour]']=0
            query['colonnes[pointage][heure]']=0
            query['colonnes[pointage][timezone]']=0
            query['colonnes[pointage][ecart_span]']=0
            query['colonnes[pointage][data]']=0
            query['colonnes[pointage][android_pointeuse.select_option]']=0
            query['colonnes[pointage][smartphone_configuration.id]']=0
            query['colonnes[pointage][smartphone_configuration.mobile_marque_modele]']=0
            query['colonnes[pointage][smartphone_configuration.mobile_os]']=0
            query['colonnes[pointage][smartphone_configuration.mobile_os_version]']=0
            query['colonnes[pointage][smartphone_configuration.mobile_app_version]']=0
            query['colonnes[pointage][evenements.id]']=0
            query['colonnes[pointage][evenements.pointeuse_type]']=0
            query['colonnes[pointage][evenements.marqueur_type]']=0
            query['colonnes[pointage][evenements.site.client.nom]']=0
            query['colonnes[pointage][evenements.site.client.matricule]']=0
            query['colonnes[pointage][evenements.site.client.groupe.nom]']=0
            query['colonnes[pointage][evenements.site.client.entreprise.nom]']=0
            query['colonnes[pointage][evenements.site.client.etablissement.nom]']=0
            query['colonnes[pointage][evenements.site.client.secteur.nom]']=0
            query['colonnes[pointage][evenements.site.matricule]']=0
            query['colonnes[pointage][evenements.site.groupe.nom]']=0
            query['colonnes[pointage][evenements.site.entreprise.nom]']=0
            query['colonnes[pointage][evenements.site.etablissement.nom]']=0
            query['colonnes[pointage][evenements.site.secteur.nom]']=0
            query['colonnes[pointage][evenements.batiment.libelle]']=0
            query['colonnes[pointage][evenements.etage.libelle]']=0
            query['colonnes[pointage][evenements.local.libelle]']=0
            query['colonnes[pointage][evenements.agent.matricule]']=0
            query['colonnes[pointage][evenements.agent.groupe.nom]']=0
            query['colonnes[pointage][evenements.agent.entreprise.nom]']=0
            query['colonnes[pointage][evenements.agent.etablissement.nom]']=0
            query['colonnes[pointage][evenements.agent.secteur.nom]']=0
            query['colonnes[pointage][evenements.vehicule.marque]']=0
            query['colonnes[pointage][evenements.vehicule.modele]']=0
            query['colonnes[pointage][evenements.vehicule.matricule]']=0
            query['colonnes[pointage][evenements.objet.label.libelle]']=0
            query['colonnes[pointage][evenements.objet.libelle]']=0
            query['colonnes[pointage][evenements.objet.matricule]']=0
            query['colonnes[pointage][evenements.intervention_id]']=0
            query['colonnes[pointage][latitude]']=0
            query['colonnes[pointage][longitude]']=0
            query['colonnes[pointage][vitesse_kmh]']=0
            query['colonnes[pointage][cap_entity]']=0
            query['colonnes[pointage][information.batterie_span]']=0
            query['colonnes[pointage][information.signal_span]']=0
            let newData={
                'method':interceptedRequest.method(),
                'postData':qs.encode(query),
                'headers':{...interceptedRequest.headers()}
            }
            console.log('voici la request',qs.parse(interceptedRequest.postData()))
            interceptedRequest.continue(newData);
        }else{

            interceptedRequest.continue();
        }
    });
    await page.goto('https://gabontech.teleric.net/pointages');




    // Go to your site
    await page.goto('https://gabontech.teleric.net/pointages');

    if(page.url().includes('https://auth.teleric.net/')){
        let email=await page.$('#email')
        let password=await page.$('#password')
        let submit=await page.$('#submit')
        await email.type('supervizr@gabontech.com',{delay:20})
        await delay(2000)
        await password.type('dev-2023',{delay:20})

        await delay(3000)
        await submit.evaluate(b => b.click());

        await delay(3000)
        await page.goto('https://gabontech.teleric.net/pointages?limit=500')
     }
    await page.goto('https://gabontech.teleric.net/pointages?limit=500')

    await filtreChangeValue(page,'filtres[pointage][dstart]',"2022-02-01")

    console.log('jai fini de modifier')

    let formulaire=await page.$("form[action='https://gabontech.teleric.net/filtres'] button[type='submit']")
    await delay(3000)
    await formulaire.evaluate(b => b.click());
    await delay(10000)


    let next=1
    let i=0
    while(next==1){
        i++
        await page.goto('https://gabontech.teleric.net/pointages?limit=500&page='+i)
        let  rawData = await page.evaluate(() => {
            let data = [];
            let table = document.getElementById('pointages');

            for (var i = 1; i < table.rows.length; i++) {
                let objCells = table.rows.item(i).cells;

                let values = [];
                for (var j = 0; j < objCells.length; j++) {
                    let text = objCells.item(j).innerHTML;
                    values.push(text);
                }
                let d = { i, values };
                data.push(d);
            }

            console.log('test',data);
            fetch("https://pointages.sgs-gabon.com/api/pointages/action?action=savepointage", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({'pointages_robot':data})})
                .then(response => {
                    return response.text();
                })
                .then(function(data) {
                // console.log(data); // this will be a string
                console.log('voici la reponse du serveur',data);
                })

            return data;
        });
        console.log(`voici les donnees de la page ${i} `,rawData.length,rawData[0]);
        if(rawData.length==0){
            console.log(`il ya plus de donne  `);
            next=0


        }else{




        }

    }































})();
