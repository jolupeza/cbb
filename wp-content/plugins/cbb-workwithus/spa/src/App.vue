<template>
  <div id="wp-vue-workwithus">
    <Steps />
    <section class="WorkWithUs__Form">
      <transition
        name="custom-classes-transition"
        enter-active-class="animated slideInLeft"
        leave-active-class="animated slideOutRight"
        :duration="{ enter: 500, leave: 10 }">
        <General v-if="step === 1" />
      </transition>
      <transition
        name="custom-classes-transition"
        enter-active-class="animated slideInLeft"
        leave-active-class="animated slideOutRight"
        :duration="{ enter: 500, leave: 10 }">
        <Studies v-if="step === 2" />
      </transition>
      <transition
        name="custom-classes-transition"
        enter-active-class="animated slideInLeft"
        leave-active-class="animated slideOutRight"
        :duration="{ enter: 500, leave: 10 }">
        <Experiences v-if="step === 3" />
      </transition>
      <transition
        name="custom-classes-transition"
        enter-active-class="animated slideInLeft"
        leave-active-class="animated slideOutRight"
        :duration="{ enter: 500, leave: 10 }">
        <Relevant v-if="step === 4" />
      </transition>

      <transition
        name="custom-classes-transition"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut">
        <Loading v-if="loading" />
      </transition>
    </section>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import General from '@/components/General';
import Studies from '@/components/Studies';
import Experiences from '@/components/Experiences';
import Relevant from '@/components/Relevant';
import Loading from '@/components/Loading';
import Steps from '@/components/Steps';

export default {
  name: 'App',

  components: {
    General,
    Studies,
    Experiences,
    Relevant,
    Loading,
    Steps
  },

  computed: {
    ...mapState({
      step: state => state.step,
      loading: state => state.loading
    })
  },

  mounted() {
    let wrapper = document.getElementById( 'wp-vue-workwithus-main' );
    let levelId = parseInt( wrapper.dataset.levelid );

    this.$store.dispatch( 'applications/setLevelId', levelId );
  }
};
</script>

<style lang="scss">
#wp-vue-workwithus {
  font-family: $fontSource;
  font-size: 16px;
  margin: 120px 0;
}
.WorkWithUs {
  &__title {
    color: $secondColorAlt;
    font-family: $fontReef;
    font-size: 1.5em;
    text-transform: uppercase;
    @media screen and (min-width: 992px) {
      font-size: 2em;
    }
  }
  &__Form {
    label {
      color: $secondColorAlt;
      font-family: $fontSource;
      font-size: 1em;
      font-weight: 300;
      @media screen and (min-width: 992px) {
        font-size: 1.125em;
      }
      span {
        color: $firstColorAlt;
        font-weight: 600;
      }
    }
    input,
    textarea,
    select {
      &.form-control {
        border-color: $secondColorAlt;
        font-size: $fontSource;
        font-size: 1em;
        font-weight: 300;
        + .is-invalid {
          color: $firstColorAlt;
          font-size: 0.875em;
        }
      }
    }
    input,
    select {
      &.form-control {
        height: 38px;
      }
    }
    &__fileWrapper {
      align-items: center;
      border: 1px solid $secondColorAlt;
      border-radius: 0.5em;
      color: $secondColorAlt;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      overflow: hidden;
      padding: 1em;
      position: relative;
      &::after {
        content: 'Adjuntar foto';
        font-family: $fontSource;
        font-size: 0.875em;
        font-weight: 300;
        margin-top: 0.5em;
        text-align: center;
        width: 100%;
      }
      img {
        max-width: 120px;
      }
      .glyphicon {
        display: block;
        font-size: 3em;
        text-align: center;
        width: 100%;
      }
      input[type=file] {
        background-color: $white;
        cursor: inherit;
        display: block;
        height: 100%;
        width: 100%;
        opacity: 0;
        outline: none;
        position: absolute;
        right: 0;
        top: 0;
      }
      + .is-invalid {
        color: $firstColorAlt;
        display: block;
        font-size: 0.875em;
        text-align: center;
      }
    }
  }
  &__Separator {
    border-top: 1px solid $secondColorAlt;
  }
  &__buttons {
    display: flex;
    justify-content: center;
    button {
      margin-right: 2em;
      &:last-child {
        margin-right: 0;
      }
    }
  }
  &__button {
    background-color: transparent;
    border: none;
    border-radius: 0.5em;
    color: $white;
    font-family: $fontSource;
    font-weight: 600;
    opacity: 1;
    padding: 0.8em 1.5em;
    text-transform: uppercase;
    transition: background-color 0.2s ease-in-out, opacity 0.4s ease-in;
    &:disabled {
      cursor: not-allowed;
      opacity: 0.8;
    }
    &--first {
      background-color: $firstColor;
      &:focus,
      &:hover {
        background-color: $firstColorAlt;
      }
    }
    &--second {
      background-color: $secondColor;
    }
  }
}
</style>
