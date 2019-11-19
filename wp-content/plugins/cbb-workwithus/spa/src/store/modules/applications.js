import applicationApi from '@/api/application';

const state = {
  levelId: null,
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
  photo: null,
  studies: [],
  experiences: [],
  review: ''
};

const getters = {
  hasStudies( state ) {
    return 0 < state.studies.length;
  },
  hasExperiences( state ) {
    return 0 < state.experiences.length;
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
  setAddress( context, address ) {
    context.commit( 'SET_ADDRESS', address );
  },
  setReference( context, reference ) {
    context.commit( 'SET_REFERENCE', reference );
  },
  setReview( context, review ) {
    context.commit( 'SET_REVIEW', review );
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
  setPhoto( context, photo ) {
    context.commit( 'SET_PHOTO', photo );
  },
  setLevelId( context, id ) {
    context.commit( 'SET_LEVEL_ID', id );
  },
  async register({ state }, { nonce, action }) {
    let params = {
      nonce,
      action,
      level: state.levelId,
      document: state.document,
      apepaterno: state.apematerno,
      apematerno: state.apematerno,
      name: state.name,
      gender: state.gender,
      birthday: state.birthday,
      age: state.age,
      phone: state.phone,
      mobile: state.mobile,
      email: state.email,
      city: state.city,
      province: state.province,
      district: state.district,
      address: state.address,
      reference: state.reference,
      review: state.review
    };

    try {
      return await applicationApi.register( params );
    } catch ( error ) {
      throw error;
    }
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
  SET_REVIEW( state, review ) {
    state.review = review;
  },
  SET_PHOTO( state, photo ) {
    state.photo = photo;
  },
  SET_LEVEL_ID( state, id ) {
    state.levelId = id;
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
    state.photo = null;
    state.studies = [];
    state.experiences = [];
    state.review = '';
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
