<template>
  <section class="General">
    <div class="container">
      <ValidationObserver v-slot="{ valid }">
        <form>
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
                <div class="col-sm-4 col-md-3">
                  <div class="form-group">
                    <ValidationProvider name="foto" ref="photo" rules="required|image|size:2048" v-slot="{ validate, errors }">
                      <article class="WorkWithUs__Form__fileWrapper">
                        <i v-if="!avatar.loaded" class="glyphicon glyphicon-user" aria-hidden="true"></i>
                        <img v-else :src="avatar.result" class="img-responsive" alt="avatar" />
                        <input type="file" id="photo" @change="handlePhotoChange($event) || validate($event)" />
                      </article>
                      <span class="is-invalid">{{ errors[0] }}</span>
                    </ValidationProvider>
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
                <label for="mobile">Teléfono celular:</label>
                <ValidationProvider name="teléfono celular" rules="min:9" v-slot="{ errors }">
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

          <div class="WorkWithUs__buttons">
            <button class="WorkWithUs__button WorkWithUs__button--first" :disabled="!valid" @click.prevent="next">Siguiente <i class="fas fa-chevron-right"></i></button>
          </div>
        </form>
      </ValidationObserver>
    </div>
  </section>
</template>
<script>
import { mapState } from 'vuex';
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
      typesPhoto: [ 'image/jpeg', 'image/png' ]
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
    }
  },

  created() {
    if ( 0 === this.cities.length ) {
      this.$store.dispatch( 'cities/byJson' );
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

      this.$store.dispatch( 'provinces/retrieve', this.city ).then( () => {
        this.province = null;
        this.district = null;
      });
    },
    selectProvince() {
      if ( null === this.province ) {
        this.district = null;
        return;
      }

      this.$store.dispatch( 'districts/retrieve', this.province ).then( () => {
        this.district = null;
      });
    },
    handlePhotoChange( event ) {
      let tgt = event.target || window.event.srcElement;
      let files = tgt.files;

      if ( this.checkTypePhoto( files[0].type ) && this.checkSizePhoto( files[0].size ) ) {
        this.avatar.file = files[0];
        this.avatar.name = files[0].name;
        this.avatar.loaded = true;

        let fr = new FileReader();
        fr.onload = () => {
          this.avatar.result = fr.result;
        };
        fr.readAsDataURL( files[0]);

        this.$store.dispatch( 'applications/setPhoto', {
          file: this.avatar.file,
          name: this.avatar.name,
          loaded: this.avatar.loaded
        });

        return;
      }

      this.resetAvatar();
    },
    next() {
      this.$store.dispatch( 'setStep', 2 );
    },
    checkTypePhoto( type ) {
      return this.typesPhoto.includes( type );
    },
    checkSizePhoto( size ) {
      return 2097152 > size;
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
