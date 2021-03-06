/* globals wpData */

import axios from 'axios';

export default {
  async retrieve( type ) {
    try {
      const filters = `type=${type}`;
      const url = `${wpData.rest_url}/workwithus/v1/degrees/${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
