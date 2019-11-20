<template>
  <section class="ExperiencesList">
    <table class="ExperiencesList__table">
      <thead>
        <tr>
          <th>N&deg;</th>
          <th>Institución</th>
          <th>Cargo</th>
          <th>Inicio</th>
          <th>Fin</th>
<!--          <th>Acción</th>-->
        </tr>
      </thead>
      <tbody v-if="experiences.length > 0">
        <tr v-for="(item, index) in experiences" :key="index">
          <td>{{ index + 1  }}</td>
          <td>{{ item.institution }}</td>
          <td>{{ item.job }}</td>
          <td>{{ item.dateStart }}</td>
          <td>{{ item.dateEnd }}</td>
<!--          <td>botones</td>-->
        </tr>
      </tbody>
      <tbody v-else>
        <tr>
          <td colspan="6">No se encontraron registros</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'ExperiencesList',

  computed: {
    ...mapState( 'applications', {
      experiences: state => state.experiences
    })
  }
};
</script>

<style lang="scss" scoped>
  .ExperiencesList {
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
