const axios = require('axios');
class VariantService{
	getlist(params){
		return axios.get(`/api/variants${params}`)
		.then(function (response) {
			return response.data;
		})
		.catch(function (error) {
			return error;
		});
	}
    async create(formData){
        var res = await  axios.post('/api/variants',formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
    }
    delete({query,id}){
		return axios.delete(`/api/variants/${id}`);
	}
    get(id){
		return axios.get(`/api/variants/${id}`).then(e=>e.data);
	}
    async update(formData, id){
		formData.append('_method','put')
		var res = await  axios.post('/api/variants/'+id,formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
	}
}
export default new VariantService();
