import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RelativeItemsComponent } from './relative-items.component';

describe('RelativeItemsComponent', () => {
  let component: RelativeItemsComponent;
  let fixture: ComponentFixture<RelativeItemsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RelativeItemsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RelativeItemsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
