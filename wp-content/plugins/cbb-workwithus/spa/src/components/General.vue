<template>
  <section class="General">
    <div class="container">
      <ValidationObserver ref="observerGeneral" tag="form" @submit.prevent="next" v-slot="{ valid }">
        <h3 class="WorkWithUs__title">Datos Usuario</h3>

        <div class="row">
          <div class="col-sm-7">
            <div class="row">
              <div class="col-sm-7 col-md-5">
                <div class="form-group">
                  <label for="document">Documento de Identidad: <span>(*)</span></label>
                  <ValidationProvider name="documento de identidad" rules="required|numeric|min:8|max:15" v-slot="{ errors }">
                    <input type="text" class="form-control" id="document" name="document" v-model="document" />
                    <span class="is-invalid">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                  <label for="photo">Tamaño máximo 1Mb</label>
                  <article class="WorkWithUs__Form__fileWrapper">
                    <aside v-show="avatar.loaded" class="WorkWithUs__Form__fileWrapper__delete" @click="handlePhotoDelete"><i class="fas fa-times"></i></aside>
                    <i v-if="!avatar.loaded" class="glyphicon glyphicon-user" aria-hidden="true"></i>
                    <img v-else :src="avatar.result" class="img-responsive" alt="avatar" />
                    <input type="file" id="photo" @change="handlePhotoChange($event)" />
                  </article>
                  <span v-show="showErrorPhoto" class="is-invalid">Tipo de archivo o tamaño no permitido.</span>

