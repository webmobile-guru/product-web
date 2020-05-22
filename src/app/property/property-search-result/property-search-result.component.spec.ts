import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PropertySearchResultComponent } from './property-search-result.component';

describe('PropertySearchResultComponent', () => {
  let component: PropertySearchResultComponent;
  let fixture: ComponentFixture<PropertySearchResultComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [PropertySearchResultComponent]
    }).compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PropertySearchResultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
