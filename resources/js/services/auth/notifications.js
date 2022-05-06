const axios = require('axios');
class notificationsservice{
	getlist(params){
		return axios.get(`/api/notifications${params}`)
		.then(function (response) {
			return response.data;
		})
		.catch(function (error) {
			return error;
		});
	}
}
export default new notificationsservice();