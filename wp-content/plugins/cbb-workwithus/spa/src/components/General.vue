<template>
  <section class="General">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="General__title">Datos Usuario</h3>

          <div class="row">
            <div class="col-sm-9">
              <ValidationProvider rules="required|email" v-slot="{ errors }">
                <input type="text" v-model="docnum" />
                <span>{{ errors[0] }}</span>
              </ValidationProvider>

              <div class="form-group">
                <label for="docnum">Documento de identidad <span>(*)</span></label>
                <input type="text" class="form-control" id="docnum" name="docnum" />
              </div>
            </div>
            <div class="col-sm-3"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  name: 'General',

  data () {
    return {
      docnum: ''
    }
  }
}
</script>
<style lang="scss" scoped>
  .General {
    background-color: peru;
  }
</style>
