import axios from 'axios';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Pagination from 'react-js-pagination';
import BooksComponent from './components/BooksComponent';

function BooksPage() {

    const [options, setOptions] = useState({
        perPage: 24,
        perRow: 3
    })


    const [helpers, setHelpers] = useState({
        authors: [],
        genres: []
    })

    const [filtersState, setFiltersState] = useState('');

    const [books, setBooks] = useState({
        data: []
    });

    useEffect(
        () => {

            getBooks();
            getHelpers();

        }, [options.perPage]
    )

    const handleOptionsChange = (type, value) => {

        const adjustedOptions = { ...options };
        adjustedOptions[type] = value;

        setOptions(adjustedOptions)
    }

    const getBooks = (filters = null, pageNumber = 1) => {

        if (filters)
            axios.get(`/api/books?page=${pageNumber}&perPage=${options.perPage}&${filters}`)
                .then((res) => {
                    setBooks(res.data.books);

                });

        else
            if (filtersState != '')
                axios.get(`/api/books?page=${pageNumber}&perPage=${options.perPage}&${filtersState}`)
                    .then((res) => {
                        setBooks(res.data.books);

                    });
            else
                axios.get(`/api/books?page=${pageNumber}&perPage=${options.perPage}`)
                    .then((res) => {
                        setBooks(res.data.books);

                    });
    }

    const getHelpers = () => {



        if (
            $('#authors_select option').length === 0
        )
            axios.get(`/api/authors`)
                .then((res) => {

                    res.data.authors.forEach(author => {


                        $('#authors_select').append($('<option>', {
                            value: author.id,
                            text: author.name
                        }));
                        $('#authors_select').selectpicker('refresh');


                    })
                    const adjustedHelpers = helpers;

                    adjustedHelpers['authors'] = res.data.authors;
                    setHelpers(adjustedHelpers);


                })

        if (
            $('#genres_select option').length === 0
        )
            axios.get(`/api/genres`)
                .then((res) => {
                    const adjustedHelpers = helpers;

                    res.data.genres.forEach(genre => {
                        $('#genres_select').append($('<option>', {
                            value: genre.id,
                            text: genre.genre_name
                        }));
                        $('#genres_select').selectpicker('refresh');
                    })
                    adjustedHelpers['genres'] = res.data.genres;
                    setHelpers(adjustedHelpers);
                })

    }

    const setFilters = (e) => {

        const authors = $('#authors_select').val() || [];
        const genres = $('#genres_select').val() || [];

        console.log(genres);
        let queryFilterString = authors.map(author => `authors[]=${author}`).join('&')
            + '&'
            + genres.map(genre => `genres[]=${genre}`).join('&')

        setFiltersState(queryFilterString);
        getBooks(queryFilterString);
    }

    return (
        <div className="container">
            <div className="d-flex justify-content-end" >
                <div className="col">
                    Autori
                    <br></br>

                    <select id="authors_select" onChange={setFilters} class="selectpicker" multiple data-live-search="true">
                    </select>
                </div>
                <div className="col">
                    Žanrovi
                    <br></br>
                    <select id="genres_select" onChange={setFilters} name="genres" class="selectpicker" multiple data-live-search="true">

                    </select>
                </div>
                <div className="col">
                    Po stranici
                    <select onChange={(e) => handleOptionsChange('perPage', e.target.value)} className="form-control m-2">
                        <option>Po stranici</option>
                        <option value="24" >24</option>
                        <option value="48" >48</option>
                        <option value="72" >72</option>
                    </select>
                </div>

                <div className="col">
                    Po redu
                    <select onChange={(e) => handleOptionsChange('perRow', e.target.value)} className=" form-control m-2">
                        <option>Po redu</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>
            <br></br>
            <BooksComponent genres={helpers.genres} authors={helpers.authors} books={books.data || []} perRow={options.perRow} />

            <div className="d-flex justify-content-center mt-4">
                <Pagination

                    activePage={books?.current_page ? books?.current_page : 0}
                    itemsCountPerPage={books?.per_page ? books?.per_page : 0}
                    totalItemsCount={books?.total ? books?.total : 0}
                    onChange={(pageNumber) => {
                        getBooks(null, pageNumber)
                    }}
                    pageRangeDisplayed={8}
                    itemClass="page-item"
                    linkClass="page-link"
                />
            </div>
        </div>
    );
}

export default BooksPage;

if (document.getElementById('books_admin')) {
    ReactDOM.render(<BooksPage />, document.getElementById('books_admin'));
}
