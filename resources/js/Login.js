import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { mountReact } from './util/mountReact'
import { Button } from "@material-ui/core"
import {StyledTextField} from "./shared/StyledTextField"
import login from "./network/login"

export default function Login({ registerRoute }) {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [errors, setErrors] = useState({})

    async function handleAction() {
        let response = await login(email, password)
        if (response.status) {
            setErrors(response.status === 422 ? response.data.errors : {message: response.data.message})
        } else {
            setErrors({})
        }
    }

    return (
        <div className='login-form'>
            <h1>Login</h1>
            <StyledTextField id="email" label="Email address" onChange={ev => setEmail(ev.target.value)}
                             error={errors.email !== undefined} helperText={errors.email} />
            <StyledTextField type="password" id="password" label="Password" onChange={ev => setPassword(ev.target.value)}
                             error={errors.password !== undefined} helperText={errors.password} />
            {errors.message !== undefined && <p className="error-message">{errors.message}</p>}
            <Button variant="contained" color="primary" onClick={handleAction}>Login</Button>
            <p>No account yet? <a href={registerRoute}>Create one here.</a></p>
        </div>
    )
}

Login.propTypes = {
    registerRoute: PropTypes.string.isRequired,
}

mountReact('login', Login)
