<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>semaine </label>
          <input v-model="form.semaine" :class="errors.semaine?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.semaine" class="invalid-feedback">
            <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_date </label>
          <input v-model="form.dimanche_date" :class="errors.dimanche_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_date" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_date </label>
          <input v-model="form.lundi_date" :class="errors.lundi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_date" class="invalid-feedback">
            <template v-for=" error in errors.lundi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_date </label>
          <input v-model="form.mardi_date" :class="errors.mardi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_date" class="invalid-feedback">
            <template v-for=" error in errors.mardi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_date </label>
          <input v-model="form.mercredi_date" :class="errors.mercredi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_date" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_date </label>
          <input v-model="form.jeudi_date" :class="errors.jeudi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_date" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_date </label>
          <input v-model="form.vendredi_date" :class="errors.vendredi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_date" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_date </label>
          <input v-model="form.samedi_date" :class="errors.samedi_date?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_date" class="invalid-feedback">
            <template v-for=" error in errors.samedi_date"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_horaire </label>
          <input v-model="form.dimanche_horaire"
                 :class="errors.dimanche_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_horaire" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_horaire </label>
          <input v-model="form.lundi_horaire" :class="errors.lundi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.lundi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_horaire </label>
          <input v-model="form.mardi_horaire" :class="errors.mardi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.mardi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_horaire </label>
          <input v-model="form.mercredi_horaire"
                 :class="errors.mercredi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_horaire </label>
          <input v-model="form.jeudi_horaire" :class="errors.jeudi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_horaire </label>
          <input v-model="form.vendredi_horaire"
                 :class="errors.vendredi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_horaire </label>
          <input v-model="form.samedi_horaire" :class="errors.samedi_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_horaire" class="invalid-feedback">
            <template v-for=" error in errors.samedi_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche </label>
          <input v-model="form.dimanche" :class="errors.dimanche?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche" class="invalid-feedback">
            <template v-for=" error in errors.dimanche"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi </label>
          <input v-model="form.lundi" :class="errors.lundi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi" class="invalid-feedback">
            <template v-for=" error in errors.lundi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi </label>
          <input v-model="form.mardi" :class="errors.mardi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi" class="invalid-feedback">
            <template v-for=" error in errors.mardi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi </label>
          <input v-model="form.mercredi" :class="errors.mercredi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi" class="invalid-feedback">
            <template v-for=" error in errors.mercredi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi </label>
          <input v-model="form.jeudi" :class="errors.jeudi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi" class="invalid-feedback">
            <template v-for=" error in errors.jeudi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi </label>
          <input v-model="form.vendredi" :class="errors.vendredi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi" class="invalid-feedback">
            <template v-for=" error in errors.vendredi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi </label>
          <input v-model="form.samedi" :class="errors.samedi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi" class="invalid-feedback">
            <template v-for=" error in errors.samedi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_pointage </label>
          <input v-model="form.dimanche_pointage"
                 :class="errors.dimanche_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_pointage" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_pointage </label>
          <input v-model="form.lundi_pointage" :class="errors.lundi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.lundi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_pointage </label>
          <input v-model="form.mardi_pointage" :class="errors.mardi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.mardi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_pointage </label>
          <input v-model="form.mercredi_pointage"
                 :class="errors.mercredi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_pointage </label>
          <input v-model="form.jeudi_pointage" :class="errors.jeudi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_pointage </label>
          <input v-model="form.vendredi_pointage"
                 :class="errors.vendredi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_pointage </label>
          <input v-model="form.samedi_pointage" :class="errors.samedi_pointage?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_pointage" class="invalid-feedback">
            <template v-for=" error in errors.samedi_pointage"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_collecter </label>
          <input v-model="form.dimanche_collecter"
                 :class="errors.dimanche_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_collecter" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_collecter </label>
          <input v-model="form.lundi_collecter" :class="errors.lundi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.lundi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_collecter </label>
          <input v-model="form.mardi_collecter" :class="errors.mardi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.mardi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_collecter </label>
          <input v-model="form.mercredi_collecter"
                 :class="errors.mercredi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_collecter </label>
          <input v-model="form.jeudi_collecter" :class="errors.jeudi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_collecter </label>
          <input v-model="form.vendredi_collecter"
                 :class="errors.vendredi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_collecter </label>
          <input v-model="form.samedi_collecter"
                 :class="errors.samedi_collecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_collecter" class="invalid-feedback">
            <template v-for=" error in errors.samedi_collecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_depassement </label>
          <input v-model="form.dimanche_depassement"
                 :class="errors.dimanche_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_depassement" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_depassement </label>
          <input v-model="form.lundi_depassement"
                 :class="errors.lundi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.lundi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_depassement </label>
          <input v-model="form.mardi_depassement"
                 :class="errors.mardi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.mardi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_depassement </label>
          <input v-model="form.mercredi_depassement"
                 :class="errors.mercredi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_depassement </label>
          <input v-model="form.jeudi_depassement"
                 :class="errors.jeudi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_depassement </label>
          <input v-model="form.vendredi_depassement"
                 :class="errors.vendredi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_depassement </label>
          <input v-model="form.samedi_depassement"
                 :class="errors.samedi_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_depassement" class="invalid-feedback">
            <template v-for=" error in errors.samedi_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_programmer </label>
          <input v-model="form.dimanche_programmer"
                 :class="errors.dimanche_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_programmer" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_programmer </label>
          <input v-model="form.lundi_programmer"
                 :class="errors.lundi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.lundi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_programmer </label>
          <input v-model="form.mardi_programmer"
                 :class="errors.mardi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.mardi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_programmer </label>
          <input v-model="form.mercredi_programmer"
                 :class="errors.mercredi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_programmer </label>
          <input v-model="form.jeudi_programmer"
                 :class="errors.jeudi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_programmer </label>
          <input v-model="form.vendredi_programmer"
                 :class="errors.vendredi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_programmer </label>
          <input v-model="form.samedi_programmer"
                 :class="errors.samedi_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_programmer" class="invalid-feedback">
            <template v-for=" error in errors.samedi_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>dimanche_retard </label>
          <input v-model="form.dimanche_retard" :class="errors.dimanche_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche_retard" class="invalid-feedback">
            <template v-for=" error in errors.dimanche_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi_retard </label>
          <input v-model="form.lundi_retard" :class="errors.lundi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi_retard" class="invalid-feedback">
            <template v-for=" error in errors.lundi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi_retard </label>
          <input v-model="form.mardi_retard" :class="errors.mardi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi_retard" class="invalid-feedback">
            <template v-for=" error in errors.mardi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi_retard </label>
          <input v-model="form.mercredi_retard" :class="errors.mercredi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi_retard" class="invalid-feedback">
            <template v-for=" error in errors.mercredi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi_retard </label>
          <input v-model="form.jeudi_retard" :class="errors.jeudi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi_retard" class="invalid-feedback">
            <template v-for=" error in errors.jeudi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi_retard </label>
          <input v-model="form.vendredi_retard" :class="errors.vendredi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi_retard" class="invalid-feedback">
            <template v-for=" error in errors.vendredi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi_retard </label>
          <input v-model="form.samedi_retard" :class="errors.samedi_retard?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi_retard" class="invalid-feedback">
            <template v-for=" error in errors.samedi_retard"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>total_programmer </label>
          <input v-model="form.total_programmer"
                 :class="errors.total_programmer?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.total_programmer" class="invalid-feedback">
            <template v-for=" error in errors.total_programmer"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>total_colecter </label>
          <input v-model="form.total_colecter" :class="errors.total_colecter?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.total_colecter" class="invalid-feedback">
            <template v-for=" error in errors.total_colecter"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>total_depassement </label>
          <input v-model="form.total_depassement"
                 :class="errors.total_depassement?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.total_depassement" class="invalid-feedback">
            <template v-for=" error in errors.total_depassement"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs15 </label>
          <input v-model="form.hs15" :class="errors.hs15?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs15" class="invalid-feedback">
            <template v-for=" error in errors.hs15"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs26 </label>
          <input v-model="form.hs26" :class="errors.hs26?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs26" class="invalid-feedback">
            <template v-for=" error in errors.hs26"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs55 </label>
          <input v-model="form.hs55" :class="errors.hs55?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs55" class="invalid-feedback">
            <template v-for=" error in errors.hs55"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs30 </label>
          <input v-model="form.hs30" :class="errors.hs30?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs30" class="invalid-feedback">
            <template v-for=" error in errors.hs30"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs60 </label>
          <input v-model="form.hs60" :class="errors.hs60?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs60" class="invalid-feedback">
            <template v-for=" error in errors.hs60"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs115 </label>
          <input v-model="form.hs115" :class="errors.hs115?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs115" class="invalid-feedback">
            <template v-for=" error in errors.hs115"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>hs130 </label>
          <input v-model="form.hs130" :class="errors.hs130?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.hs130" class="invalid-feedback">
            <template v-for=" error in errors.hs130"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>total </label>
          <input v-model="form.total" :class="errors.total?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.total" class="invalid-feedback">
            <template v-for=" error in errors.total"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>programmations </label>
          <v-select
              v-model="form.programmation_id"
              :options="programmationsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.programmation_id" class="invalid-feedback">
            <template v-for=" error in errors.programmation_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>users </label>
          <v-select
              v-model="form.user_id"
              :options="usersData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.user_id" class="invalid-feedback">
            <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

          </div>
        </div>

      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'CreateVentilations',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'programmationsData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        semaine: "",

        dimanche_date: "",

        lundi_date: "",

        mardi_date: "",

        mercredi_date: "",

        jeudi_date: "",

        vendredi_date: "",

        samedi_date: "",

        dimanche_horaire: "",

        lundi_horaire: "",

        mardi_horaire: "",

        mercredi_horaire: "",

        jeudi_horaire: "",

        vendredi_horaire: "",

        samedi_horaire: "",

        dimanche: "",

        lundi: "",

        mardi: "",

        mercredi: "",

        jeudi: "",

        vendredi: "",

        samedi: "",

        dimanche_pointage: "",

        lundi_pointage: "",

        mardi_pointage: "",

        mercredi_pointage: "",

        jeudi_pointage: "",

        vendredi_pointage: "",

        samedi_pointage: "",

        dimanche_collecter: "",

        lundi_collecter: "",

        mardi_collecter: "",

        mercredi_collecter: "",

        jeudi_collecter: "",

        vendredi_collecter: "",

        samedi_collecter: "",

        dimanche_depassement: "",

        lundi_depassement: "",

        mardi_depassement: "",

        mercredi_depassement: "",

        jeudi_depassement: "",

        vendredi_depassement: "",

        samedi_depassement: "",

        dimanche_programmer: "",

        lundi_programmer: "",

        mardi_programmer: "",

        mercredi_programmer: "",

        jeudi_programmer: "",

        vendredi_programmer: "",

        samedi_programmer: "",

        dimanche_retard: "",

        lundi_retard: "",

        mardi_retard: "",

        mercredi_retard: "",

        jeudi_retard: "",

        vendredi_retard: "",

        samedi_retard: "",

        programmation_id: "",

        total_programmer: "",

        total_colecter: "",

        total_depassement: "",

        hs15: "",

        hs26: "",

        hs55: "",

        hs30: "",

        hs60: "",

        hs115: "",

        hs130: "",

        total: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/ventilations', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$emit('close')
        this.$toast.success('Operation effectuer avec succes')
        console.log(response.data)
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    resetForm() {
      this.form = {
        id: "",
        user_id: "",
        semaine: "",
        dimanche_date: "",
        lundi_date: "",
        mardi_date: "",
        mercredi_date: "",
        jeudi_date: "",
        vendredi_date: "",
        samedi_date: "",
        dimanche_horaire: "",
        lundi_horaire: "",
        mardi_horaire: "",
        mercredi_horaire: "",
        jeudi_horaire: "",
        vendredi_horaire: "",
        samedi_horaire: "",
        dimanche: "",
        lundi: "",
        mardi: "",
        mercredi: "",
        jeudi: "",
        vendredi: "",
        samedi: "",
        dimanche_pointage: "",
        lundi_pointage: "",
        mardi_pointage: "",
        mercredi_pointage: "",
        jeudi_pointage: "",
        vendredi_pointage: "",
        samedi_pointage: "",
        dimanche_collecter: "",
        lundi_collecter: "",
        mardi_collecter: "",
        mercredi_collecter: "",
        jeudi_collecter: "",
        vendredi_collecter: "",
        samedi_collecter: "",
        dimanche_depassement: "",
        lundi_depassement: "",
        mardi_depassement: "",
        mercredi_depassement: "",
        jeudi_depassement: "",
        vendredi_depassement: "",
        samedi_depassement: "",
        dimanche_programmer: "",
        lundi_programmer: "",
        mardi_programmer: "",
        mercredi_programmer: "",
        jeudi_programmer: "",
        vendredi_programmer: "",
        samedi_programmer: "",
        dimanche_retard: "",
        lundi_retard: "",
        mardi_retard: "",
        mercredi_retard: "",
        jeudi_retard: "",
        vendredi_retard: "",
        samedi_retard: "",
        programmation_id: "",
        total_programmer: "",
        total_colecter: "",
        total_depassement: "",
        hs15: "",
        hs26: "",
        hs55: "",
        hs30: "",
        hs60: "",
        hs115: "",
        hs130: "",
        total: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
