import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LayoutListImagesComponent } from './layout-list-images.component';

describe('LayoutListImagesComponent', () => {
  let component: LayoutListImagesComponent;
  let fixture: ComponentFixture<LayoutListImagesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LayoutListImagesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LayoutListImagesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