<!--                  <ValidationProvider name="foto" ref="photo" rules="image|size:1024" v-slot="{ validate, errors }">
                    <article class="WorkWithUs__Form__fileWrapper">
                      <aside v-show="avatar.loaded" class="WorkWithUs__Form__fileWrapper__delete" @click="handlePhotoDelete"><i class="fas fa-times"></i></aside>
                      <i v-if="!avatar.loaded" class="glyphicon glyphicon-user" aria-hidden="true"></i>
                      <img v-else :src="avatar.result" class="img-responsive" alt="avatar" />
                      <input type="file" id="photo" @change="handlePhotoChange($event) || validate($event)" />
                    </article>
                    <span class="is-invalid">{{ errors[0] }}</span>
                  </ValidationProvider>-->
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr class="WorkWithUs__Separator" />

        <h3 class="WorkWithUs__title">Datos Usuario</h3>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="apepaterno">Apellido Paterno: <span>(*)</span></label>
              <ValidationProvider name="apellido paterno" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="apepaterno" name="apepaterno" v-model="apepaterno" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="apematerno">Apellido Materno: <span>(*)</span></label>
              <ValidationProvider name="apellido materno" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="apematerno" name="apematerno" v-model="apematerno" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="name">Nombres: <span>(*)</span></label>
              <ValidationProvider name="nombres" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="name" name="name" v-model="name" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="gender">Sexo: <span>(*)</span></label>
              <ValidationProvider name="sexo" rules="required" v-slot="{ errors }">
                <select name="gender" id="gender" v-model="gender" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option value="femenino">Femenino</option>
                  <option value="masculino">Masculino</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="birthday">Fecha de nacimiento: <span>(*)</span></label>
              <ValidationProvider name="fecha de nacimiento" rules="required" v-slot="{ errors }">
                <input type="date" class="form-control" id="birthday" name="birthday" v-model="birthday" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="age">Edad: <span>(*)</span></label>
              <ValidationProvider name="edad" rules="required|numeric|min_value:18|max_value:80" v-slot="{ errors }">
                <input type="number" class="form-control" id="age" name="age" v-model.number="age" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="phone">Teléfono fijo:</label>
              <ValidationProvider name="teléfono fijo" rules="min:7" v-slot="{ errors }">
                <input type="text" class="form-control" id="phone" name="phone" v-model="phone" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mobile">Teléfono celular: <span>(*)</span></label>
              <ValidationProvider name="teléfono celular" rules="required|min:9" v-slot="{ errors }">
                <input type="text" class="form-control" id="mobile" name="mobile" v-model="mobile" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="email">Correo: <span>(*)</span></label>
              <ValidationProvider name="correo" rules="required|email" v-slot="{ errors }">
                <input type="email" class="form-control" id="email" name="email" v-model="email" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <hr class="WorkWithUs__Separator" />

        <h3 class="WorkWithUs__title">Ubicación actual</h3>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="city">Departamento: <span>(*)</span></label>
              <ValidationProvider name="departamento" rules="required" v-slot="{ errors }">
                <select name="city" id="city" v-model="city" class="form-control" @change="selectCity">
                  <option :value="null">Seleccione</option>
                  <option :value="item.id" v-for="item in cities" :key="item.id">{{ item.name }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="province">Provincia: <span>(*)</span></label>
              <ValidationProvider name="provincia" rules="required" v-slot="{ errors }">
                <select name="province" id="province" v-model="province" class="form-control" @change="selectProvince">
                  <option :value="null">Seleccione</option>
                  <option :value="item.id" v-for="item in provinces" :key="item.id">{{ item.name }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="district">Distrito: <span>(*)</span></label>
              <ValidationProvider name="distrito" rules="required" v-slot="{ errors }">
                <select name="district" id="district" v-model="district" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option :value="item.id" v-for="item in districts" :key="item.id">{{ item.name }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="address">Domicilio: <span>(*)</span></label>
              <ValidationProvider name="domicilio" rules="required" v-slot="{ errors }">
                <input type="text" class="form-control" id="address" name="address" v-model="address" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="reference">Referencia:</label>
              <ValidationProvider name="referencia" rules="" v-slot="{ errors }">
                <input type="text" class="form-control" id="reference" name="reference" v-model="reference" />
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <hr class="WorkWithUs__Separator" />

        <h3 class="WorkWithUs__title">Interés de postulación</h3>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="local">Sede a la que postula: <span>(*)</span></label>
              <ValidationProvider name="sede" rules="required" v-slot="{ errors }">
                <select name="local" id="local" v-model="local" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option :value="key" v-for="(local, key) in locals" :key="key">{{ local }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div v-if="isTeacher" class="col-sm-4">
            <div class="form-group">
              <label for="level">Nivel: <span>(*)</span></label>
              <ValidationProvider name="nivel" rules="required" v-slot="{ errors }">
                <select name="level" id="level" v-model="level" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option :value="key" v-for="(level, key) in levels" :key="key">{{ level }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="speciality">Especialidad <span>(*)</span></label>
              <ValidationProvider name="especialidad" rules="required" v-slot="{ errors }">
                <select name="speciality" id="speciality" v-model="speciality" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option :value="key" v-for="(speciality, key) in specialities" :key="key">{{ speciality }}</option>
                </select>
                <span class="is-invalid">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </div>

        <hr class="WorkWithUs__Separator" />

        <div class="WorkWithUs__buttons">
          <button type="submit" class="WorkWithUs__button WorkWithUs__button--first" :disabled="!valid" >Siguiente <i class="fas fa-chevron-right"></i></button>
        </div>
      </ValidationObserver>
    </div>
  </section>
</template>
<script>
import { mapState, mapGetters } from 'vuex';
export default {
  name: 'General',

  data() {
    return {
      avatar: {
        file: null,
        name: '',
        loaded: false,
        result: null
      },
      levels: this.wpData.levels,
      locals: this.wpData.locals,
      typesPhoto: [ 'image/jpeg', 'image/png' ],
      showErrorPhoto: false
    };
  },

  computed: {
    ...mapState( 'cities', {
      cities: state => state.all
    }),
    ...mapState( 'provinces', {
      provinces: state => state.all
    }),
    ...mapState( 'districts', {
      districts: state => state.all
    }),
    ...mapState( 'applications', {
      areaId: state => state.areaId
    }),
    ...mapState( 'specialities', {
      specialities: state => state.all
    }),
    ...mapGetters( 'applications', {
      slugArea: 'getAreaSlug'
    }),
    isTeacher() {
      return 'docente' === this.slugArea || 'auxiliar' === this.slugArea;
    },
    document: {
      get() {
        return this.$store.state.applications.document;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setDocument', value );
      }
    },
    apepaterno: {
      get() {
        return this.$store.state.applications.apepaterno;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setApepaterno', value );
      }
    },
    apematerno: {
      get() {
        return this.$store.state.applications.apematerno;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setApematerno', value );
      }
    },
    name: {
      get() {
        return this.$store.state.applications.name;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setName', value );
      }
    },
    gender: {
      get() {
        return this.$store.state.applications.gender;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setGender', value );
      }
    },
    birthday: {
      get() {
        return this.$store.state.applications.birthday;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setBirthday', value );
      }
    },
    age: {
      get() {
        return this.$store.state.applications.age;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setAge', value );
      }
    },
    phone: {
      get() {
        return this.$store.state.applications.phone;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setPhone', value );
      }
    },
    mobile: {
      get() {
        return this.$store.state.applications.mobile;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setMobile', value );
      }
    },
    email: {
      get() {
        return this.$store.state.applications.email;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setEmail', value );
      }
    },
    city: {
      get() {
        return this.$store.state.applications.city;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setCity', value );
      }
    },
    province: {
      get() {
        return this.$store.state.applications.province;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setProvince', value );
      }
    },
    district: {
      get() {
        return this.$store.state.applications.district;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setDistrict', value );
      }
    },
    address: {
      get() {
        return this.$store.state.applications.address;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setAddress', value );
      }
    },
    reference: {
      get() {
        return this.$store.state.applications.reference;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setReference', value );
      }
    },
    level: {
      get() {
        return this.$store.state.applications.level;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setLevel', value );
      }
    },
    local: {
      get() {
        return this.$store.state.applications.local;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setLocal', null !== value ? parseInt( value ) : null );
      }
    },
    speciality: {
      get() {
        return this.$store.state.applications.speciality;
      },
      set( value ) {
        this.$store.dispatch( 'applications/setSpeciality', null !== value ? parseInt( value ) : null );
      }
    }
  },

  created() {
    if ( 0 === this.cities.length ) {
      this.$store.dispatch( 'cities/retrieve' );
    }
  },

  mounted() {
    this.$helpers.scrollToTop();
  },

  methods: {
    selectCity() {
      if ( null === this.city ) {
        this.province = null;
        this.district = null;
        return;
      }

      this.$store.dispatch( 'provinces/retrieveByCity', this.city ).then( () => {
        this.province = null;
        this.district = null;
      });
    },
    selectProvince() {
      if ( null === this.province ) {
        this.district = null;
        return;
      }

      this.$store.dispatch( 'districts/retrieveByProvince', this.province ).then( () => {
        this.district = null;
      });
    },
    handlePhotoChange( event ) {
      const tgt = event.target || window.event.srcElement;
      const files = tgt.files;

      if ( this.checkTypePhoto( files[0].type ) && this.checkSizePhoto( files[0].size ) ) {
        this.showErrorPhoto = false;
        this.avatar.file = files[0];
        this.avatar.name = files[0].name;
        this.avatar.loaded = true;

        const fr = new FileReader();
        fr.onload = () => {
          this.avatar.result = fr.result;
        };
        fr.readAsDataURL( files[0]);

        this.$store.dispatch( 'applications/setPhoto', {
          file: this.avatar.file,
          name: this.avatar.name,
          loaded: this.avatar.loaded
        });
      } else {
        this.showErrorPhoto = true;
        this.resetAvatar();
      }

      /* const { valid } = await this.$refs.photo.validate( event );

      if ( valid ) {
        const tgt = event.target || window.event.srcElement;
        const files = tgt.files;

        this.avatar.file = files[0];
        this.avatar.name = files[0].name;
        this.avatar.loaded = true;

        const fr = new FileReader();
        fr.onload = () => {
          this.avatar.result = fr.result;
        };
        fr.readAsDataURL( files[0]);

        this.$store.dispatch( 'applications/setPhoto', {
          file: this.avatar.file,
          name: this.avatar.name,
          loaded: this.avatar.loaded
        });
      } else {
        this.resetAvatar();
      } */
    },
    handlePhotoDelete() {
      this.resetAvatar();
    },
    async next() {
      const isValid = await this.$refs.observerGeneral.validate();

      if ( ! isValid ) {
        return;
      }

      this.$store.dispatch( 'setStep', 2 );
    },
    checkTypePhoto( type ) {
      return this.typesPhoto.includes( type );
    },
    checkSizePhoto( size ) {
      return 1048576 > size;
    },
    resetAvatar() {
      this.avatar.file = null;
      this.avatar.name = '';
      this.avatar.loaded = false;
      this.avatar.result = null;

      this.$store.dispatch( 'applications/resetPhoto' );
    }
  }
};
</script>
<style lang="scss" scoped>
  .General {

  }
</style>
