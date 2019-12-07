import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import { mountReact } from './util/mountReact'
import { Button } from "@material-ui/core"
import {StyledTextField} from "./shared/StyledTextField"
import create from "./network/clients/create"
import edit from "./network/clients/edit"
import clientDelete from "./network/clients/delete"

export default function Client({ action, client }) {
    const [name, setName] = useState(client ? client.name : '')
    const [email, setEmail] = useState(client ? client.email : '')
    const [profilePicture, setProfilePicture] = useState('')
    const [profile, setProfile] = useState(null)
    const [message, setMessage] = useState('')
    const [errors, setErrors] = useState({})

    async function handleCreateAction() {
        let response = await create(name, email, profile)

        if (response.status && response.status === 422) {
            setErrors(response.data.errors)
        } else {
            setErrors({})
            window.location = "/admin/clients"
        }
    }

    async function handleEditAction() {
        let response = await edit(client.id, name, email, profile)

        if (response.status && response.status === 200) {
            setMessage('Client updated')
        } else if (response.status && response.status === 422) {
            setErrors(response.data.errors)
        } else {
            setMessage(response.data.message)
            setErrors({})
        }
    }

    async function handleDeleteAction() {
        let response = await clientDelete(client.id)

        if (response.status === 200) {
            setErrors({})
            window.location = "/admin/clients"
        }
    }

    function onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length) return
        createImage(files[0])
    }

    function createImage(file) {
        setProfile(file)
        console.log(file)
        let reader = new FileReader();

        reader.onload = (e) => {
            setProfilePicture(e.target.result)
        }

        reader.readAsDataURL(file)
    }

    function renderActions() {
        if (action === 'create') {
            return (
                <Button variant="contained" color="primary" onClick={handleCreateAction}>Create Client</Button>
            )
        }

        return (<Fragment>
            {message && <p className='message'>{message}</p>}
            <Button variant="contained" color="primary" onClick={handleEditAction}>Update Client</Button>
            <Button variant="contained" color="secondary" onClick={handleDeleteAction}>Delete Client</Button>
        </Fragment>)
    }

    function renderImagePreview() {
        if (profilePicture)
            return (<img src={profilePicture} width={200} height={200}/>)
        if (client && client.profile_picture)
            return (<img src={client.profile_picture} width={200} height={200}/>)
        return
    }

    return (
        <div className='register-form'>
            <h1>{ action === 'create' ? 'Add' : 'Update'} Client</h1>
            <StyledTextField id="name" label="Name" onChange={ev => setName(ev.target.value)}
                             error={errors.name !== undefined} helperText={errors.name} value={name}/>
            <StyledTextField id="email" label="Email address" onChange={ev => setEmail(ev.target.value)}
                             error={errors.email !== undefined} helperText={errors.email} value={email}/>
            <input type="file"  onChange={onFileChange} />
            {renderImagePreview()}
            {renderActions()}
            <p><a href="/admin/clients">Go back</a></p>
        </div>
    )
}

Client.propTypes = {
    action: PropTypes.string.isRequired,
    client: PropTypes.object,
}

mountReact('client', Client)
