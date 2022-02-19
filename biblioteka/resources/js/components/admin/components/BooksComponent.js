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

    return (
        <div>
            <div class="card">
                <img src={`img/${props.book.book_image_path || 'book-placeholder.jpeg'}`} class="card-img-top" alt="..." />
                <div class="card-body">
                    <h5 class="card-title">{props.book.title} ({props.book.genre.genre_name})</h5>
                    <h6 class="card-subtitle mb-2 text-muted ">Cena: {props.book.price} RSD</h6>
                    <h6 class="card-subtitle mb-2 text-muted ">Na stanju: {props.book.quantity} {props.book.quantity > 1 && props.book.quantity < 4 ? 'knjige' : 'knjiga'} </h6>
                    <h6 class="card-subtitle mb-2 text-muted ">Autor: {props.book.author.name}</h6>
                    <p class="card-text">{props.book.description}</p>
                </div>
            </div>
        </div>
    );
}