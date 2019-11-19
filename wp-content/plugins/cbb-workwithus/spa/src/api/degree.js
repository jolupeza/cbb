/* globals wpData */

import axios from 'axios';

export default {
  async retrieve() {
    try {
      const filters = '?_fields=id,title&order=asc&orderby=menu_order&per_page=100';
      const url = `${wpData.rest_url}/wp/v2/degrees${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      if ( error.response ) {
        throw error.response.data;
      }
    }
  }
};
