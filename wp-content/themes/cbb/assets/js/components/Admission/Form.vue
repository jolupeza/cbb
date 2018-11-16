<template>
  <form @submit.prevent="registerAdmission" class="Form Form--fields" action="" method="POST">
    <h3 class="Form-title">1. Datos del padre de familia</h3>

    <text-input v-model="draft.parent_name"
      label="Nombre completo"
      :name="'parent_name'"
      v-validate="'required'"
      :error="errors.first('parent_name')" />

    <div class="row">
      <div class="col-md-6">
        <text-input v-model="draft.parent_dni"
          label="DNI / CE"
          :name="'parent_dni'"
          :minlength="8"
          :maxlength="8"
          v-validate="'required|min:8|max:8|regex:^([0-9]+)$'"
          :error="errors.first('parent_dni')" />
      </div>
      <div class="col-md-6">
        <text-input v-model="draft.parent_phone"
          label="Teléfono / Celular"
          :name="'parent_phone'"
          :minlength="7"
          :maxlength="9"
          v-validate="'required|min:7|max:9|regex:^([0-9]+)$'"
          :error="errors.first('parent_phone')" />
      </div>
    </div>

    <text-input v-model="draft.parent_email"
      :name="'parent_email'"
      label="Correo electrónico"
      v-validate="'required|email'"
      :error="errors.first('parent_email')" />

    <select-input v-model="draft.parent_sede"
      :name="'parent_sede'"
      label="Sede"
      defaultValueText="Seleccione sede de su interés"
      v-validate="'required'"
      :items="localsArr"
      emit-method="getSchedules"
      @getSchedules="getSchedules"
      :error="errors.first('parent_sede')" />

    <select-input v-model="draft.schedule"
      :name="'schedule'"
      label="Horario"
      defaultValueText="Seleccione horario o indicar otro"
      v-validate="!checkOtherSchedule() ? 'required' : ''"
      :items="schedules"
      emit-method="resetScheduleCustom"
      @resetScheduleCustom="resetScheduleCustom"
      :with-other="true"
      :error="errors.first('schedule')" />

    <div class="row">
      <div class="col-md-6" v-show="checkOtherSchedule()">
        <div class="form-group" :class="{'has-error has-feedback': errors.has('schedule_custom')}">
          <label for="schedule_custom" class="sr-only">Seleccionar horario</label>

          <date-picker v-model="draft.schedule_custom"
            name="schedule_custom"
            type="datetime"
            format="YYYY-MM-DD hh:mm a"
            :time-picker-options="timePickerOptions"
            :lang="lang"
            :not-before="Date.now()"
            :input-class="'mx-input form-control'"
            :disabled-days="disabledDays"
            v-validate="checkOtherSchedule() ? 'required' : ''"></date-picker>
          <transition name="fade">
            <p v-if="errors.has('schedule_custom')" class="text-danger Form__alert">{{ errors.first('schedule_custom') }}</p>
          </transition>
          <!-- <p class="text-info">Sábados de 8 a.m. a 1 p.m.</p> -->
        </div>
      </div>
    </div>

    <h3 class="Form-title">2. Datos del hijo a postular</h3>
    <text-input v-model="draft.son_name"
      :name="'son_name'"
      label="Nombre completo"
      v-validate="'required'"
      :error="errors.first('son_name')" />

    <select-input v-model="draft.son_level"
      :name="'son_level'"
      label="Grado"
      defaultValueText="Seleccione grado al que desea postular"
      v-validate="'required'"
      :items="levelsArr"
      :error="errors.first('son_level')" />

    <div class="form-group" :class="{'has-error has-feedback': errors.has('parent_terms')}">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="parent_terms" v-model="draft.parent_terms" v-validate="'required'"> Acepto las <a :href="urlTerms" target="_blank" rel="noopener noreferrer">condiciones del proceso de admisión {{ yearAdmission }}</a>
        </label>
        <p v-show="errors.has('parent_terms')" class="text-danger Form__alert">{{ errors.first('parent_terms') }}</p>
      </div>
    </div>

    <p class="text-center">
      <button type="submit" class="btn Button Button--blue Button--medium">enviar <span v-if="loading" class="Form-loader animated infinite rotateIn"><i class="icon-spin-alt"></i></span></button>
    </p>

    <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div v-if="info.status" class="alert text-center h4 Form__message" :class="typeInfo">{{ info.text }}</div>
    </transition>
  </form>
</template>

