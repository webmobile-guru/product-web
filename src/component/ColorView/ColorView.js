import React from 'react';
import { Modal, ModalHeader, ModalBody } from 'reactstrap';

import './ColorView.css';
import check from './../../assets/img/check.png';

const cells = [
  {
    color: "#f6b3a5",
    name: "Happy"
  },
  {
    color: "#f4917b",
    name: "Passionate"
  },
  {
    color: "#f36e52",
    name: "Love"
  },
  {
    color: "#f9f4bf",
    name: "Confident"
  },
  {
    color: "#faef82",
    name: "Proud"
  },
  {
    color: "#fded56",
    name: "Charisma"
  },
  {
    color: "#b5d9aa",
    name: "Curious"
  },
  {
    color: "#93c882",
    name: "Acceptance"
  },
  {
    color: "#71b95a",
    name: "Trust"
  },
  {
    color: "#bbb1c5",
    name: "Relaxed"
  },
  {
    color: "#9c8eab",
    name: "Peaceful"
  },
  {
    color: "#7f6b93",
    name: "Sleepy"
  },
  {
    color: "#d1aca9",
    name: "Irritated"
  },
  {
    color: "#be8482",
    name: "Angry"
  },
  {
    color: "#aa5e5b",
    name: "Furious"
  },
  {
    color: "#b1afa5",
    name: "Concerned"
  },
  {
    color: "#8d8b7a",
    name: "Fear"
  },
  {
    color: "#6c6752",
    name: "Anxious"
  },
  {
    color: "#cbcbcb",
    name: "Uncertain"
  },
  {
    color: "#b5b5b5",
    name: "Embarrassed"
  },
  {
    color: "#9f9f9f",
    name: "Insignificant"
  },
  {
    color: "#aacad2",
    name: "Lonely"
  },
  {
    color: "#83b2bf",
    name: "Sad"
  },
  {
    color: "#5d9bad",
    name: "Depressed"
  }
]; 

class ColorViewModal extends React.Component{
  constructor(props) {
    super(props);
    this.state = {
      modal : false,
      selected_name: "",
      selected_color : []
    }
    this.state.selected_color.length = 30;
    for (var i = 0; i< this.state.selected_color.length; i++) {
      this.state.selected_color[i] = false;
    }
  }

  selectColor = (index, cell) => {
    var temp = this.state.selected_color;
    temp[index] = !temp[index];
    this.setState(prev => ({
      selected_name: cell.name,
      selected_color: temp
    }))
  }

  closeBtn = <button className="close close-btn" onClick={this.props.onClose}>&times;</button>;

  render() {
    return (
      <div>
        <Modal isOpen={this.props.isOpen} toggle={this.props.onClose}>
          <ModalHeader toggle={this.props.onClose} close={this.closeBtn}>{this.state.selected_name}</ModalHeader>

          <ModalBody className="mymodal-body">
            <div className="container">
              <div className="row">
                {
                  cells.map((cell, index) => {
                    return (
                      <div className="col-4" key={index} onClick={() => this.selectColor(index, cell)}>
                        <div className="text-center" style={{backgroundColor: cell.color}}>
                          <label className="my-cell">{cell.name}</label>
                          {
                            this.state.selected_color[index] && (
                              <img src={check} alt="" className="check-icon"></img>
                            )
                          }
                        </div>
                      </div>
                    )
                  })
                }
              </div>   
            </div>
          </ModalBody>
        </Modal>
      </div>
    );
  }
}

export default ColorViewModal;