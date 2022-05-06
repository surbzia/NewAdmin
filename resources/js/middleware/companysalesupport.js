export default function companysalesupport(to, from, next) {
    var roleId = localStorage.getItem('logged_in_role_id')?parseInt(localStorage.getItem('logged_in_role_id')):0;
    if (roleId!=4&&roleId!=5&&roleId!=2&&roleId!=9) 
    {
        return next({
            name: 'auth.dashboard'
        })
    }
    return next()
}