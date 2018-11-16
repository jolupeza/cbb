<template>
  <aside v-if="inProgress" class="Loading">
    <i class="animated infinite rotateIn glyphicon glyphicon-refresh"></i>
  </aside>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    computed: {
      ...mapState({
        inProgress: state => state.inProgress
      })
    }
  }
</script>
