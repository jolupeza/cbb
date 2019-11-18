<template>
  <transition
    name="custom-classes-transition"
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <section class="Modal" v-if="openModal">
      <div class="Modal__wrapper">
        <header class="Modal__header">
          <h4>Estado de Docente</h4>
          <button type="button" class="Modal__close" @click="closeModal">x</button>
        </header>
        <div class="Modal__body">
          <p class="text-center">¿Está seguro de guardar los datos?</p>
        </div>
        <footer class="Modal__footer">
          <button type="button" class="WorkWithUs__button WorkWithUs__button--second" @click="saveApplication">Guardar</button>
          <button type="button" class="WorkWithUs__button WorkWithUs__button--first" @click="closeModal">Cancelar</button>
        </footer>
      </div>
    </section>
  </transition>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Modal',

  computed: {
    ...mapState({
      openModal: state => state.modal
    })
  },

  methods: {
    closeModal() {
      this.$store.dispatch( 'setModal', false );
    },
    saveApplication() {
      let params = {
        nonce: document.head.querySelector( 'meta[name="csrf-token"]' ).content,
        action: 'register_application'
      };

      this.$store.dispatch( 'applications/register', params ).then( () => {
        this.closeModal();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
  .Modal {
    align-items: center;
    background-color: rgba($darkColorAlt, 0.6);
    display: flex;
    font-size: 16px;
    justify-content: center;
    left: 0;
    min-height: 100%;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9;
    &__wrapper {
      background-color: $white;
      width: 90%;
      @media screen and (min-width: 992px) {
        width: 30%;
      }
    }
    &__header {
      background-color: $secondColorAlt;
      padding: 0.8em;
      position: relative;
      h4 {
        color: $white;
        font-family: $fontReef;
        font-size: 1.75em;
        margin: 0;
        text-transform: uppercase;
      }
    }
    &__close {
      background-color: transparent;
      border: none;
      color: white;
      font-family: $fontReef;
      font-size: 1.5em;
      position: absolute;
      right: 10px;
      top: 8px;
    }
    &__body {
      padding: 1.5em 0.8em;
      p {
        font-size: 1.125em;
        margin-bottom: 0;
      }
    }
    &__footer {
      display: flex;
      justify-content: center;
      padding: 0.8em;
      button {
        margin-right: 0.8em;
        &:last-child {
          margin-right: 0;
        }
      }
    }
  }
</style>
