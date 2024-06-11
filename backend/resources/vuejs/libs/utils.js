import moment from "moment";
import store from "@/store";
import axios from "@axios";

export default function traitePointage(pointage){
  let myPointage=pointage
  let volumeHsBase=0
  let volumeInFaction=0
  let debutPrevu=moment(myPointage.debut_prevu,'YYYY-MM-DD H:m:s')
  let finPrevu=moment(myPointage.fin_prevu,'YYYY-MM-DD H:m:s')
  let debutPrevuTimestamp=debutPrevu.unix()
  let limitJournaliereTimestamp=debutPrevuTimestamp+8*60*60
  let limitFaction=0;
  if(myPointage.faction_horaire=='Jour'){
    limitFaction=moment(myPointage.fin_prevu,'YYYY-MM-DD H:m:s').set({'hour': 21,'second':0,'minute':0})
  }
  else{
    limitFaction=moment(myPointage.fin_prevu,'YYYY-MM-DD H:m:s').set({'hour': 6,'second':0,'minute':0})
  }
  let hsInFaction=0;
  let hsHorsFaction=0;
  let hsBase=0;
  let hs=0;
  let volume_realiser=0
  if(myPointage.fin_realise && myPointage.debut_realise){
    volume_realiser=moment(myPointage.fin_realise,'YYYY-MM-DD H:m:s').unix()-moment(myPointage.debut_realise,'YYYY-MM-DD H:m:s').unix()
    let isHs=volume_realiser/3600 > 8
    hs=volume_realiser/3600 - 8
    volume_realiser=volume_realiser/3600
    if(hs<0){
      hs=0
    }
    if(isHs){
      try{
        let limit=limitFaction.unix()
        if(limitFaction.unix() > moment(myPointage.fin_realise,'YYYY-MM-DD H:m:s').unix()){
          limit= moment(myPointage.fin_realise,'YYYY-MM-DD H:m:s').unix()
        }
        hsInFaction=limit-(moment(myPointage.debut_realise,'YYYY-MM-DD H:m:s').unix() +(8*3600) )

        if(hsInFaction<0 ){
          hsInFaction=0
        }
        hsInFaction=hsInFaction/3600
      }catch (e) {}
    }
    if(isHs){
      try{
        // hsHorsFaction=volume realiser - les 8heure de base + les heures sup dans la faction
        hsHorsFaction = moment(myPointage.fin_realise,'YYYY-MM-DD H:m:s').unix() -limitFaction.unix()
        if(hsHorsFaction<0){
          hsHorsFaction=0
        }
        hsHorsFaction=hsHorsFaction/3600
      }catch (e) {}
    }
    if(isHs){
      try{
        hsBase=moment(myPointage.fin_prevu,'YYYY-MM-DD H:m:s').unix()-(moment(myPointage.debut_realise,'YYYY-MM-DD H:m:s').unix()+8*3600)
        if(hsBase<0){
          hsBase=0
        }
        hsBase=hsBase/3600
      }catch (e) {}
    }
  }
  if(hsInFaction>=hsBase){
    hsInFaction=hsInFaction-hsBase
  }
  let volume_prevu=0
  if(myPointage.fin_prevu && myPointage.debut_prevu){
    volume_prevu=moment(myPointage.fin_prevu,'YYYY-MM-DD H:m:s').unix()-moment(myPointage.debut_prevu,'YYYY-MM-DD H:m:s').unix()
    volume_prevu=volume_prevu / 3600
    if(volume_prevu<0){
      volume_prevu=0
    }


  }
  // console.log('voici le volume du pointage ',hs,hsBase,hsInFaction,hsHorsFaction)
  return {
    hs:Number((hs).toFixed(5)),
    hsBase:Number((hsBase).toFixed(5)),
    hsInFaction:Number((hsInFaction).toFixed(5)),
    hsHorsFaction:Number((hsHorsFaction).toFixed(5)),
    pointage:myPointage,
    vp:Number((volume_prevu).toFixed(5)),
    vr:Number((volume_realiser).toFixed(5))
  }
}


export async function traitePointage1(pointage){
  console.log('on veut traiter ce pointage la ===>',pointage,store.getters["general/pointages"])
  let myPointage={}
  // if(store.getters["general/pointages"][pointage]){
  if(false){

    myPointage=store.getters["general/pointages"][pointage]

    console.log('on veut traiter ce pointage la il as ete trouver ===>',myPointage)


  }
  else{
      myPointage= await axios.get('/api/pointages/id/' + pointage,{
      })
          .then(response => {
            let data={}
            if(Array.isArray(response.data) && response.data.length>=0){
              data = response.data[0]
            }else if(Array.isArray(response.data) && response.data.length == 0){
              data = {}
            }else{
              data = response.data
            }
            return data



          })
          .catch(error => {
            console.error(error)
            return {}
          });



    // console.log('on veut traiter ce pointage la il na pas ete trouver ===>',myPointage)
  }
  // console.log('on veut traiter ce pointage la et voici le resultat finial ===>',myPointage)
  // console.log('on veut traiter ce pointage la et la on va le mettre dans le store ===>',myPointage)
  // store.commit('general/setPointage',myPointage)
  // console.log('on veut traiter ce pointage la et la on as fini de la mettre dans le store ===>',store.getters["general/pointages"])


  return traitePointage(myPointage)


}
export async function getPointage(pointage){

  // console.log('voici le pointage 1 store ',id)


}
export function getPointageState(pointage){

    let etats = 'ABSCENCES';

    // console.log('voici le pointage a traiter =+>',pointage)
    if (pointage.totalReel == 0 && pointage.totalFictif == 0) {
        etats = 'ABSCENCESNONJUSTIFIER'
    } else if (pointage.totalReel == 0 && pointage.totalFictif >= 2) {
        etats = 'ABSCENCESJUSTIFIER'
    } else if (pointage.totalReel == 1 && pointage.totalFictif >= 1 && pointage.volume_horaire <= 8) {
        etats = 'INCOMPLETTRAITER'
    } else if (pointage.totalReel == 1 && pointage.totalFictif == 0) {
        etats = 'INCOMPLETNONTRAITER'
    } else if (pointage.volume_horaire > 8 && pointage.etats != 'REFUSER' && pointage.etats != 'ACCEPTER') {
        etats = 'DEPASSEMENTNONTRAITER'
    } else if (pointage.volume_horaire > 8 && pointage.etats == 'REFUSER') {
        etats = 'DEPASSEMENTREFUSER'
    } else if (pointage.volume_horaire > 8 && pointage.etats == 'ACCEPTER') {
        etats = 'DEPASSEMENTACCEPTER'
    } else {
        etats = 'NORMAL'
    }
    if(pointage.debut_prevu==pointage.fin_prevu){
        etats = 'REPOS'
    }
    return etats

}



