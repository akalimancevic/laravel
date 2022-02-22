import { Alert, Snackbar } from '@mui/material';
import axios from 'axios';
import React, { useState } from 'react';
import ReactDOM from 'react-dom';



function BooksComponent(props) {



    return (
        <div className="row justify-content-center">

            {props.books.map(book => {
                console.log(props)
                return <div className={`col-${12 / props.perRow}`}>

                    <Book book={book} />
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
    const handleRent = (e) => {
        axios.post(`/api/books/${e.target.id}/rents`)
            .then(res => {

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
                setSnackbarMessage(err.response.data.message)
            })
    }

    return (
        <div>
            <div class="card">
                <div className="card-body">
                    <button data-toggle="tooltip" id={props.book.id} onClick={handleRent} data-placement="left" title="Iznajmi" className="btn icon-hover">
                        <i class="fa-solid fa-bag-shopping"></i>
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