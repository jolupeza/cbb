/* globals wpData */

import axios from 'axios';

export default {
  async retrieve( area ) {
    try {
      const filters = `area=${area}`;
      const url = `${wpData.rest_url}/workwithus/v1/speciality/${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
