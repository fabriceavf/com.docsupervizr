<template>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">Semaine</th>
      <th scope="col">HN</th>
      <th scope="col">T HC</th>
      <th scope="col">T HS</th>
      <th scope="col">HS +15%</th>
      <th scope="col">HS +26%</th>
      <th scope="col">HS +55%</th>
      <th scope="col">HS +30%</th>
      <th scope="col">HS +115%</th>
      <th scope="col">HS +60%</th>
      <th scope="col">HS +130%</th>
      <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>{{ ventilation.semaine }}</td>
      <td>{{ formatHeure(ventilation.total_programmer) }}</td>
      <td>{{ formatHeure(ventilation.total_colecter) }}</td>
      <td>{{ formatHeure(ventilation.total_depassement) }}</td>
      <td>{{ formatHeure(ventilation.hs15) }}</td>
      <td>{{ formatHeure(ventilation.hs26) }}</td>
      <td>{{ formatHeure(ventilation.hs55) }}</td>
      <td>{{ formatHeure(ventilation.hs30) }}</td>
      <td>{{ formatHeure(ventilation.hs60) }}</td>
      <td>{{ formatHeure(ventilation.hs115) }}</td>
      <td>{{ formatHeure(ventilation.hs130) }}</td>
      <td>{{ formatHeure(ventilation.total) }}</td>
    </tr>
    </tbody>
  </table>
</template>

<script>

export default {
  name: 'ShowVentilation',
  props: ['data'],
  data() {
    return {
      errors: [],
      programmeForm: 'create',
      ventilation: []

    }
  },
  mounted() {
    this.ventilation = this.data[0]
  },
  methods: {
    formatHeure(row) {
      let heure = 0
      let minutes = 0
      if (row) {
        heure = Math.floor(row / 60)
        minutes = row % 60
      }
      const retour = heure + 'h ' + minutes + 'm'
      return retour
    }
  }
}
</script>
