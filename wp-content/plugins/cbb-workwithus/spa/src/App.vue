<template>
  <div id="wp-vue-workwithus">
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
    </section>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import General from '@/components/General';
import Studies from '@/components/Studies';
import Experiences from '@/components/Experiences';
import Relevant from '@/components/Relevant';

export default {
  name: 'App',

  components: {
    General,
    Studies,
    Experiences,
    Relevant
  },

  computed: {
    ...mapState({
      step: state => state.step
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
