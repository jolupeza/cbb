/* globals wpData */
/* eslint no-useless-catch: "off" */

import applicationApi from '@/api/application';
import dataCities from '@/assets/resources/cities.json';
import dataProvinces from '@/assets/resources/provinces.json';
import dataDistricts from '@/assets/resources/districts.json';

const state = {
  areaId: null,
  level: null,
  local: null,
  speciality: null,
  document: '',
  apepaterno: '',
  apematerno: '',
  name: '',
  gender: null,
  birthday: '',
  age: 18,
  phone: '',
  mobile: '',
  email: '',
  city: null,
  province: null,
  district: null,
  address: '',
  reference: '',
  photo: { file: null, name: '', loaded: false },
  cv: { file: null, name: '', loaded: false },
  studies: [],
  experiences: []
};

const getters = {
  hasStudies( state ) {
    return 0 < state.studies.length;
  },
  hasExperiences( state ) {
    return 0 < state.experiences.length;
  },
  getAreaSlug( state ) {
    for ( const id in wpData.areas ) {
      if ( parseInt( id ) === state.areaId ) {
        return wpData.areas[id];
      }
    }

    return null;
  }
};

const actions = {
  setDocument( context, document ) {
    context.commit( 'SET_DOCUMENT', document );
  },
  setApepaterno( context, apepaterno ) {
    context.commit( 'SET_APEPATERNO', apepaterno );
  },
  setApematerno( context, apematerno ) {
    context.commit( 'SET_APEMATERNO', apematerno );
  },
  setName( context, name ) {
    context.commit( 'SET_NAME', name );
  },
  setGender( context, gender ) {
    context.commit( 'SET_GENDER', gender );
  },
  setBirthday( context, birthday ) {
    context.commit( 'SET_BIRTHDAY', birthday );
  },
  setAge( context, age ) {
    context.commit( 'SET_AGE', age );
  },
  setPhone( context, phone ) {
    context.commit( 'SET_PHONE', phone );
  },
  setMobile( context, mobile ) {
    context.commit( 'SET_MOBILE', mobile );
  },
  setEmail( context, email ) {
    context.commit( 'SET_EMAIL', email );
  },
  setCity( context, city ) {
    context.commit( 'SET_CITY', city );
  },
  setProvince( context, province ) {
    context.commit( 'SET_PROVINCE', province );
  },
  setDistrict( context, district ) {
    context.commit( 'SET_DISTRICT', district );
  },
  setLevel( context, level ) {
    context.commit( 'SET_LEVEL', level );
  },
  setLocal( context, local ) {
    context.commit( 'SET_LOCAL', local );
  },
  setSpeciality( context, speciality ) {
    context.commit( 'SET_SPECIALITY', speciality );
  },
  setAddress( context, address ) {
    context.commit( 'SET_ADDRESS', address );
  },
  setReference( context, reference ) {
    context.commit( 'SET_REFERENCE', reference );
  },
  setStudies( context, data ) {
    return new Promise( resolve => {
      context.commit( 'SET_STUDIES', data );
      resolve();
    });
  },
  setExperiences( context, data ) {
    return new Promise( resolve => {
      context.commit( 'SET_EXPERIENCES', data );
      resolve();
    });
  },
  setPhoto( context, { file, name, loaded }) {
    context.commit( 'SET_PHOTO', { file, name, loaded });
  },
  setCv( context, { file, name, loaded }) {
    context.commit( 'SET_CV', { file, name, loaded });
  },
  setAreaId( context, id ) {
    return new Promise( ( resolve ) => {
      context.commit( 'SET_AREA_ID', id );
      resolve();
    });
  },
  async register({ state }, { nonce, action }) {
    try {
      const formData = new FormData();

      formData.append( 'nonce', nonce );
      formData.append( 'action', action );
      formData.append( 'area', state.areaId );
      formData.append( 'document', state.document );
      formData.append( 'apepaterno', state.apepaterno );
      formData.append( 'apematerno', state.apematerno );
      formData.append( 'name', state.name );
      formData.append( 'gender', state.gender );
      formData.append( 'birthday', state.birthday );
      formData.append( 'age', state.age );
      formData.append( 'phone', state.phone );
      formData.append( 'mobile', state.mobile );
      formData.append( 'email', state.email );
      formData.append( 'city', methods.findNameCity( state.city ) );
      formData.append( 'province', methods.findNameProvince( state.province ) );
      formData.append( 'district', methods.findNameDistrict( state.district ) );
      formData.append( 'address', state.address );
      formData.append( 'reference', state.reference );
      formData.append( 'level', state.level );
      formData.append( 'local', state.local );
      formData.append( 'speciality', state.speciality );
      formData.append( 'studies', JSON.stringify( state.studies ) );
      formData.append( 'experiences', JSON.stringify( state.experiences ) );

      if ( state.photo.loaded ) {
        formData.append( 'photo', state.photo.file, state.photo.name );
      }

      if ( state.cv.loaded ) {
        formData.append( 'cv', state.cv.file, state.cv.name );
      }

      return await applicationApi.register( formData );
    } catch ( error ) {
      throw error;
    }
  },
  resetPhoto( context ) {
    context.commit( 'RESET_PHOTO' );
  },
  removeStudy({ commit }, index ) {
    commit( 'REMOVE_STUDY', index );
  },
  removeExperience({ commit }, index ) {
    commit( 'REMOVE_EXPERIENCE', index );
  },
  resetCv( context ) {
    context.commit( 'RESET_CV' );
  },
  resetData( context ) {
    context.commit( 'RESET_DATA' );
  }
};

