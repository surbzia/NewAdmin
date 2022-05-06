const axios = require('axios');
const controller = new AbortController();
class fileservice{
    async create(formData){
        var res = await  axios.post('/api/file',formData).then(function(e){
            return {status: 1, data: e.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
    }
    async get(params){
        controller.abort()
        var res = await axios.get('/api/file?'+params,{
            signal: controller.signal
        }).then(e=>{
            return {status: 1, data: e.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
    }
}
export default new fileservice();