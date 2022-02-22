import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import { Snackbar } from '@mui/material';
import { Alert } from '@mui/material';
import axios from 'axios';


function BooksComponent(props) {
    const [authors, setAuthors] = useState([]);
    const [genres, setGenres] = useState([]);
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

    return (
        <div className="row justify-content-center">

            {props.books.map(book => {
                console.log(props)
                return <div className={`col-${12 / props.perRow}`}>

                    <Book loadBooks={props.loadBooks} authors={authors} genres={genres} book={book} />
                </div>
            })}
        </div>
    );
}

export default BooksComponent;

function Book(props) {

    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setSnackBarOpts({

            success: false,
            error: false,
        });
    };

    const handleDeleteBook = () => {
        axios.delete('/api/admin/books/' + props.book.id).then(res => {

            setSnackBarOpts({
                ...snackBarOpts,
                success: true
            })
            setSnackbarMessage(res.data.message)
            props.loadBooks(null, false);
        }).catch(err => {
            setSnackBarOpts({
                ...snackBarOpts,
                error: true
            })
            setSnackbarMessage(err.data.message)
            props.loadBooks(null, false);
        })

    }

    return (
        <div>
            <div class="card">
                <div class="card-body pb-1">

                    {/* obrisi */}
                    <button className="btn icon-hover" onClick={handleDeleteBook}>
                        <i role="button" class="fa-solid fa-trash "></i>
                    </button>

                    {/* update */}
                    <button data-toggle="modal" data-target={`#book_${props.book.id}`} className="btn icon-hover">
                        <i class="fa-solid fa-pen"></i>
                    </button>

                </div>
                <img src={props.book.book_image_path ? `storage/${props.book.book_image_path}` : `img/book-placeholder.jpeg`} class="card-img-top" alt="..." />
                <div class="card-body">
                    <h5 class="card-title">{props.book.title} ({props.book.genre.genre_name})</h5>
                    <h6 class="card-subtitle mb-2 text-muted ">Cena: {props.book.price} RSD</h6>
                    <h6 class="card-subtitle mb-2 text-muted ">Na stanju: {props.book.quantity} {props.book.quantity > 1 && props.book.quantity < 4 ? 'knjige' : 'knjiga'} </h6>
                    <h6 class="card-subtitle mb-2 text-muted ">Autor: {props.book.author.name}</h6>
                    <p class="card-text">{props.book.description}</p>
                </div>
            </div>
            <UpdateBook loadBooks={props.loadBooks} authors={props.authors} genres={props.genres} book={props.book} />

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

function UpdateBook(props) {

    const [authors, setAuthors] = useState(props.authors || []);
    const [genres, setGenres] = useState(props.genres || []);
    const [snackbarMessage, setSnackbarMessage] = useState('');

    const [snackBarOpts, setSnackBarOpts] = useState({
        success: false,
        error: false
    });

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setSnackBarOpts({

            success: false,
            error: false,
        });
    };


    const updateBook = (e) => {

        e.preventDefault();
        const formdata = new FormData(document.getElementById('update-book-' + props.book.id))
        formdata.append('_method', 'PUT');

        axios.post(
            '/api/admin/books/' + props.book.id,
            formdata
        ).then(res => {

            setSnackBarOpts({
                ...snackBarOpts,
                success: true
            })
            setSnackbarMessage(res.data.message)
            props.loadBooks(null, false);
        }).catch(err => {
            setSnackBarOpts({
                ...snackBarOpts,
                error: true
            })
            setSnackbarMessage(err.data.message)
            props.loadBooks(null, false);
        })
        $('#update-book-' + props.book.id)[0].reset();
    }

    return (
        <div class="modal fade" id={`book_${props.book.id}`} data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby={`book_${props.book.id}`} aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Izmena knjige</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form onSubmit={updateBook} id={"update-book-" + props.book.id}>
                            <div class="">


                                <div class="mb-3">
                                    <label for="title" class="form-label">Naslov knjige</label>
                                    <input required type="text" class="form-control" defaultValue={props.book.title} name="title" id="title" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite Naslov knjige</small>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Opis knjige</label>
                                    <input required type="text" class="form-control" defaultValue={props.book.description} name="description" id="description" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite opis knjige</small>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="quantity" class="form-label">Kolicina na stanju</label>
                                        <input required type="number" class="form-control" defaultValue={props.book.quantity} name="quantity" id="quantity" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite kolicinu na stanju</small>
                                    </div>

                                    <div class="mb-3 col">
                                        <label for="price" class="form-label">Cena</label>
                                        <input required type="number" class="form-control" defaultValue={props.book.price} name="price" id="price" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite cenu knjige</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Žanr knjige</label>
                                    <select class="form-control" name="genre_id" defaultValue={props.book.genre_id} id="">
                                        {
                                            props.genres.map((g) => {
                                                return <option value={g.id}>{g.genre_name}</option>
                                            })
                                        }
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Autori</label>
                                    <select class="form-control" name="author_id" defaultValue={props.book.author_id} id="">
                                        {
                                            authors.map((a) => {
                                                return <option value={a.id}>{a.name}</option>
                                            })
                                        }
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="book_image_path" class="form-label">Slika knjige</label>
                                    <img src={props.book.book_image_path ? `storage/${props.book.book_image_path}` : `img/book-placeholder.jpeg`} class="card-img-top" alt="..." />
                                    <input type="file" class="form-control" name="book_image_path" id="book_image_path" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Dodajte sliku knjige</small>
                                </div>

                            </div>
                            <div className='d-flex justify-content-center'>

                                <input type="submit" class="btn btn-success" value="Izmeni knjigu" />
                            </div>
                        </form>
                    </div>

                </div>
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
        </div >

    )
}