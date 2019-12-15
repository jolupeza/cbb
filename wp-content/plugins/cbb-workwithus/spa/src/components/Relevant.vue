<template>
  <section class="Relevant">
    <div class="container">
      <ValidationObserver ref="observer" tag="form" @submit.prevent="addApplication" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Objetivos e intereses</h3>

        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label for="review">Reseña:</label>
              <ValidationProvider rules="" v-slot="{ errors }">
                <textarea class="form-control" id="review" name="review" v-model="review" rows="8"></textarea>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="cv">Adjuntar tu CV con certificados de trabajo y títulos obtenidos: (Formatos válidos: DOC, DOCX y PDF)</label>
              <ValidationProvider name="CV" rules="mimes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf|size:3072" v-slot="{ validate, errors }">
                <input type="file" class="form-control" id="cv" name="cv" @change="handleCvChange($event) || validate($event)" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <hr class="WorkWithUs__Separator">

        <Message />

        <div class="WorkWithUs__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" @click.prevent="goToStep(3)"><i class="fas fa-chevron-left"></i> Anterior</button>
          <button type="submit" class="WorkWithUs__button WorkWithUs__button--first">Finalizar <i class="fas fa-check"></i></button>
        </div>
      </ValidationObserver>
    </div>

    <Modal />
  </section>
</template>

<script>
import Modal from '@/components/Modal';
import Message from '@/components/Message';

export default {
  name: 'Relevant',

  components: {
    Modal,
    Message
  },

  computed: {
    review: {
      get() {
        return this.$store.state.applications.review;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setReview', value );
      }
    }
  },

  data() {
    return {
      typesCv: [ 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf' ]
    };
  },

  mounted() {
    this.$helpers.scrollToTop();
  },

  methods: {
    goToStep( step ) {
      this.$store.dispatch( 'setStep', step );
    },
    async addApplication() {
      const isValid = await this.$refs.observer.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'setModal', true );
    },
    handleCvChange( event ) {
      let tgt = event.target || window.event.srcElement;
      let files = tgt.files;

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
    }
  }
};
</script>

<style lang="scss" scoped>

</style>
