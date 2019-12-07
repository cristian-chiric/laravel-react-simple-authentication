import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { mountReact } from './util/mountReact'
import { Button } from "@material-ui/core"

export default function Dashboard({ name, totalClients }) {
    const urls = {
        view: '/admin/clients',
        create: '/admin/clients/create',
        logout: '/logout',
    };

    function handleAction(type) {
        window.location = urls[type]
    }

    return (
        <div className='dashboard-form'>
            <h1>Welcome {name}</h1>
            <h2>Total clients: {totalClients}</h2>
            <Button variant="contained" color="primary" onClick={() => handleAction('view')}>View clients</Button>
            <Button variant="contained" color="primary" onClick={() => handleAction('create')}>Add Client</Button>
            <Button variant="contained" onClick={() => handleAction('logout')}>Logout</Button>
        </div>
    )
}

Dashboard.propTypes = {
    name: PropTypes.string.isRequired,
    totalClients: PropTypes.number,
}

mountReact('dashboard', Dashboard)
