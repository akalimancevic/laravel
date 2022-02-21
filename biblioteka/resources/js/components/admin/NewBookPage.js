import { Snackbar } from '@mui/material';
import { Alert } from '@mui/material';
import axios from 'axios';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function NewBookPage() {

    const [authors, setAuthors] = useState([]);
    const [genres, setGenres] = useState([]);
    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });

    useEffect(() => {
        loadAuthors()
        loadGenres()
    }, [])

    const loadAuthors = function () {
        axios.get(`/api/authors`)
            .then((res) => {

                setAuthors(res.data.authors);


            })
    }

    const loadGenres = function () {
        axios.get(`/api/genres`)
            .then((res) => {
                setGenres(res.data.genres);
            })
    }

    const createNewBook = async function (e) {
        e.preventDefault();

        const formdata = new FormData(document.getElementById('form-new-book'))


        axios.post(
            '/api/admin/books',
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
                <form onSubmit={createNewBook} id="form-new-book">
                    <div class="">


                        <div class="mb-3">
                            <label for="title" class="form-label">Naslov knjige</label>
                            <input required type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="" />
                            <small id="helpId" class="form-text text-muted">Unesite Naslov knjige</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Opis knjige</label>
                            <input required type="text" class="form-control" name="description" id="description" aria-describedby="helpId" placeholder="" />
                            <small id="helpId" class="form-text text-muted">Unesite opis knjige</small>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="quantity" class="form-label">Kolicina na stanju</label>
                                <input required type="number" class="form-control" name="quantity" id="quantity" aria-describedby="helpId" placeholder="" />
                                <small id="helpId" class="form-text text-muted">Unesite kolicinu na stanju</small>
                            </div>

                            <div class="mb-3 col">
                                <label for="price" class="form-label">Cena</label>
                                <input required type="number" class="form-control" name="price" id="price" aria-describedby="helpId" placeholder="" />
                                <small id="helpId" class="form-text text-muted">Unesite cenu knjige</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Žanr knjige</label>
                            <select class="form-control" name="genre_id" id="">
                                {
                                    genres.map((g) => {
                                        return <option value={g.id}>{g.genre_name}</option>
                                    })
                                }
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Autori</label>
                            <select class="form-control" name="author_id" id="">
                                {
                                    authors.map((a) => {
                                        return <option value={a.id}>{a.name}</option>
                                    })
                                }
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="book_image_path" class="form-label">Slika knjige</label>
                            <input required type="file" class="form-control" name="book_picture" id="book_picture" aria-describedby="helpId" placeholder="" />
                            <small id="helpId" class="form-text text-muted">Dodajte sliku knjige</small>
                        </div>

                    </div>
                    <div className='d-flex justify-content-center'>

                        <input type="submit" class="btn btn-success" value="Dodaj novu knjigu" />
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

export default NewBookPage;

if (document.getElementById('new-book-page')) {
    ReactDOM.render(<NewBookPage />, document.getElementById('new-book-page'));
}
