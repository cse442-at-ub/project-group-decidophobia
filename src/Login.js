import React, { useState } from 'react';
import './Login.css'; // Import the CSS file for styling

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [incorrectPassword, setIncorrectPassword] = useState(false);

  const handleUsernameChange = (event) => {
    setUsername(event.target.value);
    setIncorrectPassword(false);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
    setIncorrectPassword(false);
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    // Check the password (replace with your actual password check logic)
    const correctPassword = 'abc';

    if (password === correctPassword) {
      console.log('Login successful:', { username, password });
    } else {
      setIncorrectPassword(true);
    }
  };

  const handleSignUpClick = () => {
    window.location.href = 'https://example.com/signup';
  };

  return (
    <div className="login-container">
      <h2>Help me decide</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Username:</label>
          <input type="text" value={username} onChange={handleUsernameChange} />
        </div>
        <div>
          <label>Password:</label>
          <input type="password" value={password} onChange={handlePasswordChange} />
        </div>
        {incorrectPassword && <div className="error-message">Incorrect password. Please try again.</div>}
        <button type="submit">Login</button>
        <button type="button" onClick={handleSignUpClick}>Sign Up</button>
      </form>
    </div>
  );
};

export default Login;
