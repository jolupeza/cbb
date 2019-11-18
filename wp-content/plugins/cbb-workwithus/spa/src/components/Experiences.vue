<template>
  <section class="Experiences">
    <div class="container">
      <ValidationObserver ref="observer" tag="form" @submit.prevent="addExperience" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Experiencia Laboral</h3>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="institution">Institución: <span>(*)</span></label>
              <ValidationProvider name="institución" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="institution" name="institution" v-model="institution" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="job">Cargo: <span>(*)</span></label>
              <ValidationProvider name="cargo" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="job" name="job" v-model="job" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="dateStart">Fecha de inicio: <span>(*)</span></label>
              <ValidationProvider name="fecha de inicio" rules="required" v-slot="{ errors }">
                <input type="date" class="form-control" id="dateStart" name="date_start" v-model="dateStart" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="dateEnd">Fecha fin: <span>(*)</span></label>
              <ValidationProvider name="fecha fin" rules="required" v-slot="{ errors }">
                <input type="date" class="form-control" id="dateEnd" name="dateEnd" v-model="dateEnd" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="Experiences__buttons">
              <button class="WorkWithUs__button WorkWithUs__button--second" :disabled="!valid">Agregar +</button>
            </div>
          </div>
        </div>
      </ValidationObserver>

      <hr class="WorkWithUs__Separator">

      <ExperiencesList />

      <div class="WorkWithUs__buttons">
        <button type="button" class="WorkWithUs__button WorkWithUs__button--second" @click.prevent="goToStep(2)">Anterior</button>
        <button type="button" class="WorkWithUs__button WorkWithUs__button--first" :disabled="!hasExperiences" @click.prevent="goToStep(4)">Siguiente</button>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from 'vuex';
import ExperiencesList from '@/components/ExperiencesList';

export default {
  name: 'Experiences',

  components: {
    ExperiencesList
  },

  computed: {
    ...mapGetters({
      hasExperiences: 'applications/hasExperiences'
    })
  },

  data() {
    return {
      institution: '',
      job: '',
      dateStart: '',
      dateEnd: ''
    };
  },

  methods: {
    async addExperience() {
      const isValid = await this.$refs.observer.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'applications/setExperiences', {
        institution: this.institution,
        job: this.job,
        dateStart: this.dateStart,
        dateEnd: this.dateEnd
      }).then( () => {
        this.resetData();
        this.$refs.observer.reset();
      });
    },
    resetData() {
      this.institution = '';
      this.job = '';
      this.dateStart = '';
      this.dateEnd = '';
    },
    goToStep( step ) {
      this.$store.dispatch( 'setStep', step );
    }
  }
};
</script>

<style lang="scss" scoped>
  .Experiences {
    font-size: 16px;
    &__buttons {
      margin-top: 1.5em;
      text-align: right;
    }
  }
</style>
