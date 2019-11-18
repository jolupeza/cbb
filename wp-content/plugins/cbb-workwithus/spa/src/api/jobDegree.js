/* globals wpData */

import axios from 'axios';

export default {
  async retrieve() {
    try {
      const url = `${wpData.rest_url}/workwithus/v1/jobdegrees`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
