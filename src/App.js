import React from 'react';
import styled from 'styled-components';

import './App.css';
const Wrapper = styled.section`
  width: 100vw;
  height: 100vh;
`;

const App = ({ children }) => (
  <Wrapper>
    {children}
  </Wrapper>
);

export default App;


