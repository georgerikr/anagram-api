// Import necessary modules
import axios from "axios";
import { useState, useEffect } from 'react';
// Define the component
function FetchWordsForm() {
  // Set up state variables
  const [message, setMessage] = useState("");
  const [headingText, setHeadingText] = useState("");
  const [wordbaseText, setWordbaseText] = useState("");
  const [loadText, setLoadText] = useState("");
  const [loadingText, setLoadingText] = useState("");
  // Fetch translatable strings from back-end on component mount and set them with response data
  useEffect(() => {
    axios.get(location+'fetchTexts')
      .then(function (response) {
      const fetch = response.data;
      setHeadingText(fetch[0]);
      setWordbaseText(fetch[1]);
      setLoadText(fetch[2]);
      setLoadingText(fetch[3]);
      })
  }, [])
  // Send a request to write function to load the wordbase
  const loadDatabase = (event) => {
    // Display a loading message
    setMessage(loadingText);
    // Prevent default form submission behavior
    event.preventDefault();
    // Make a post request to the back-end
    axios.post(location+'write')
    .then(function (response) {
      // Assing response data from the back-end to variable
      let fetch = response.data;
      // Set the message state with the response data
      setMessage(fetch);
    })
    .catch(function (error) {
      // Handle error
      if (error.response) {
        console.log(error.toJSON());
        // Request made and server responded
        console.log(error.response.data);
        console.log(error.response.status);
        console.log(error.response.headers);
      } else if (error.request) {
        // The request was made but no response was received
        console.log(error.request);
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
      }
    });
  }
  // Render a form to submit a request for loading the wordbase and display the message from back-end
  return (
    <div>
      <h1>{headingText}</h1>
      <form onSubmit={loadDatabase}>
        <label>
          {wordbaseText}
        </label>
        <input 
          type="submit" 
          value={loadText}
        />
      </form>
      <h2>{ message }</h2>
    </div>
  )
}
// Export the component as default
export default FetchWordsForm;