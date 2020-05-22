import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CustomSearchHeaderComponent } from './custom-search-header.component';

describe('CustomSearchHeaderComponent', () => {
  let component: CustomSearchHeaderComponent;
  let fixture: ComponentFixture<CustomSearchHeaderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [CustomSearchHeaderComponent]
    }).compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CustomSearchHeaderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
