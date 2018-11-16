<template>
  <div class="form-group" :class="{'has-error has-feedback': error}">
    <label v-if="label" :for="name" class="sr-only">{{ label }}</label>
    <input class="form-control"
      :name="name"
      :type="type"
      :value="value"
      :disabled="disabled"
      :minlength="minlength"
      :maxlength="maxlength"
      :placeholder="label"
      @input="updateValue"
      @change="updateValue"
      @blur="$emit('blur')"
      autocomplete="off" />
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
      name: {
        type: String,
        required: true
      },
      value: String,
      label: {
        type: String
      },
      disabled: {
        type: Boolean,
        default: false
      },
      minlength: {
        type: Number
      },
      maxlength: {
        type: Number
      },
      error: {
        type: String,
        required: false
      },
      type: {
        type: String,
        default: "text",
        validator: val => {
          return (
            ["url", "text", "password", "email", "search"].indexOf(val) !== -1
          )
        }
      }
    },
    methods: {
      updateValue(e) {
        this.$emit("input", e.target.value);
      }
    }
  }
</script>
