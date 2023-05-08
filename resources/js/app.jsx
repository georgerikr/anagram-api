// Import necessary modules
import './bootstrap';
import '../css/app.css'
import React from 'react';
import ReactDOM from 'react-dom/client';
// Import components
import LoginForm from './components/LoginForm';
import FetchWordsForm from './components/FetchWordsForm';
import GetAnagramForm from './components/GetAnagramForm';

// Check if the element with given Id exists on the page, then create a React root and render the component inside the container
// Render LoginForm
if (document.getElementById('loginForm')) {
    const container = document.getElementById('loginForm');
    const root = ReactDOM.createRoot(container);
    root.render(<LoginForm />);
}
// Render FetchWordsForm
if (document.getElementById('fetchWordsForm')) {
    const container = document.getElementById('fetchWordsForm');
    const root = ReactDOM.createRoot(container);
    root.render(<FetchWordsForm />);
}
// Render GetAnagramForm
if (document.getElementById('getAnagramForm')) {
    const container = document.getElementById('getAnagramForm');
    const root = ReactDOM.createRoot(container);
    root.render(<GetAnagramForm />);
}