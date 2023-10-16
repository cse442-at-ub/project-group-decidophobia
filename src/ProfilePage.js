import React, { useState } from 'react';
import './ProfilePage.css';

const ProfilePage = () => {
  const [userIcon, setUserIcon] = useState('path/to/default/icon');
  const [userName, setUserName] = useState('Test_name');
  const [userAbout, setUserAbout] = useState('Something about Test_name...');
  const [userEmail, setUserEmail] = useState('test@gmail.com');
  const [password, setPassword] = useState('test_password');
  const [newEmail, setNewEmail] = useState('test_email');
  const [preferences, setPreferences] = useState('test Preferences');

  const handleIconChange = (event) => {
    // Handle user icon change logic here
    // Update userIcon state accordingly
  };

  const handleUserNameChange = (event) => {
    setUserName(event.target.value);
  };

  const handleUserAboutChange = (event) => {
    setUserAbout(event.target.value);
  };

  const handleEmailChange = (event) => {
    setNewEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handlePreferencesChange = (event) => {
    setPreferences(event.target.value);
  };

  const handleSaveChanges = () => {
    // Handle saving changes to the server/database
  };
  const handleGoBack = () => {
    // Handle navigation back logic here
    console.log('Navigate back to the main page');
  };

  return (
    <div className="profile-page">
      <div className="header">
        <div className="left-header">
          Help Me Decide
        </div>
        <div className="right-header">
          <button onClick={handleGoBack}>Back</button>
        </div>
      </div>

      <div className="user-info">
        <div className="user-icon">
          <img src={userIcon} alt="User Icon" />
          <input type="file" onChange={handleIconChange} />
        </div>
        <div className="user-details">
          <input type="text" value={userName} onChange={handleUserNameChange} />
          <textarea value={userAbout} onChange={handleUserAboutChange} />
          <p>{userEmail}</p>
        </div>
      </div>

      <div className="sections">
        <div className="section">
          <h2>Password</h2>
          <p>{password}</p>
          <input type="password" value={password} onChange={handlePasswordChange} />
        </div>

        <div className="section">
          <h2>Email</h2>
          <p>{newEmail}</p>
          <input type="email" value={newEmail} onChange={handleEmailChange} />
        </div>

        <div className="section">
          <h2>Preferences</h2>
          <p>{preferences}</p>
          <textarea value={preferences} onChange={handlePreferencesChange} />
        </div>
      </div>

      <button onClick={handleSaveChanges}>Save Changes</button>
    </div>
  );
};

export default ProfilePage;
