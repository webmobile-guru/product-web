import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-blog-detail',
  templateUrl: './blog-detail.component.html',
  styleUrls: ['./blog-detail.component.scss']
})
export class BlogDetailComponent implements OnInit {

  newCommentForm: FormGroup;
  loading : boolean;

  constructor(
    private formBuilder: FormBuilder,
    private activatedRoute: ActivatedRoute
  ) { }

  ngOnInit() {
    this.initializeForm();
    this.activatedRoute.params.subscribe(params => {
      console.log('this is blog detail id: ', params['id']); // Print the parameter to the console. 
    });

    
  }

  initializeForm() {
    this.newCommentForm = this.formBuilder.group({
      username: ['', Validators.compose([
        Validators.required
      ])],
      email: ['', Validators.compose([
        Validators.required,
        Validators.email
      ])],
      comment: ['', Validators.compose([
        Validators.required
      ])]
    })
  }

  submit() {
    const controls = this.newCommentForm.controls;

    if(this.newCommentForm.invalid) {
      Object.keys(controls).forEach(controlName => {
        controls[controlName].markAllAsTouched();
      });
      return;
    }

    this.loading = true;
    console.log('this is authData: ', this.newCommentForm.value)

  }

  isControlHasError(controlName: string, validationType: string): boolean {
		const control = this.newCommentForm.controls[controlName];
		if (!control) {
			return false;
		}

		const result = control.hasError(validationType) && (control.dirty || control.touched);
		return result;
	}

}
