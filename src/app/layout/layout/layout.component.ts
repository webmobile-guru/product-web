import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { style } from '@angular/animations';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnInit {

  newLayoutForm: FormGroup;
  loading: boolean;

  // layout type select settings
  layoutTypeList = [
    { id: 1, name: "style1" },
    { id: 2, name: "style2" },
    { id: 3, name: "style3" },
  ];

  selectedLayoutType = [
    { id: 1, name: "style1" },
  ];

  closeDropdownSelection = false;

  layoutDropdownSettings = {
    singleSelection: true,
    idField: 'id',
    textField: 'name',
    selectAllText: 'Select All',
    unSelectAllText: 'UnSelect All',
    allowSearchFilter: true,
    closeDropDownOnSelection: this.closeDropdownSelection
  };

  disabled = false;

  // used items select setting

  usedItemsList = [
    { id: 1, name: 'Mumbai' },
    { id: 2, name: 'Bangaluru' },
    { id: 3, name: 'Pune' },
    { id: 4, name: 'Navsari' },
    { id: 5, name: 'New Delhi' }
  ];

  selectedUsedItems = [
    { id: 3, name: 'Pune' },
    { id: 4, name: 'Navsari' }
  ];

  usedItemsDropDownSettings: IDropdownSettings = {
    singleSelection: false,
    idField: 'id',
    textField: 'name',
    selectAllText: 'Select All',
    unSelectAllText: 'UnSelect All',
    itemsShowLimit: 4,
    allowSearchFilter: true
  }

  imageURL: string;

  constructor(
    private fromBuilder: FormBuilder,
    private cd: ChangeDetectorRef
  ) { }

  ngOnInit() {
    this.initializeForm();
  }

  initializeForm() {
    this.newLayoutForm = this.fromBuilder.group({
      layoutType: [this.selectedLayoutType, Validators.compose([
        Validators.required
      ])],
      usedItems: [this.selectedUsedItems, Validators.compose([
        Validators.required
      ])],
      description: ['', Validators.compose([
        Validators.required
      ])],
      layoutImages: [null, Validators.compose([
        Validators.required
      ])]
    })
  }

  onItemSelect(item: any) {
    console.log('onItemSelect', this.selectedLayoutType, this.selectedUsedItems);
  }

  // Image Preview
  showPreview(event) {
    const file = (event.target as HTMLInputElement).files[0];
    this.newLayoutForm.patchValue({
      layoutImages: file
    });
    this.newLayoutForm.get('layoutImages').updateValueAndValidity()

    // File Preview
    const reader = new FileReader();
    reader.onload = () => {
      this.imageURL = reader.result as string;
    }
    reader.readAsDataURL(file)
  }

  onFileChange(event, field) {
    if (event.target.files && event.target.files.length) {
      console.log('image is uploaded')
      const [file] = event.target.files;
      // just checking if it is an image, ignore if you want
      if (!file.type.startsWith('image')) {
        this.newLayoutForm.get(field).setErrors({
          required: true
        });
        this.cd.markForCheck();
      } else {
        // unlike most tutorials, i am using the actual Blob/file object instead of the data-url
        this.newLayoutForm.patchValue({
          [field]: file
        });
        // need to run CD since file load runs outside of zone
        this.cd.markForCheck();
      }
      // File Preview
      const reader = new FileReader();
      reader.onload = () => {
        this.imageURL = reader.result as string;
        console.log('this is iamge Url: ', this.imageURL)
      }
      reader.readAsDataURL(file[0])
    }
  }

  submit() {
    const controls = this.newLayoutForm.controls;
    console.log('new layout create value: ', this.newLayoutForm.value)
    if(this.newLayoutForm.invalid) {
      Object.keys(controls).forEach(controlName => {
        controls[controlName].markAllAsTouched();
      });
      return;
    }
  }
  
  isControlHasError(controlName: string, validationType: string): boolean {
		const control = this.newLayoutForm.controls[controlName];
		if (!control) {
			return false;
		}

		const result = control.hasError(validationType) && (control.dirty || control.touched);
		return result;
	}
}
