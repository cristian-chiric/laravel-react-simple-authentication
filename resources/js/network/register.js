import axios from 'axios'

export default function(name, email, password, passwordConfirmation, captcha) {
    return axios
        .post('/register', {
            name: name,
            email: email,
            password: password,
            password_confirmation: passwordConfirmation,
            captcha: captcha
        })
        .then(({ status, data }) => {
            if (status === 200) {
                window.location = '/admin'
                return data
            } else {
                throw new Error('Error')
            }
        }).catch(err => {
            return err.response
        })
}
