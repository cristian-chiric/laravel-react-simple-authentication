import axios from 'axios'

export default function(id) {
    return axios
        .delete('/admin/clients/' + id, { data: {}})
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
