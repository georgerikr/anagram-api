// Import necessary modules
import axios from "axios";
import { useState, useEffect } from 'react';
// Define the component
function LoginForm() {
  // Set up state variables
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [notification, setNotification] = useState("");
  const [loginText, setLoginText] = useState("");
  const [emailText, setEmailText] = useState("");
  const [passwordText, setPasswordText] = useState("");
  // Get translatable strings from back-end on component mount and set them with response data
  useEffect(() => {
      axios.get(location+'loginTexts')
        .then(function (response) {
        const fetch = response.data;
        setLoginText(fetch[0]);
        setEmailText(fetch[1]);
        setPasswordText(fetch[2]);
        })
  }, [])
  // Send user credentials to the back-end to log in
  const signIn = (event) => {
    // Prevent default form submission behavior
    event.preventDefault();
    // Construct the user data to send in the request body
    const data = {
      email: email,
      password: password
    }
    // Make a post request to the back-end with the user's data
    axios.post(location+'signin', {
      data: data,
    })
    .then(function (response) {
      // Assing response data from the back-end to variable
      const login = response.data;
      // Check if login was successful
      if (login.success === true) {
        // If yes, then redirect the user to home page
        location.href = "./";
      } else {
        // If no, set the notification state with the response data
        setNotification(login[0]);
      }
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
  // Render a form to submit user credentials for login, show notification if login was unsuccessful
  return (
    <div>
    <h1>{loginText}:</h1>
    <form onSubmit={signIn}>
      <label>
      <input
          type="email" 
          value={email}
          placeholder={emailText}
          onChange={(e) => setEmail(e.target.value)}
      />
      <br></br>
      <input 
          type="password" 
          value={password}
          placeholder={passwordText}
          onChange={(e) => setPassword(e.target.value)}
      />
      </label>
      <br></br>
      <input 
          type="submit" 
          value={ loginText }
      />
    </form>
    <h2>{notification}</h2>
    </div>
  )
}
// Export the component as default
export default LoginForm;