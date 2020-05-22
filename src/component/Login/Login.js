import React from 'react';

import './Login.css';
import logo from '../../assets/img/logo.png';

const defaultPath = "/";

class Login extends React.Component {
 
  loggedin() {
    console.log('logged in the site!')
    this.props.history.push(`${defaultPath}main`);
  }

  render() {
    return (
      <div className="container-fluid px-0">
        <nav className="navbar navbar-light">
          <button className="navbar-toggler" type="button" data-toggle="collapse">
            <span className="navbar-toggler-icon"></span>
          </button>
        </nav>
        <div className="row justify-content-center mx-0 content">
          <div className="col-md-8 col-lg-3 col-sm-12">
            <div className="row justify-content-center">
              <div className="col-12">
                <label><h3>Welcome to Emothion Net</h3></label>
              </div>
              <div className="col-12 mb-3">
                <img src={logo} className="img-fluid" alt=""/>
              </div>
              <div className="col-12">
                <label>Enter your contact number</label>
                <input className="form-control p-2" placeholder="+8615210775584"></input>
              </div>
              <button className="mt-3 rounded" id="btlogin" onClick={() => this.loggedin()}><b>Log In</b></button>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Login;