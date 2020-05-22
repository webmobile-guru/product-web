import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DatasheetDetailComponent } from './datasheet-detail.component';

describe('DatasheetDetailComponent', () => {
  let component: DatasheetDetailComponent;
  let fixture: ComponentFixture<DatasheetDetailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DatasheetDetailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DatasheetDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
