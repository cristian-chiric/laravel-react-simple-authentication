import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { mountReact } from './util/mountReact'
import { Button } from "@material-ui/core"
import {StyledTextField} from "./shared/StyledTextField"
import register from "./network/register"
import ReCAPTCHA from "react-google-recaptcha"

export default function Register({ loginRoute }) {
    const [name, setName] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [passwordConfirmation, setPasswordConfirmation] = useState('')
    const [reCaptcha, setReCaptcha] = useState('')
    const [errors, setErrors] = useState({})

    async function handleAction() {
        let response = await register(name, email, password, passwordConfirmation, reCaptcha)

        if (response.status && response.status === 422) {
            setErrors(response.data.errors)
        } else {
            setErrors({})
        }
    }

    return (
        <div className='register-form'>
            <h1>Create your account</h1>
            <StyledTextField id="name" label="Name" onChange={ev => setName(ev.target.value)}
                             error={errors.name !== undefined} helperText={errors.name} />
            <StyledTextField id="email" label="Email address" onChange={ev => setEmail(ev.target.value)}
                             error={errors.email !== undefined} helperText={errors.email} />
            <StyledTextField type="password" id="password" label="Password" onChange={ev => setPassword(ev.target.value)}
                             error={errors.password !== undefined} helperText={errors.password} />
            <StyledTextField type="password" id="password_confirmation" label="Repeat your password"
                             onChange={ev => setPasswordConfirmation(ev.target.value)}/>
            <ReCAPTCHA className="captcha" sitekey="6Lfzg8YUAAAAAEPuXFn-8CrhIuaF7TGJ-XDOtcnI" onChange={value => setReCaptcha(value)} />
            {errors.captcha !== undefined && <p className="error-message">{errors.captcha}</p>}
            <Button variant="contained" color="primary" onClick={handleAction}>Create Account</Button>
            <p>Do you have an account? <a href={loginRoute}>Login here.</a></p>
        </div>
    )
}

Register.propTypes = {
    loginRoute: PropTypes.string.isRequired,
}

mountReact('register', Register)
