/* globals wpData */

import axios from 'axios';

export default {
  async retrieve() {
    try {
      const filters = '?_fields=id,title&order=asc&orderby=title&per_page=100';
      const url = `${wpData.rest_url}/wp/v2/cities${filters}`;
      const response = await axios.get( url );
      return response.data;
    } catch ( error ) {
      console.info( error );
    }
  }
};
