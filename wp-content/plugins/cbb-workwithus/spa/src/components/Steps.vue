<template>
  <section class="Steps">
    <div class="container">
      <section class="Steps__wrapper">
        <article class="Steps__item" :class="{ 'active': item.id === step }" v-for="item in steps" :key="item.id">
          <figure class="Steps__figure"><span class="Steps__number" v-html="getTitleStep( item )"></span></figure>
          <h3 class="Steps__title">{{ item.title }}</h3>
        </article>
      </section>
    </div>
  </section>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Steps',

  computed: {
    ...mapState({
      step: state => state.step
    })
  },

  data() {
    return {
      steps: [
        { id: 1, title: 'Datos generales', number: '01' },
        { id: 2, title: 'Formación académica', number: '02' },
        { id: 3, title: 'Experiencia laboral', number: '03' },
        { id: 4, title: 'Información relevante', number: '04' }
      ]
    };
  },

  methods: {
    getTitleStep( item ) {
      if ( item.id < this.step ) {
        return '<i class="fas fa-check"></i>';
      }

      return item.number;
    }
  }
};
</script>

<style lang="scss" scoped>
.Steps {
  &__wrapper {
    display: flex;
  }
  &__item {
    width: 25%;
    &.active {
      .Steps {
        &__figure {
          &::after {
            background-color: $firstColorAlt;
          }
        }
        &__number {
          background-color: $firstColor;
        }
        &__title {
          color: $firstColor;
        }
      }
    }
  }
  &__figure {
    align-items: center;
    display: flex;
    justify-content: center;
    position: relative;
    &::after{
      background-color: rgba($secondColorAlt, 0.5);
      content: '';
      height: 3px;
      left: 0;
      position: absolute;
      width: 100%;
      z-index: -1;
    }
  }
  &__number {
    background-color: $secondColorAlt;
    border-radius: 0.5em;
    color: $white;
    display: inline-block;
    font-family: $fontReef;
    font-size: 2.5rem;
    padding: 0.5em 0.5em;
  }
  &__title {
    color: $secondColorAlt;
    font-family: $fontSource;
    font-size: 1.125em;
    font-weight: 600;
    text-align: center;
  }
}
</style>
