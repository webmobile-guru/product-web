import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PropertyDetailShortcutComponent } from './property-detail-shortcut.component';

describe('PropertyDetailShortcutComponent', () => {
  let component: PropertyDetailShortcutComponent;
  let fixture: ComponentFixture<PropertyDetailShortcutComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PropertyDetailShortcutComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PropertyDetailShortcutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
