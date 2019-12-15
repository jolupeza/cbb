<template>
  <section class="Studies">
    <div class="container">
      <ValidationObserver ref="observer" tag="form" @submit.prevent="addStudy" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Grados, títulos obtenidos o estudios completados</h3>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="profession">Carrera profesional: <span>(*)</span></label>
              <ValidationProvider name="carrera profesional" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="profession" name="profession" v-model="profession" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="institution">Institución: <span>(*)</span></label>
              <ValidationProvider name="institución" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="institution" name="institution" v-model="institution" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="degree">Grado Obtenido: <span>(*)</span></label>
              <ValidationProvider name="grado" rules="required" v-slot="{ errors }">
                <select name="degree" id="degree" v-model="degree" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option :value="item.id" v-for="item in degrees" :key="item.id">{{ item.name }}</option>
                </select>
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
            <div class="form-group">
              <label for="specialty">Especialidad: <span>(*)</span></label>
              <ValidationProvider name="especialidad" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="specialty" name="specialty" v-model="specialty" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>
        <!--<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="phone">Teléfono fijo:</label>
              <ValidationProvider name="teléfono fijo" rules="min:7" v-slot="{ errors }">
                <input type="text" class="form-control" id="phone" name="phone" v-model="phone" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mobile">Teléfono celular:</label>
              <ValidationProvider name="teléfono celular" rules="min:9" v-slot="{ errors }">
                <input type="text" class="form-control" id="mobile" name="mobile" v-model="mobile" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="email">Correo: <span>*</span></label>
              <ValidationProvider name="correo" rules="required|email" v-slot="{ errors }">
                <input type="email" class="form-control" id="email" name="email" v-model="email" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>-->
        <div class="Studies__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" :disabled="!valid">Agregar +</button>
        </div>
      </ValidationObserver>

      <hr class="WorkWithUs__Separator">

      <StudiesList />

      <div class="WorkWithUs__buttons">
        <button class="WorkWithUs__button WorkWithUs__button--second" @click.prevent="gotToStep(1)"><i class="fas fa-chevron-left"></i> Anterior</button>
        <button type="button" class="WorkWithUs__button WorkWithUs__button--first" :disabled="!hasStudies" @click.prevent="gotToStep(3)">Siguiente <i class="fas fa-chevron-right"></i></button>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import StudiesList from '@/components/StudiesList';

export default {
  name: 'Studies',

  components: {
    StudiesList
  },

  data() {
    return {
      profession: '',
      institution: '',
      degree: null,
      dateStart: '',
      dateEnd: '',
      specialty: ''
    };
  },

  computed: {
    ...mapState( 'applications', {
      levelId: state => state.levelId
    }),
    ...mapState( 'degrees', {
      degrees: state => state.all
    }),
    ...mapGetters({
      hasStudies: 'applications/hasStudies'
    })
  },

  created() {
    if ( 0 === this.degrees.length ) {
      this.$store.dispatch( 'degrees/retrieve', this.levelId );
    }
  },

  mounted() {
    this.$helpers.scrollToTop();
  },

  methods: {
    async addStudy() {
      const isValid = await this.$refs.observer.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'applications/setStudies', {
        profession: this.profession,
        institution: this.institution,
        degree: this.degree,
        dateStart: this.dateStart,
        dateEnd: this.dateEnd,
        specialty: this.specialty
      }).then( () => {
        this.resetData();
        this.$refs.observer.reset();
      });
    },
    resetData() {
      this.profession = '';
      this.institution = '';
      this.degree = null;
      this.dateStart = '';
      this.dateEnd = '';
      this.specialty = null;
      this.phone = '';
      this.mobile = '';
      this.email = '';
    },
    gotToStep( step ) {
      this.$store.dispatch( 'setStep', step );
    }
  }
};
</script>

<style lang="scss" scoped>
  .Studies {
    &__buttons {
      text-align: right;
    }
  }
</style>
