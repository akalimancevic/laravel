import { Alert, Snackbar, useScrollTrigger } from '@mui/material';
import axios from 'axios';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function RentedBooksPage() {

    const [rents, setRents] = useState([]);
    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });
    useEffect(() => {
        loadRents();
    }, [])
    const loadRents = () => {

        axios.get('/api/rents').then(res => {
            setRents(res.data.data);
        })
    }
    
    const handleDownload = (e) => {
        setSnackBarOpts({
            ...snackBarOpts,
            success: true
        })
        setSnackbarMessage('Ucitavanje preuzimanja... Sacekajte malo.')
        setTimeout(() => {

            location.href = `/rents/${e.target.id}/pdf`
        }, 2000)
    }

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setSnackBarOpts({

            success: false,
            error: false,
        });
    };

    return (
        <div className="container">
            <div className="container">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-inverse">
                        <tr>
                            <th style={{ width: '20%' }} >ID Iznajmljivanja</th>
                            <th style={{ width: '20%' }} >Naziv knjige</th>
                            <th style={{ width: '20%' }} >Autor</th>
                            <th style={{ width: '20%' }} >Cena</th>
                            <th style={{ width: '20%' }} >Akcija</th>
                        </tr>
                    </thead>
                    <tbody>

                        {rents.map((rent) => {
                            return <tr>
                                <td scope="row">{rent.id}</td>
                                <td>{rent.book.title}</td>
                                <td>{new Date(rent.created_at).toLocaleDateString().replace(new RegExp('/', 'g'), '.')}</td>
                                <td>{rent.book.price}</td>
                                <td>
                                    <button onClick={handleDownload} type="button" name="" id={rent.id} class="btn btn-secondary">Preuzmi racun</button>
                                </td>
                            </tr>
                        })}
                    </tbody>
                </table>

                <Snackbar
                    open={snackBarOpts.success}
                    autoHideDuration={3000}
                    onClose={handleClose}
                >
                    <Alert severity="info">{snackbarMessage}</Alert>
                </Snackbar>
            </div>
        </div>
    );
}

export default RentedBooksPage;

if (document.getElementById('rented-books-page')) {
    ReactDOM.render(<RentedBooksPage />, document.getElementById('rented-books-page'));
}
