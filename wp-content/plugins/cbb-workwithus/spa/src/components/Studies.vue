<template>
  <section class="Studies">
    <div class="container">
      <ValidationObserver ref="observerStudies" tag="form" @submit.prevent="addStudy" v-slot="{ valid }">
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
        <div class="Studies__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" :disabled="!valid">Agregar +</button>
        </div>
      </ValidationObserver>

      <hr class="WorkWithUs__Separator" />

      <StudiesList />

      <hr class="WorkWithUs__Separator" />

      <ValidationObserver ref="observerExperiences" tag="form" @submit.prevent="addExperience" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Experiencia Laboral</h3>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="institutionJob">Institución: <span>(*)</span></label>
              <ValidationProvider name="institución" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="institutionJob" name="institutionJob" v-model="institutionJob" />
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
              <ValidationProvider name="fecha fin" :rules="{ required: !current }" v-slot="{ errors }">
                <input type="date" class="form-control" id="dateEnd" name="dateEnd" v-model="dateEnd" :disabled="current" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
              <div class="checkbox">
                <label><input type="checkbox" v-model="current" /> Actualmente</label>
              </div>
            </div>
          </div>
          <div class="col-sm-4"></div>
        </div>
        <div class="Experiences__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" :disabled="!valid">Agregar +</button>
        </div>
      </ValidationObserver>

      <hr class="WorkWithUs__Separator" />

      <ExperiencesList />

      <hr class="WorkWithUs__Separator" />

      <ValidationObserver ref="observerCv" tag="form" @submit.prevent="addApplication" v-slot="{ valid }">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="cv">Adjuntar tu CV es obligatorio: (Formatos válidos: DOC, DOCX y PDF)</label>
              <ValidationProvider name="CV" rules="required|mimes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf|size:3072" v-slot="{ validate, errors }">
                <input type="file" class="form-control" id="cv" name="cv" @change="handleCvChange($event) || validate($event)" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <Message />

        <div class="WorkWithUs__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" @click.prevent="gotToStep(1)"><i class="fas fa-chevron-left"></i> Anterior</button>
          <button v-show="hasStudies && hasExperiences" type="button" class="WorkWithUs__button WorkWithUs__button--first" :disabled="!valid" @click.prevent="addApplication()">Finalizar <i class="fas fa-check"></i></button>
        </div>
      </ValidationObserver>
    </div>

    <Modal />
  </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import StudiesList from '@/components/StudiesList';
import ExperiencesList from '@/components/ExperiencesList';
import Modal from '@/components/Modal';
import Message from '@/components/Message';

export default {
  name: 'Studies',

  components: {
    StudiesList,
    ExperiencesList,
    Modal,
    Message
  },

  data() {
    return {
      profession: '',
      institution: '',
      degree: null,
      institutionJob: '',
      job: '',
      dateStart: '',
      dateEnd: '',
      current: false,
      typesCv: [ 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf' ]
    };
  },

  computed: {
    ...mapState( 'applications', {
      areaId: state => state.areaId
    }),
    ...mapState( 'degrees', {
      degrees: state => state.all
    }),
    ...mapGetters({
      hasStudies: 'applications/hasStudies',
      hasExperiences: 'applications/hasExperiences'
    })
  },

  created() {
    if ( 0 === this.degrees.length ) {
      this.$store.dispatch( 'degrees/retrieve', this.areaId );
    }
  },

  mounted() {
    this.$helpers.scrollToTop();
  },

  methods: {
    async addStudy() {
      const isValid = await this.$refs.observerStudies.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'applications/setStudies', {
        profession: this.profession,
        institution: this.institution,
        degree: this.degree
      }).then( () => {
        this.resetDataStudies();
        this.$refs.observerStudies.reset();
      });
    },
    async addExperience() {
      const isValid = await this.$refs.observerExperiences.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'applications/setExperiences', {
        institution: this.institutionJob,
        job: this.job,
        dateStart: this.dateStart,
        dateEnd: this.current ? 'Actualmente' : this.dateEnd
      }).then( () => {
        this.resetDataExperiences();
        this.$refs.observerExperiences.reset();
      });
    },
    async addApplication() {
      const isValid = await this.$refs.observerCv.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'setModal', true );
    },
    resetDataStudies() {
      this.profession = '';
      this.institution = '';
      this.degree = null;
    },
    resetDataExperiences() {
      this.institutionJob = '';
      this.job = '';
      this.dateStart = '';
      this.dateEnd = '';
      this.current = false;
    },
    resetData() {
      this.profession = '';
      this.institution = '';
      this.degree = null;
      this.institutionJob = '';
      this.job = '';
      this.dateStart = '';
      this.dateEnd = '';
      this.current = false;
    },
    handleCvChange( event ) {
      const tgt = event.target || window.event.srcElement;
      const files = tgt.files;

      if ( this.checkTypeCv( files[0].type ) && this.checkSizeCv( files[0].size ) ) {
        this.$store.dispatch( 'applications/setCv', {
          file: files[0],
          name: files[0].name,
          loaded: true
        });

        return;
      }

      this.$store.dispatch( 'applications/resetCv' );
    },
    checkTypeCv( type ) {
      return this.typesCv.includes( type );
    },
    checkSizeCv( size ) {
      return 3145728 > size;
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
