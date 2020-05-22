import React from 'react';
import ReactDOM from 'react-dom';
import { Route, Switch, Redirect, BrowserRouter as Router } from 'react-router-dom';
import './index.css';
import App from './App';
import Login from './component/Login/Login.js';
import VideoView from './component/VideoView/VideoView.js';
import * as serviceWorker from './serviceWorker';

const defaultPath = "/";

ReactDOM.render(
    <Router>
      <App>
        <Switch>
          <Route exact path={defaultPath} component={Login} />
          {/* New examples here */}
          <Route path={`${defaultPath}main`} component={VideoView} />
          <Redirect exact from="*" to={defaultPath} />
        </Switch>
      </App>
    </Router>,
    document.getElementById('root'),
  );

serviceWorker.unregister();

