/* globals wpData */

import axios from 'axios';

export default {
  async register( params ) {
    try {
      const response = await axios.post( wpData.ajaxUrl, params, {
        headers: {
          'Content-Type': 'multipart/form-fata'
        }
      });
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
