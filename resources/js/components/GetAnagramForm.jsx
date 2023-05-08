// Import necessary modules
import axios from "axios";
import { useState, useEffect } from 'react';
// Define the component
function GetAnagramForm() {
  // Set up state variables
  const [input, setInput] = useState("");
  const [result, setResult] = useState("");
  const [enterText, setEnterText] = useState("");
  const [sendText, setSendText] = useState("");
  // Get translatable strings from back-end on component mount and set them with response data
  useEffect(() => {
    axios.get(location+'getTexts')
      .then(function (response) {
      const fetch = response.data;
      setEnterText(fetch[0]);
      setSendText(fetch[1]);
      })
  }, [])
  // Send the input to the back-end to retrieve anagrams
  const sendInput = (event) => {
    // Prevent default form submission behavior
    event.preventDefault();
    // Make a post request to the back-end with input data
    axios.post(location+'input', {
      data: input
    })
    .then(function (response) {
      // Assing response data from the back-end to variable
      const anagram = response.data;
      // Set the result state with retrieved anagrams
      setResult(anagram);
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
  // Render a form to submit user input word and display the result
  return (
    <div>
      <form onSubmit={sendInput}>
        <input 
          type="text" 
          value={input}
          onChange={(e) => setInput(e.target.value)}
          placeholder={enterText} 
        />
        <input 
          type="submit" 
          value={sendText}
        />
      </form>
      <h2>{ result }</h2>
    </div>
  )
}
// Export the component as default
export default GetAnagramForm;