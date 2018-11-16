<template>
  <div class="form-group" :class="{'has-error has-feedback': error}">
    <label v-if="label" :for="name" class="sr-only">{{ label }}</label>
    <select class="form-control"
      :name="name"
      :disabled="disabled"
      @change="updateValue">
      <option :value="null" :selected="!value">-- {{ defaultValueText }} --</option>
      <option v-for="item in items" :value="item.id">{{ item.title }}</option>
      <option v-if="withOther" :value="'other'">Otro</option>
    </select>
    <transition name="fade">
      <p v-if="error" class="text-danger Form__alert">{{ error }}</p>
    </transition>
  </div>
</template>

<script>
  export default {
    $_veeValidate: {
      name() {
        return this.name;
      },
      value() {
        return this.value;
      }
    },
    props: {
      value: {},
      name: {
        type: String,
        required: true
      },
      label: {
        type: String
      },
      defaultValueText: {
        type: String,
        default: 'Seleccione'
      },
      items: {
        type: Array
      },
      withOther: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      error: {
        type: String,
        required: false
      },
      emitMethod: {
        type: String
      }
    },
    methods: {
      updateValue(e) {
        let val = e.target.value.length === 0 ? null : e.target.value;
        this.$emit("input", val);

        if (this.emitMethod) {
          this.$emit(this.emitMethod);
        }
      }
    }
  }
</script>
