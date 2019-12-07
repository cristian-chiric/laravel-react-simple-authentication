import axios from 'axios'

export default function(id, name, email, profile) {
    let formData = new FormData()
    formData.append('name', name)
    formData.append('email', email)
    formData.append('_method', 'PUT')

    if (profile) {
        formData.append('profile_picture', profile)
    }

    return axios
        .post('/admin/clients/' + id, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
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
