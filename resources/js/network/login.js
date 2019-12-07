import axios from 'axios'

export default function(email, password) {
    return axios
        .post('/login', {
            email: email,
            password: password,
        })
        .then((response) => {
            console.log(response)
            if (response.status === 200) {
                window.location = '/admin'
                return response
            } else {
                throw new Error('Error')
            }
        }).catch(err => {
            return err.response
        })
}
