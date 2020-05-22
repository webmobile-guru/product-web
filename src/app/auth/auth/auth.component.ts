import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.scss']
})
export class AuthComponent implements OnInit {

  backgroundImage = 'assets/images/section-4.jpg';
  constructor(
  ) { }

  ngOnInit() {
    
  }
}
