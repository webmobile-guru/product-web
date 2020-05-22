import React from 'react';

import { Collapse } from 'reactstrap';

import './VideoView.css';
import video from '../../assets/img/video_upload.png';
import video_unselected from '../../assets/img/video_unselected.png';
import ColorViewModal from './../ColorView/ColorView';

const videoList = [
  {
    id: 41,
    image: video_unselected,
    title: "Fear"
  },
  {
    id: 42,
    image: video_unselected,
    title: "Anxious"
  },
  {
    id: 43,
    image: video_unselected,
    title: "Anxious"
  },
  {
    id: 44,
    image: video_unselected,
    title: "Insignificant"
  },
  {
    id: 45,
    image: video_unselected,
    title: "Fear"
  },
  {
    id: 46,
    image: video_unselected,
    title: "To Tag"
  },
  {
    id: 47,
    image: video_unselected,
    title: "To Tag"
  }
]

class Login extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      collapse: false,
      isEntering: false
    }
  }

  show = () => {
    this.setState(prev => ({
      collapse: !prev.collapse
    }))
  }

  onEntering = () => {
    this.setState(prev => ({
      isEntering: !prev.isEntering
    }))
  }

  onExiting = () => {
    this.setState(prev => ({
      isEntering: !prev.isEntering
    }))
  }

  onOpenModal = () => {
    this.setState({
      is_open: true
    })
  }

  onCloseModal = () => {
    this.setState({
      is_open: false
    })
  }

  render() {
    return (
      <div className="container-fluid px-0">
        <nav className="navbar navbar-light">
          <button className="navbar-toggler p-0" type="button" data-toggle="collapse">
            <span className="navbar-toggler-icon"></span>
          </button>
        </nav>
        <div className="row justify-content-center mx-0 min_height">
          <div className="col-md-10 col-sm-12">
            <div className="row">
              <div className="col-md-7 col-sm-12 p-0 m-0">

                <div className="row align-items-center title_bar mx-0 py-2 bg-white">

                  <div className="col-7" id="title_left">
                    <h4 className="m-0">Audi May 2019</h4>
                    <p className="m-0 my-2 progress-tag d-md-none">46/50 Tags Completed</p>
                  </div>

                  <div className="col-5 my-1 text-right" id="title_right">
                    <p className="mb-1 font-weight-bold">In Progress(92%)</p>
                    <p className="m-0 progress-tag d-none d-md-block">46/50 Tags Completed</p>
                    <div className="text-right">
                      <button type="button" className="btn btn-link p-0 d-md-none"><u>View List</u>&nbsp;<i className="fa fa-list-ul" aria-hidden="true"></i></button>
                      </div>
                    
                  </div>
                  
                </div>

                <div className="video p-0">
                  <img src={video} className="img-fluid" alt=""/>
                </div>
                <div className="tag-button border-bottom bg-white">
                  <div className="p-3">
                    <button className="btn btn-lg btn-block rounded" id="btn">
                      <b className="d-none d-md-block">Tag Video</b>
                      <div className="row align-items-center">
                        <div className="col  text-left">
                          <p className="d-md-none m-0"><b>Fear</b></p>
                        </div>
                        <div className="col text-right">
                          <h6 className="d-md-none"><u>Change Tag</u></h6>
                        </div>   
                      </div>                   
                    </button>
                  </div>
                </div>
                <div className="border-bottom p-3 bg-white">
                  <div className="row align-items-center">
                    <div className="col-6">
                      <h5 className="mb-0">About Video #46</h5>
                    </div>
                    {
                      !this.state.isEntering && (
                        <div className="col-6 text-right">
                          <button type="button" className="btn btn-link pr-0" onClick={() => this.show()}><u>Show More</u></button>
                        </div>
                      )
                    }
                  </div>
                  <Collapse isOpen={this.state.collapse} onEntering={this.onEntering} onExiting={this.onExiting}>
                    <label className="">title</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">timestamp</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">Utterance</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">Speaker</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">Speaker Gender</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">Chip ID</label>
                    <input className="px-2 mb-1 form-control"/>

                    <label className="">Personal Notes</label>
                    <input className="px-2 mb-1 form-control" placeholder="Add a note"/>

                    <div className="text-right my-3"><button className="btn btn-outline-warning border-3">Save note</button></div>
                  </Collapse>
                  {
                    this.state.isEntering && (
                      <div className="text-center">
                        <button className="btn btn-link pr-0" onClick={() => this.show()}>Show Less</button>
                      </div>
                    )
                  }
                </div>
              </div>
              <div className="col-md-5 col-sm-12 list-col">
                <div className="list">

                  <div className="row list-title m-0">
                    <div className="col-12">
                      <h5 className="my-3">Project List</h5>
                    </div>
                  </div>

                  {
                    videoList.map((item, index) => {
                      return (
                        <div className="row m-0 border-bottom list-item" onClick={() => this.onOpenModal()} key={index}>
                          <div className="col-12">
                            <div className="row align-items-center m-0 my-3">
                              <div className="col-1.5">
                                <span className="circle mr-2">{item.id}</span>
                              </div>
                              <div className="col-4 pl-0">
                                <img src={item.image} className="img-fluid" alt=""/>
                              </div>
                              <div className="col-6.5 ml-2 align-items-center">
                                <h6>{item.title}</h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      )
                    })
                  }
                </div>
              </div>
            </div>
          </div>
        </div>
        <ColorViewModal isOpen={this.state.is_open} onClose={() => this.onCloseModal()}></ColorViewModal>
      </div>
    );
  }
}

export default Login;