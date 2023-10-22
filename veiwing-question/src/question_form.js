import React, { useState } from 'react';

const QuestionForm = () => {
  // State variables to track the form input values
  const [question, setQuestion] = useState('');
  const [options, setOptions] = useState(['', '', '', '']);
  const [selectedColor, setSelectedColor] = useState('');

  // Function to handle changes in the options input fields
  const handleOptionChange = (index, value) => {
    const newOptions = [...options];
    newOptions[index] = value;
    setOptions(newOptions);
  };

  // Function to handle form submission
  const handleSubmit = (e) => {
    e.preventDefault();

    const newQuestion = {
      question,
      options,
      color: selectedColor,
      votes: 0, // Initialize votes to 0
    };

    console.log(newQuestion);

    setQuestion('');
    setOptions(['', '', '', '']);
    setSelectedColor('');
  };

  return (
    <div>
      <h2>Post a Question</h2>
      <form onSubmit={handleSubmit}>
        {/* Question input with rounded rectangle style */}
        <label htmlFor="question" className="rounded-input-label">
          Question:
        </label>
        <input
          type="text"
          id="question"
          value={question}
          onChange={(e) => setQuestion(e.target.value)}
          required
          className="rounded-input"
        />

        {/* Options input */}
        <label>Options:</label>
        {options.map((option, index) => (
          <input
            type="text"
            key={index}
            value={option}
            onChange={(e) => handleOptionChange(index, e.target.value)}
            required
          />
        ))}

        {/* Color selection */}
        <label>Select Color:</label>
        <div className="color-options">
          {['#FF5733', '#33FF57', '#5733FF', '#FFFF33', '#33FFFF', '#FF33FF', '#333333'].map(
            (color, index) => (
              <button
                key={index}
                className="color-button"
                style={{ backgroundColor: color }}
                onClick={() => setSelectedColor(color)}
              ></button>
            )
          )}
        </div>

        {/* Submit button */}
        <button type="submit">Submit</button>
      </form>
    </div>
  );
};

export default QuestionForm;