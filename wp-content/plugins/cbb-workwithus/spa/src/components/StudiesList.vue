<template>
  <section class="StudiesList">
    <table class="StudiesList__table">
      <thead>
        <tr>
          <th>N&deg;</th>
          <th>Carrera Profesional</th>
          <th>Institución</th>
<!--          <th>Grado</th>-->
          <th>Inicio</th>
          <th>Fin</th>
<!--          <th>Especialidad</th>-->
<!--          <th>Acción</th>-->
        </tr>
      </thead>
      <tbody v-if="studies.length > 0">
        <tr v-for="(item, index) in studies" :key="index">
          <td>{{ index + 1  }}</td>
          <td>{{ item.profession }}</td>
          <td>{{ item.institution }}</td>
          <td>{{ item.degree }}</td>
          <td>{{ item.dateStart }}</td>
          <td>{{ item.dateEnd }}</td>
<!--          <td>{{ item.specialty }}</td>-->
<!--          <td>botones</td>-->
        </tr>
      </tbody>
      <tbody v-else>
        <tr>
          <td colspan="8">No se encontraron registros</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'StudiesList',

  computed: {
    ...mapState( 'applications', {
      studies: state => state.studies
    })
  }
};
</script>

<style lang="scss" scoped>
  .StudiesList {
    font-size: 16px;
    margin-bottom: 2em;
    overflow-y: auto;
    &__table {
      width: 100%;
      th {
        color: $secondColorAlt;
        font-family: $fontSource;
        font-size: 1.125em;
        font-weight: 300;
        padding: 0.5em;
        text-align: center;
        text-transform: uppercase;
      }
      tbody {
        border: 1px solid $secondColorAlt;
        border-radius: 0.8em;
        padding: 0.5em;
        td {
          padding: 0.8em;
        }
      }
    }
  }
</style>
