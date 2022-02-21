import { Snackbar } from '@mui/material';
import { Alert } from '@mui/material';
import axios from 'axios';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function NewAuthorPage() {

    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });

    const createNewAuthor = async function (e) {
        e.preventDefault();

        const formdata = new FormData(document.getElementById('form-new-book'))


        axios.post(
            '/api/admin/authors',
            formdata
        ).then(res => {

            setSnackBarOpts({
                ...snackBarOpts,
                success: true
            })
            setSnackbarMessage(res.data.message)
        }).catch(err => {
            setSnackBarOpts({
                ...snackBarOpts,
                error: true
            })
            setSnackbarMessage(err.data.message)
        })
        $('#form-new-book')[0].reset();
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
        <div className="d-flex justify-content-center">
            <div className='w-50'>
                <form onSubmit={createNewAuthor} id="form-new-book">
                    <div class="">


                        <div class="mb-3">
                            <label for="name" class="form-label">Ime autora</label>
                            <input required type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="" />
                            <small id="helpId" class="form-text text-muted">Unesite Ime autora</small>
                        </div>

                    </div>
                    <div className='d-flex justify-content-center'>

                        <input type="submit" class="btn btn-success" value="Dodaj novog autora" />
                    </div>
                </form>
            </div>
            <Snackbar
                open={snackBarOpts.success}
                autoHideDuration={3000}
                onClose={handleClose}
                message="Note archived"
            >
                <Alert severity="success">{snackbarMessage}</Alert>
            </Snackbar>

            <Snackbar
                open={snackBarOpts.error}
                autoHideDuration={3000}
                onClose={handleClose}
                message="Note archived"
            >
                <Alert severity="error">{snackbarMessage}</Alert>
            </Snackbar>
        </div>
    );
}

export default NewAuthorPage;

if (document.getElementById('new-author-page')) {
    ReactDOM.render(<NewAuthorPage />, document.getElementById('new-author-page'));
}