<script>
  import qs from 'qs';
  import DatePicker from 'vue2-datepicker'
  import { mapState } from 'vuex'
  import TextInput from './Fields/Text.vue'
  import SelectInput from './Fields/Select.vue'

  export default {
    components: {
      DatePicker,
      TextInput,
      SelectInput
    },
    props: ['yearAdmission', 'urlTerms'],
    data() {
      return {
        loading: false,
        info: {
          status: false,
          type: '',
          text: ''
        },
        lang: {
          days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
          months: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
          placeholder: {
            date: 'Seleccionar horario'
          }
        },
        timePickerOptions: {
          start: '08:00',
          step: '00:15',
          end: '17:00'
        },
        disabledDays: [
          '2018-11-18 00:00:00',
          '2018-11-25 00:00:00',
          '2018-12-02 00:00:00',
          '2018-12-09 00:00:00',
          '2018-12-16 00:00:00',
          '2018-12-23 00:00:00',
          '2018-12-30 00:00:00'
        ],
        draft: {},
        localsArr: [],
        levelsArr: [],
        schedules: [],
        pathUrl: window.location.protocol + '//' + window.location.host
      }
    },
    computed: {
      ...mapState('locals', {
        locals: state => state.all
      }),
      ...mapState('levels', {
        levels: state => state.all
      }),
      ...mapState('date', {
        disabledDates: state => state.disabledDates
      }),
      typeInfo() {
        return 'alert-' + this.info.type;
      },
      minDate() {
        return moment().format('YYYY-MM-DD');
      }
    },
    created() {
      this.$store.dispatch('locals/getAllLocals').then(() => {
        this.locals.forEach((local, index) => {
          this.localsArr.push({id: local.id, title: this.sanitizeExcerpt(local.excerpt.rendered)})
        })
      })
      this.$store.dispatch('levels/getAllLevels').then(() => {
        this.levelsArr = this.levels.map((level) => {
          return {id: level.id, title: level.name}
        })
      })
    },
    methods: {
      checkOtherSchedule() {
        return this.draft.schedule === 'other'
      },
      registerAdmission() {
        this.$validator.validate().then(result => {
          if (result) {
            this.loading = true;
            let token = document.head.querySelector('meta[name="csrf-token"]');

            let fields = clone(this.draft);
            if (typeof fields.schedule_custom !== 'undefined') {
              fields.schedule_custom = moment(this.draft.schedule_custom).format('YYYY-MM-DD h:mm a');
            } else {
              fields.schedule = parseInt(this.draft.schedule);
            }

            fields.parent_sede = parseInt(this.draft.parent_sede);
            fields.son_level = parseInt(this.draft.son_level);

            let params = {
              nonce: token.content,
              action: 'register_admision',
              fields
            }

            this.processRequest('post', params)
              .then(response => {
                if (response.result && response.msg.length) {
                  this.$validator.reset();
                  this.draft = {};

                  this.info.status = true;
                  this.info.type = 'success';
                  this.info.text = response.msg;

                  setTimeout(() => {
                    this.info.status = false;
                    this.info.type = '';
                    this.info.text = '';
                  }, 5000);
                }
              })
          }
        })
      },
      getSchedules() {
        let token = document.head.querySelector('meta[name="csrf-token"]');

        this.cleanSchedules()

        if (!this.draft.parent_sede) {
          return;
        }

        let params = {
          nonce: token.content,
          action: 'load_schedule',
          local: this.draft.parent_sede
        }

        this.processRequest('post', params)
          .then(response => {
            if (response.posts.length) {
              response.posts.forEach((item, index) => {
                this.schedules.push({id: item.ID, title: item.post_excerpt})
              })
            }
          })
      },
      resetScheduleCustom() {
        if (!this.checkOtherSchedule()) {
          delete this.draft.schedule_custom
        }
      },
      processRequest(method, params) {
        return axios[method](this.buildUrl(), qs.stringify(params))
          .then(response => {
            if (!response.data.result) {
              this.displayError(response.data.error)
            }

            this.loading = false;
            return response.data
          })
          .catch(error => {
            this.loading = false;
            if (error.response) {
              let msg = error.response.statusText === 'Bad Request' ? 'No se pudo realizar la consulta. Por favor vuelva a intentarlo.': error.response.statusText

              this.displayError(msg)
            }
          })
      },
      buildUrl() {
        return CbbAjax.url
      },
      displayError(msg) {
        let info = {type: 'danger', text: msg, display: true}

        this.$store.dispatch('setMessage', info)
      },
      cleanSchedules() {
        this.schedules = []
        delete this.draft.schedule
        delete this.draft.schedule_custom
      },
      sanitizeExcerpt(text) {
        return text.replace('<p>', '').replace('</p>', '').replace('&#8211;', '-')
      }
    }
  }
</script>