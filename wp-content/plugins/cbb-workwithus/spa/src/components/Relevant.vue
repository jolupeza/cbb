<template>
  <section class="Relevant">
    <div class="container">
      <ValidationObserver ref="observer" tag="form" @submit.prevent="addApplication" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Objetivos e intereses</h3>

        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label for="review">Reseña: <span>(*)</span></label>
              <ValidationProvider rules="" v-slot="{ errors }">
                <textarea class="form-control" id="review" name="review" v-model="review" rows="8"></textarea>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <!--<div class="form-group">
              <label for="photo">Adjuntar foto:</label>
              <ValidationProvider name="photo" rules="image" v-slot="{ validate, errors }">
                <input type="file" class="form-control" id="photo" name="photo" @change="validate($event) || handlePhotoChange($event)" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>-->
          </div>
        </div>

        <hr class="WorkWithUs__Separator">

        <div class="WorkWithUs__buttons">
          <button class="WorkWithUs__button WorkWithUs__button--second" @click.prevent="goToStep(3)">Anterior</button>
          <button type="submit" class="WorkWithUs__button WorkWithUs__button--first" :disabled="!valid">Finalizar</button>
        </div>
      </ValidationObserver>
    </div>

    <Modal />
  </section>
</template>

<script>
import Modal from '@/components/Modal';

export default {
  name: 'Relevant',

  components: {
    Modal
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
    }
  }
};
</script>

<style lang="scss" scoped>

</style>
