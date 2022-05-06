export default function admin(to, from, next) {
    var roleId = localStorage.getItem('logged_in_role_id')?parseInt(localStorage.getItem('logged_in_role_id')):0;
    if (roleId!=1) 
    {
        return next({
            name: 'auth.dashboard'
        })
    }
    return next()
}