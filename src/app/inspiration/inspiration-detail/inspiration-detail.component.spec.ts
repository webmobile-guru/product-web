import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InspirationDetailComponent } from './inspiration-detail.component';

describe('InspirationDetailComponent', () => {
  let component: InspirationDetailComponent;
  let fixture: ComponentFixture<InspirationDetailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InspirationDetailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InspirationDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
