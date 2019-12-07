import axios from 'axios'

export default function(name, email, profile) {
    let formData = new FormData()
    formData.set('name', name)
    formData.set('email', email)

    if (profile) {
        formData.append('profile_picture', profile)
    }

    return axios
        .post('/admin/clients', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            if (response.status === 200) {
                return response
            } else {
                throw new Error('Error')
            }
        }).catch(err => {
            return err.response
        })
}
