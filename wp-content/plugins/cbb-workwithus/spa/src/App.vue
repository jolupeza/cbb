<template>
  <div id="wp-vue-workwithus">
    <form action="">
      <General />
    </form>
  </div>
</template>

<script>
import General from '@/components/General'

export default {
  name: 'App',

  components: {
    General
  }
}
</script>

<style lang="scss">
#wp-vue-workwithus {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin: 120px 0;
}
</style>
