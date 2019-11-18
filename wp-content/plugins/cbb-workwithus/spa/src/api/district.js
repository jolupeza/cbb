/* globals wpData */

import axios from 'axios';

export default {
  async retrieveByProvince( idProvince ) {
    try {
      const filters = `province=${idProvince}`;
      const url = `${wpData.rest_url}/workwithus/v1/districts/${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      console.info( error );
    }
  }
};
