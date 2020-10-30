import axios from 'axios';

export default {
    pathUrl: window.location.protocol + '//' + window.location.host,
    getLabelTerms() {
        let url = `${this.pathUrl}/wp-json/cbb/v1/admision/labelTerms`;

        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
};
