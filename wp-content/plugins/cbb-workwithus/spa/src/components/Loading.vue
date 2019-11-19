<template>
  <article class="Loading">
    <aside class="Loading__icon">
      <i class="fas fa-circle-notch animated infinite rotateIn"></i>
    </aside>
  </article>
</template>

<script>
export default {
  name: 'Loading'
};
</script>

<style lang="scss" scoped>
  .Loading {
    align-items: center;
    background-color: rgba($darkColor, 0.3);
    display: flex;
    height: 100vh;
    justify-content: center;
    position: fixed;
    width: 100%;
    z-index: 9;
    &__icon {
      i[class=fas] {
        display: block;
      }
    }
  }
</style>
