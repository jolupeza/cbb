/* globals wpData */

import axios from 'axios';
import qs from 'qs';

export default {
  async register( params ) {
    try {
      const response = await axios.post( wpData.ajaxUrl, qs.stringify( params ) );
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
