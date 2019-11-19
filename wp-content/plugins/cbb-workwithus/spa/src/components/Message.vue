<template>
  <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
    <div v-if="message.show" class="alert" :class="typeMessage" role="alert">
      <p class="text-center"><strong>{{ message.msg }}</strong></p>
    </div>
  </transition>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Message',

  computed: {
    ...mapState({
      message: state => state.message
    }),
    typeMessage() {
      return `alert-${this.message.type}`;
    }
  }
};
</script>
