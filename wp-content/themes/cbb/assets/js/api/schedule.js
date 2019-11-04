import qs from 'qs';
import axios from 'axios';

export default {
  async getSetting () {
    let token = document.head.querySelector('meta[name="csrf-token"]');

    let params = {
      nonce: token.content,
      action: 'setting_schedules'
    };

    try {
      const response = await axios.post(CbbAjax.url, qs.stringify(params));

      return response.data.data;
    } catch (error) {
      console.error(error);
    }
  }
};
