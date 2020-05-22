import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators, ControlContainer } from '@angular/forms';

const DEMO_PARAMS = {
	EMAIL: 'admin@marc.com',
	PASSWORD: 'admin'
};

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  loading: boolean;

  constructor(
    private formBuilder: FormBuilder,
  ) { }

  ngOnInit() {
    this.initializeForm();
  }

  initializeForm() {
    this.loginForm = this.formBuilder.group({
      email: [DEMO_PARAMS.EMAIL, Validators.compose([
        Validators.required,
        Validators.email,
        Validators.maxLength(320)
      ])],
      password: [DEMO_PARAMS.PASSWORD, Validators.compose([
        Validators.required,
        Validators.maxLength(320)
      ])]
    })
  }

  submit() {
    const controls = this.loginForm.controls;

    if(this.loginForm.invalid) {
      Object.keys(controls).forEach(controlName => {
        controls[controlName].markAllAsTouched();
      });
      return;
    }

    this.loading = true;
    console.log('this is authData: ', this.loginForm.value)

  }

  isControlHasError(controlName: string, validationType: string): boolean {
		const control = this.loginForm.controls[controlName];
		if (!control) {
			return false;
		}

		const result = control.hasError(validationType) && (control.dirty || control.touched);
		return result;
	}
}