const mutations = {
  SET_DOCUMENT( state, document ) {
    state.document = document;
  },
  SET_APEPATERNO( state, apepaterno ) {
    state.apepaterno = apepaterno;
  },
  SET_APEMATERNO( state, apematerno ) {
    state.apematerno = apematerno;
  },
  SET_NAME( state, name ) {
    state.name = name;
  },
  SET_GENDER( state, gender ) {
    state.gender = gender;
  },
  SET_BIRTHDAY( state, birthday ) {
    state.birthday = birthday;
  },
  SET_AGE( state, age ) {
    state.age = age;
  },
  SET_PHONE( state, phone ) {
    state.phone = phone;
  },
  SET_MOBILE( state, mobile ) {
    state.mobile = mobile;
  },
  SET_EMAIL( state, email ) {
    state.email = email;
  },
  SET_CITY( state, city ) {
    state.city = city;
  },
  SET_PROVINCE( state, province ) {
    state.province = province;
  },
  SET_DISTRICT( state, district ) {
    state.district = district;
  },
  SET_ADDRESS( state, address ) {
    state.address = address;
  },
  SET_REFERENCE( state, reference ) {
    state.reference = reference;
  },
  SET_STUDIES( state, data ) {
    state.studies.push( data );
  },
  SET_EXPERIENCES( state, data ) {
    state.experiences.push( data );
  },
  SET_PHOTO( state, { file, name, loaded }) {
    state.photo.file = file;
    state.photo.name = name;
    state.photo.loaded = loaded;
  },
  SET_CV( state, { file, name, loaded }) {
    state.cv.file = file;
    state.cv.name = name;
    state.cv.loaded = loaded;
  },
  SET_LEVEL( state, level ) {
    state.level = level;
  },
  SET_LOCAL( state, local ) {
    state.local = local;
  },
  SET_SPECIALITY( state, speciality ) {
    state.speciality = speciality;
  },
  SET_AREA_ID( state, id ) {
    state.areaId = id;
  },
  REMOVE_STUDY( state, index ) {
    state.studies.splice( index, 1 );
  },
  REMOVE_EXPERIENCE( state, index ) {
    state.experiences.splice( index, 1 );
  },
  RESET_DATA( state ) {
    state.document = '';
    state.apepaterno = '';
    state.apematerno = '';
    state.name = '';
    state.gender = null;
    state.birthday = '';
    state.age = 18;
    state.phone = '';
    state.mobile = '';
    state.email = '';
    state.city = null;
    state.province = null;
    state.district = null;
    state.address = '';
    state.reference = '';
    state.photo.file = null;
    state.photo.name = '';
    state.photo.loaded = false;
    state.studies = [];
    state.experiences = [];
    state.cv.file = null;
    state.cv.name = '';
    state.cv.loaded = false;
    state.level = null;
    state.local = null;
    state.speciality = null;
  },
  RESET_PHOTO( state ) {
    state.photo.file = null;
    state.photo.name = '';
    state.photo.loaded = false;
  },
  RESET_CV( state ) {
    state.cv.file = null;
    state.cv.name = '';
    state.cv.loaded = false;
  }
};

const methods = {
  findNameCity( idCity ) {
    return dataCities.find( city => {
      return city.id === idCity;
    }).name;
  },
  findNameProvince( idProvince ) {
    return dataProvinces.find( province => {
      return province.id === idProvince;
    }).name;
  },
  findNameDistrict( idDistrict ) {
    return dataDistricts.find( district => {
      return district.id === idDistrict;
    }).name;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
