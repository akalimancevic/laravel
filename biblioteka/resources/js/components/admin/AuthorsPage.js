import { Alert, Snackbar } from '@mui/material';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function AuthorsPage() {

    const [authors, setAuthors] = useState([]);
    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });
    useEffect(() => {
        loadAuthors();
    }, [])

    const loadAuthors = function () {
        axios.get(`/api/authors`)
            .then((res) => {

                setAuthors(res.data.authors);


            })

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


    const deleteAuthor = (e) => {

        axios.delete(
            '/api/admin/authors/' + e.target.id
        ).then(res => {

            setSnackBarOpts({
                ...snackBarOpts,
                success: true
            })
            setSnackbarMessage(res.data.message)

            setAuthors(authors.filter(a => a.id != e.target.id))
        }).catch(err => {
            setSnackBarOpts({
                ...snackBarOpts,
                error: true
            })
            setSnackbarMessage(err.data.message)
        })
    }
    return (
        <div className="container">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-inverse">
                    <tr>
                        <th style={{ width: '25%' }} >ID Autora</th>
                        <th style={{ width: '25%' }} >Ime</th>
                        <th style={{ width: '25%' }} >Datum dodavanja</th>
                        <th style={{ width: '25%' }} >Akcija</th>
                    </tr>
                </thead>
                <tbody>

                    {authors.map((author) => {
                        return <tr>
                            <td scope="row">{author.id}</td>
                            <td>{author.name}</td>
                            <td>{new Date(author.created_at).toLocaleDateString().replace(new RegExp('/', 'g'), '.')}</td>
                            <td>
                                <button onClick={deleteAuthor} type="button" name="" id={author.id} class="btn btn-danger">Obrisi</button>
                            </td>
                        </tr>
                    })}
                </tbody>
            </table>

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

export default AuthorsPage;

if (document.getElementById('authors-page')) {
    ReactDOM.render(<AuthorsPage />, document.getElementById('authors-page'));
}
