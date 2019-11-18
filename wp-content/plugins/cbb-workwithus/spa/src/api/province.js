/* globals wpData */

import axios from 'axios';

export default {
  async retrieveByCity( idCity ) {
    try {
      const filters = `city=${idCity}`;
      const url = `${wpData.rest_url}/workwithus/v1/provinces/${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      console.info( error );
    }
  }
};
