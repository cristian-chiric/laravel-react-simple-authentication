import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { mountReact } from '../util/mountReact'
import { Button } from '@material-ui/core'
import Table from '@material-ui/core/Table'
import TableBody from '@material-ui/core/TableBody'
import TableCell from '@material-ui/core/TableCell'
import TableHead from '@material-ui/core/TableHead'
import TableRow from '@material-ui/core/TableRow'
import clientDelete from "../network/clients/delete";

export default function Clients({ name, clients, totalClients }) {
    const urls = {
        create: '/admin/clients/create',
        delete: '/admin/clients/{id}',
        edit: '/admin/clients/{id}/edit',
        logout: '/logout',
    };

    function handleAction(type, id) {
        let action = urls[type]

        if (id) {
            action = urls[type].replace('{id}', id)
        }

        window.location = action
    }

    async function handleDeleteAction(id) {
        let response = await clientDelete(id)

        if (response.status === 200) {
            window.location.reload()
        }
    }

    return (
        <div className='dashboard-form'>
            <h1>Hi {name}, welcome to your admin account</h1>
            <h2>Total clients: {totalClients}</h2>
            <Table aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell>Name</TableCell>
                        <TableCell>Email</TableCell>
                        <TableCell align="right">Action</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {clients.map(client => (
                        <TableRow key={client.id}>
                            <TableCell component="th" scope="row">{client.name}</TableCell>
                            <TableCell>{client.email}</TableCell>
                            <TableCell align="right">
                                <a onClick={() => handleAction('edit', client.id)}>Edit</a> | <a onClick={() => handleDeleteAction(client.id)}>Delete</a>
                            </TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
            <Button variant="contained" color="primary" onClick={() => handleAction('create')}>Add Client</Button>
            <Button variant="contained" onClick={() => handleAction('logout')}>Logout</Button>
        </div>
    )
}

Clients.propTypes = {
    name: PropTypes.string.isRequired,
    clients: PropTypes.array.isRequired,
    totalClients: PropTypes.number,
}

mountReact('clients', Clients)
